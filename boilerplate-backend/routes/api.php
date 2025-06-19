<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
Route::post('/verify-email', [EmailVerificationController::class, 'verify']);
Route::post('/resend-verification', [EmailVerificationController::class, 'resend']);

// Public settings route
Route::get('/settings/public', [SettingsController::class, 'getPublicSettings']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::post('/image', [ProfileController::class, 'uploadImage']);
        Route::delete('/image', [ProfileController::class, 'removeImage']);
        Route::put('/password', [ProfileController::class, 'changePassword']);
    });

    // 2FA routes
    Route::prefix('2fa')->group(function () {
        Route::get('/status', [ProfileController::class, 'getTwoFactorStatus']);
        Route::post('/enable', [ProfileController::class, 'enableTwoFactor']);
        Route::post('/confirm', [ProfileController::class, 'confirmTwoFactor']);
        Route::delete('/disable', [ProfileController::class, 'disableTwoFactor']);
        Route::delete('/enable', [ProfileController::class, 'cancelTwoFactorSetup']);
        Route::get('/qr-code', [ProfileController::class, 'generateQrCode']);
    });

    // Admin routes - Super Admin only
    Route::middleware('role:super-admin')->prefix('admin')->group(function () {
        // User management routes
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/stats', [UserController::class, 'stats']);
            Route::get('/export', [UserController::class, 'export']);
            Route::post('/bulk-action', [UserController::class, 'bulkAction']);
            Route::get('/{user}', [UserController::class, 'show']);
            Route::put('/{user}', [UserController::class, 'update']);
            Route::delete('/{user}', [UserController::class, 'destroy']);
        });

        // Settings routes
        Route::prefix('settings')->group(function () {
            Route::get('/', [SettingsController::class, 'index']);
            Route::get('/{group}', [SettingsController::class, 'getByGroup']);
            Route::put('/', [SettingsController::class, 'update']);
            Route::post('/reset', [SettingsController::class, 'reset']);
        });
    });
});
