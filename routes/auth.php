<?php

use App\Http\{Controllers\Auth\AuthenticatedSessionController,
    Controllers\Auth\ConfirmablePasswordController,
    Controllers\Auth\EmailVerificationNotificationController,
    Controllers\Auth\EmailVerificationPromptController,
    Controllers\Auth\NewPasswordController,
    Controllers\Auth\PasswordController,
    Controllers\Auth\PasswordResetLinkController,
    Controllers\Auth\RegisteredUserController,
    Controllers\Auth\VerifyEmailController};
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('inscription', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('inscription', [RegisteredUserController::class, 'store']);

    Route::get('connexion', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('connexion', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verification-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verification-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
