<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/register', RegisterUserController::class);
    Route::post('/login', [AuthenticatedUserController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedUserController::class, 'destroy']);
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//     ->middleware('guest')
//     ->name('password.email');

// Route::post('/reset-password', [NewPasswordController::class, 'store'])
//     ->middleware('guest')
//     ->name('password.store');
