# Notification System Setup Guide

This guide will help you set up the complete notification system for your boilerplate application.

## 🎯 Overview

The notification system supports:
- **Database notifications** (stored in database)
- **Email notifications** (SMTP)
- **Push notifications** (PWA + WebSockets)
- **Real-time updates** (WebSocket connections)

## 📋 Prerequisites

1. **WebPush Package**: Already installed (`minishlink/web-push`)
2. **Laravel Broadcasting**: Configured for real-time notifications
3. **VAPID Keys**: Required for push notifications

## 🚀 Setup Steps

### 1. Generate VAPID Keys

Run the command to generate VAPID keys for WebPush:

```bash
cd boilerplate-backend
php artisan webpush:vapid
```

Add the generated keys to your `.env` file:

```env
VAPID_PUBLIC_KEY=your_public_key_here
VAPID_PRIVATE_KEY=your_private_key_here
VAPID_SUBJECT=http://localhost:8000
```

### 2. Configure Broadcasting

Update your `.env` file for broadcasting:

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Seed the Database

```bash
php artisan db:seed
```

This will create:
- Default users (admin@example.com, user@example.com)
- System settings
- Notification preferences for all users

## 🔧 Configuration

### Email Configuration

Update your `.env` file for email notifications:

```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourapp.com
MAIL_FROM_NAME="${APP_NAME}"
```

### WebSocket Configuration

For development, you can use Laravel WebSockets or Pusher:

#### Option 1: Laravel WebSockets (Recommended for development)

```bash
composer require beyondcode/laravel-websockets
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
```

Update `config/broadcasting.php`:

```php
'pusher' => [
    'driver' => 'pusher',
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'app_id' => env('PUSHER_APP_ID'),
    'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'encrypted' => true,
        'host' => '127.0.0.1',
        'port' => 6001,
        'scheme' => 'http'
    ],
],
```

#### Option 2: Pusher (Production)

Use Pusher's free tier for development or paid plans for production.

## 📱 Frontend Setup

### 1. Install Dependencies

```bash
cd boilerplate-frontend
npm install laravel-echo pusher-js
```

### 2. Configure Echo

Update your `src/boot/echo.js`:

```javascript
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: false,
  wsHost: window.location.hostname,
  wsPort: 6001,
  forceTLS: false,
  disableStats: true,
})
```

### 3. Add Environment Variables

Add to your frontend `.env`:

```env
VITE_PUSHER_APP_KEY=your_app_key
VITE_PUSHER_APP_CLUSTER=mt1
VITE_VAPID_PUBLIC_KEY=your_vapid_public_key
```

### 4. Service Worker for Push Notifications

Create `public/sw.js`:

```javascript
self.addEventListener('push', function(event) {
  const data = event.data.json()
  
  const options = {
    body: data.body,
    icon: data.icon,
    badge: data.badge,
    data: data.data,
    actions: [
      {
        action: 'open',
        title: 'Open',
        icon: '/icons/icon-128x128.png'
      },
      {
        action: 'close',
        title: 'Close',
        icon: '/icons/icon-128x128.png'
      }
    ]
  }

  event.waitUntil(
    self.registration.showNotification(data.title, options)
  )
})

self.addEventListener('notificationclick', function(event) {
  event.notification.close()
  
  if (event.action === 'open') {
    event.waitUntil(
      clients.openWindow('/')
    )
  }
})
```

## 🔄 Usage Examples

### Sending Notifications

#### From Controller

```php
use App\Services\NotificationService;

class SomeController extends Controller
{
    public function someMethod(NotificationService $notificationService)
    {
        // Send to specific users
        $notificationService->send(
            title: 'Welcome!',
            message: 'Welcome to our application!',
            type: 'info',
            userIds: [1, 2, 3]
        );

        // Send to all users
        $notificationService->send(
            title: 'System Maintenance',
            message: 'Scheduled maintenance in 30 minutes.',
            type: 'warning',
            urgent: true
        );
    }
}
```

#### From Command

```php
use App\Services\NotificationService;

class SomeCommand extends Command
{
    public function handle(NotificationService $notificationService)
    {
        $notificationService->send(
            title: 'Daily Report',
            message: 'Your daily report is ready.',
            type: 'info',
            scheduledAt: now()->addMinutes(5)
        );
    }
}
```

### Frontend Integration

#### Listen for Real-time Notifications

```javascript
// Listen for user-specific notifications
Echo.private(`user.${userId}`)
  .listen('NotificationSent', (e) => {
    console.log('New notification:', e)
    // Update UI, show toast, etc.
  })

// Listen for global notifications
Echo.channel('notifications')
  .listen('GlobalNotification', (e) => {
    console.log('Global notification:', e)
    // Update UI, show toast, etc.
  })
```

#### Request Push Permission

```javascript
async function requestNotificationPermission() {
  if ('Notification' in window) {
    const permission = await Notification.requestPermission()
    
    if (permission === 'granted') {
      // Register service worker
      const registration = await navigator.serviceWorker.register('/sw.js')
      
      // Subscribe to push notifications
      const subscription = await registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: import.meta.env.VITE_VAPID_PUBLIC_KEY
      })
      
      // Send subscription to backend
      await api.post('/push-subscriptions', subscription)
    }
  }
}
```

## 🧪 Testing

### Test Email Notifications

```bash
# Use Mailtrap or similar for testing
php artisan tinker
```

```php
use App\Services\NotificationService;
$service = app(NotificationService::class);
$service->send('Test', 'This is a test email', 'info', [1]);
```

### Test Push Notifications

1. Enable push notifications in browser
2. Send a notification via admin panel
3. Check browser console for WebSocket events

### Test Real-time Updates

1. Open multiple browser tabs
2. Send a notification from one tab
3. Verify it appears in other tabs

## 🔒 Security Considerations

1. **VAPID Keys**: Keep private key secure
2. **WebSocket Authentication**: Channels are protected
3. **Rate Limiting**: Implement on notification endpoints
4. **Input Validation**: All inputs are validated
5. **User Permissions**: Only admins can send notifications

## 🚨 Troubleshooting

### Common Issues

1. **Push notifications not working**
   - Check VAPID keys are correct
   - Verify service worker is registered
   - Check browser console for errors

2. **WebSocket connection failed**
   - Verify broadcasting configuration
   - Check Pusher/Laravel WebSockets is running
   - Ensure CORS is configured properly

3. **Email not sending**
   - Check SMTP configuration
   - Verify mail credentials
   - Check mail logs

### Debug Commands

```bash
# Check notification stats
php artisan tinker
>>> app(App\Services\NotificationService::class)->getStats()

# Test WebSocket connection
php artisan websockets:serve

# Clear notification cache
php artisan cache:clear
```

## 📚 Additional Resources

- [Laravel Broadcasting Documentation](https://laravel.com/docs/broadcasting)
- [WebPush Protocol](https://tools.ietf.org/html/rfc8030)
- [PWA Push Notifications](https://web.dev/push-notifications/)
- [Laravel WebSockets](https://beyondco.de/docs/laravel-websockets/)

---

**Next Steps**: 
1. Run the setup commands
2. Test the notification system
3. Integrate with your frontend
4. Customize notification templates
5. Set up monitoring and logging 