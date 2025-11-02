<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPassword;
use App\Http\Controllers\Auth\EmailVerificationController;

Route::middleware(['guest'])->group(function () {
    Route::post('/signup', [RegisterController::class, 'store'])->name('auth.signup.store');
    Route::post('/signin', [LoginController::class, 'signin'])->name('auth.signin');

    Route::post('/forgot-password', [ResetPassword::class, 'ForgotPassword'])->name('auth.password.forgot');
    Route::get('/password/reset/{token}', [ResetPassword::class, 'ResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPassword::class, 'ResetPassword'])->name('auth.password.reset');

    Route::get('/google/redirect', [RegisterController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/google/callback', [RegisterController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [RegisterController::class, 'logout'])->name('auth.logout');

    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->name('verification.verify')
        ->middleware(['signed']);


    Route::post('/email/resend', [EmailVerificationController::class, 'resend'])
        ->name('auth.verification.resend')
        ->middleware(['throttle:6,1']);
});
