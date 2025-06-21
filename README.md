# 🚀 Modern Full-Stack Boilerplate

> **Quasar Framework + Laravel** - A production-ready, feature-rich boilerplate for modern web applications

[![Quasar](https://img.shields.io/badge/Quasar-2.0+-1976D2?style=for-the-badge&logo=quasar)](https://quasar.dev/)
[![Laravel](https://img.shields.io/badge/Laravel-10+-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com/)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.0+-4FC08D?style=for-the-badge&logo=vue.js)](https://vuejs.org/)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

A comprehensive, production-ready boilerplate featuring **authentication**, **admin dashboard**, **real-time notifications**, **theme customization**, **2FA**, and much more. Perfect for startups, agencies, and developers who want to focus on building features, not infrastructure.

## ✨ Features Overview

### 🔐 **Authentication & Security**
- **Complete Auth System**: Login, Register, Password Reset, Email Verification
- **Two-Factor Authentication**: Google Authenticator integration
- **Role-Based Access Control**: Super Admin & User roles with middleware
- **JWT Token Authentication**: Laravel Sanctum for secure API access
- **CSRF Protection**: Built-in security measures
- **Input Validation**: Comprehensive form validation
- **Session Management**: Secure session handling

### 🎨 **UI/UX & Theming**
- **Modern Design**: Clean, responsive interface with Shadcn UI inspiration
- **Dynamic Theme System**: Customizable primary colors with real-time updates
- **Dark/Light Mode**: Persistent theme preferences with system mode support
- **Responsive Design**: Mobile-first approach with Quasar components
- **Loading States**: Smooth loading animations and skeleton screens
- **Toast Notifications**: User-friendly feedback system

### 📊 **Admin Dashboard**
- **Analytics Dashboard**: User statistics, growth charts, activity metrics
- **User Management**: CRUD operations with bulk actions and export
- **System Settings**: Dynamic configuration with real-time updates
- **Activity Logs**: Comprehensive audit trail with filtering
- **Notification Management**: Admin notification system
- **Maintenance Mode**: System maintenance with admin bypass

### 🔔 **Real-Time Notifications**
- **Database Notifications**: Persistent notification storage
- **Email Notifications**: SMTP integration with templates
- **Push Notifications**: PWA support with service worker
- **Real-Time Updates**: WebSocket integration with Laravel Echo
- **Notification Preferences**: User-customizable settings
- **Unread Count**: Real-time badge updates

### 👤 **User Management**
- **Profile Management**: Avatar upload, personal info, password change
- **User Dashboard**: Personalized dashboard with activity tracking
- **Activity Logging**: User action tracking and history
- **File Upload**: Secure profile image handling
- **Account Settings**: User preferences and configurations

### 🛠️ **Developer Experience**
- **JavaScript**: Modern ES6+ JavaScript with Vue 3 Composition API
- **State Management**: Pinia stores for reactive state
- **API Integration**: Axios with interceptors and error handling
- **Route Guards**: Protected routes with role-based access
- **Error Handling**: Comprehensive error boundaries and fallbacks
- **Code Splitting**: Optimized bundle splitting
- **Hot Reload**: Fast development with hot module replacement

### 📱 **PWA Features**
- **Service Worker**: Offline support and caching
- **Push Notifications**: Native-like notification experience
- **App Manifest**: Installable web app
- **Offline Support**: Basic offline functionality

## 🏗️ Architecture

### Frontend (Quasar Framework)
```
boilerplate-frontend/
├── src/
│   ├── pages/           # Vue pages and routing
│   ├── layouts/         # Layout components
│   ├── stores/          # Pinia state management
│   ├── components/      # Reusable components
│   ├── router/          # Vue router configuration
│   ├── boot/            # App initialization
│   ├── css/             # Global styles and variables
│   └── services/        # API services and utilities
```

### Backend (Laravel)
```
boilerplate-backend/
├── app/
│   ├── Http/Controllers/    # API controllers
│   ├── Models/             # Eloquent models
│   ├── Services/           # Business logic
│   └── Middleware/         # Custom middleware
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/           # Initial data
└── routes/
    └── api.php            # API routes
```

## 🚀 Quick Start

### Prerequisites
- **Node.js** (v16+)
- **PHP** (v8.1+)
- **Composer**
- **MySQL** (v8.0+) or **PostgreSQL**
- **Git**

### 1. Clone & Install
```bash
git clone <repository-url>
cd Boilerplate

# Backend setup
cd boilerplate-backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

# Frontend setup
cd ../boilerplate-frontend
npm install
```

### 2. Create Frontend .env File
Create a `.env` file in the `boilerplate-frontend` directory with the following content:
```env
VITE_API_URL=http://localhost:8000/api
# For notifications (if using real-time features):
VITE_PUSHER_APP_KEY=your_app_key
VITE_PUSHER_APP_CLUSTER=mt1
VITE_VAPID_PUBLIC_KEY=your_vapid_public_key
```

### 3. Configure Backend Environment
```env
# Backend (.env)
DB_DATABASE=boilerplate
DB_USERNAME=root
DB_PASSWORD=your_password

# Frontend (.env)
VITE_API_URL=http://localhost:8000/api
```

### 4. Run Development Servers
```bash
# Backend (Terminal 1)
cd boilerplate-backend
php artisan serve

# Frontend (Terminal 2)
cd boilerplate-frontend
quasar dev
```

### 5. Access the Application
- **Frontend**: http://localhost:9000
- **Backend API**: http://localhost:8000/api

## 🔔 Notification System Setup

### Prerequisites
The notification system requires additional setup for full functionality:

#### Backend Dependencies (Already Installed)
```bash
# These packages are already included in composer.json
minishlink/web-push          # Push notification support
pragmarx/google2fa           # Two-factor authentication
simplesoftwareio/simple-qrcode # QR code generation
```

#### Frontend Dependencies (Already Installed)
```bash
# These packages are already included in package.json
axios                        # API communication
qrcode                       # QR code display
jsotp                        # OTP generation
```

### 1. Generate VAPID Keys for Push Notifications
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

### 2. Configure Email Settings
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

### 3. Configure Broadcasting (Optional - for Real-time)
For real-time notifications, configure broadcasting in `.env`:
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

### 4. Frontend Environment Variables
Add to your frontend `.env`:
```env
VITE_PUSHER_APP_KEY=your_app_key
VITE_PUSHER_APP_CLUSTER=mt1
VITE_VAPID_PUBLIC_KEY=your_vapid_public_key
```

### 5. Service Worker Setup
The service worker for push notifications is already included in the frontend. Ensure it's accessible at `/sw.js` in your public directory.

### 6. Test Notifications
```bash
# Test email notifications
php artisan tinker
>>> app(App\Services\NotificationService::class)->send('Test', 'This is a test email', 'info', [1]);

# Test push notifications
# Enable push notifications in browser and send via admin panel
```

## 👥 Default Users

| Role | Email | Password |
|------|-------|----------|
| **Super Admin** | admin@example.com | password |
| **Regular User** | user@example.com | password |

## 📋 Feature Details

### 🔐 Authentication System
- **Login/Register**: Complete authentication flow
- **Email Verification**: Built-in verification system
- **Password Reset**: Secure password recovery
- **2FA Setup**: Google Authenticator integration
- **Session Management**: Automatic token refresh
- **Route Protection**: Role-based access control

### 🎨 Theme Customization
- **Dynamic Colors**: Real-time theme color updates
- **CSS Variables**: Easy customization system
- **Dark/Light Mode**: Persistent theme preferences
- **System Mode**: Automatic system theme detection
- **Theme Persistence**: localStorage caching with version control

### 📊 Admin Features
- **User Analytics**: Growth charts and statistics
- **User Management**: Full CRUD with search and filters
- **System Settings**: Dynamic configuration management
- **Activity Logs**: Comprehensive audit trail
- **Notification Center**: Admin notification system
- **Maintenance Mode**: System maintenance controls

### 🔔 Notification System
- **Real-Time**: WebSocket integration
- **Push Notifications**: PWA support
- **Email Notifications**: SMTP integration
- **Database Storage**: Persistent notification history
- **User Preferences**: Customizable notification settings
- **Admin Notifications**: System-wide notification management

### 👤 User Features
- **Personal Dashboard**: User-specific analytics
- **Profile Management**: Avatar upload and settings
- **Activity Tracking**: Personal activity history
- **Notification Center**: User notification management
- **Account Settings**: User preferences and security

## 🔧 API Endpoints

### Public Routes
```http
POST /api/login                    # User authentication
POST /api/register                 # User registration
POST /api/forgot-password          # Password reset request
POST /api/reset-password           # Password reset
POST /api/verify-email             # Email verification
GET  /api/settings/public          # Public settings
GET  /api/settings/theme           # Theme settings (authenticated)
```

### Protected Routes
```http
GET  /api/user                     # Current user info
PUT  /api/profile                  # Update profile
GET  /api/activity                 # User activity
GET  /api/notifications/*          # User notifications
GET  /api/2fa/*                    # 2FA management
```

### Admin Routes (Super Admin)
```http
GET  /api/admin/dashboard/*        # Dashboard analytics
GET  /api/admin/users/*            # User management
GET  /api/admin/settings/*         # System settings
GET  /api/admin/logs/*             # Activity logs
GET  /api/admin/notifications/*    # Admin notifications
```

## 🎨 Customization

### Theme Colors
```css
:root {
  --q-primary: #6B8E23;           /* Primary brand color */
  --q-secondary: #26A69A;         /* Secondary color */
  --q-accent: #9C27B0;            /* Accent color */
  --q-background: #ffffff;        /* Background color */
  --q-text: #111827;              /* Text color */
}
```

### Adding New Features
1. **Backend**: Create controllers, models, and migrations
2. **Frontend**: Add pages, components, and store modules
3. **Routes**: Update API routes and frontend router
4. **Permissions**: Add role-based access control

## 📱 PWA Features

### Push Notifications
- **VAPID Keys**: WebPush integration
- **Service Worker**: Background notification handling
- **User Permissions**: Granular notification controls
- **Notification Actions**: Interactive notification buttons

### Offline Support
- **Service Worker**: Caching strategies
- **Offline Pages**: Basic offline functionality
- **Background Sync**: Offline data synchronization

## 🔒 Security Features

### Authentication Security
- **JWT Tokens**: Secure API authentication
- **CSRF Protection**: Cross-site request forgery protection
- **Input Validation**: Comprehensive form validation
- **SQL Injection Protection**: Eloquent ORM with parameter binding
- **XSS Protection**: Output sanitization

### Data Protection
- **Role-Based Access**: Granular permission system
- **Activity Logging**: Comprehensive audit trail
- **File Upload Security**: Secure file handling
- **Session Security**: Secure session management

## 🚀 Deployment

### Frontend Build
```bash
cd boilerplate-frontend
quasar build
```

### Backend Deployment
```bash
cd boilerplate-backend
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Environment Setup
```env
APP_ENV=production
APP_DEBUG=false
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## 🐛 Troubleshooting

### Common Issues
- **Port conflicts**: Change ports in configuration files
- **Database connection**: Verify database credentials
- **Permission errors**: Set proper file permissions
- **Cache issues**: Clear Laravel cache

### Notification Issues
- **Push notifications not working**: Check VAPID keys and service worker
- **Email not sending**: Verify SMTP configuration
- **WebSocket connection failed**: Check broadcasting configuration

### Debug Mode
```env
APP_DEBUG=true
```

## 📝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Support

- 📧 **Email**: Create an issue in the repository
- 💬 **Discussions**: Use GitHub Discussions
- 📖 **Documentation**: Check the code comments and examples
- 🐛 **Bug Reports**: Use GitHub Issues

## 🙏 Acknowledgments

- **Quasar Framework** for the amazing Vue.js framework
- **Laravel** for the robust PHP framework
- **Vue.js** for the reactive frontend framework
- **Pinia** for state management
- **Laravel Sanctum** for API authentication
- **WebPush** for push notification support
- **Google2FA** for two-factor authentication

---

**Built with ❤️ for the developer community**

⭐ **Star this repository if you find it helpful!** 