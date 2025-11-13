<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CashoutController;
use App\Http\Controllers\Dashboard\AffiliateController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\DailyBonusController;
use App\Http\Controllers\Dashboard\CryptoController;
use App\Http\Controllers\Dashboard\BitLabsController;
use App\Http\Controllers\Dashboard\LootBoxController;
use App\Http\Controllers\Dashboard\MonlixController;
use App\Http\Controllers\Dashboard\AchievementController;
use App\Http\Controllers\Dashboard\PushNotificationController;
use App\Http\Controllers\Dashboard\TierController;

// Public routes
Route::middleware('guest')->group(function () {
    Route::get('/', [SiteController::class, 'index'])->name('home');
});

// Authentication routes
Route::controller(AuthController::class)
    ->name('auth.')
    ->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/forgot-password', 'forgotPassword')->name('password.request');
        Route::post('/forgot-password', 'sendResetLink')->name('password.email');
        Route::get('/reset-password/{token}', 'resetPassword')->name('password.reset');
        Route::post('/reset-password', 'updatePassword')->name('password.update');
        Route::post('/verify-email/resend', 'resendVerificationEmail')->name('verification.resend');
        Route::get('/email/verify/{id}/{hash}', 'verifyEmail')->name('verification.verify');
    });

// OAuth Routes  
use App\Http\Controllers\Auth\RegisterController;

Route::get('/google/redirect', [RegisterController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [RegisterController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/discord/redirect', [RegisterController::class, 'redirectToDiscord'])->name('discord.redirect');
Route::get('/discord/callback', [RegisterController::class, 'handleDiscordCallback'])->name('discord.callback');

Route::get('/steam/redirect', [RegisterController::class, 'redirectToSteam'])->name('steam.redirect');
Route::get('/steam/callback', [RegisterController::class, 'handleSteamCallback'])->name('steam.callback');

Route::get('/privacy-policy', [SiteController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-of-service', [SiteController::class, 'termsOfService'])->name('terms.service');

Route::post('/contact', [SiteController::class, 'submitContact'])->name('contact.submit');

// Protected routes (require authentication)
Route::middleware(['auth', 'active', 'auto_ban_country_change', 'auto_vpn_ban'])->group(function () {
    Route::get('/earn', [DashboardController::class, 'index'])->name('earnings.index');
    Route::get('/offers', [DashboardController::class, 'getAllOffers'])->name('all.offers');
    Route::get('/leaderboard', [DashboardController::class, 'leaderboard'])->name('leaderboard.index');
    
    Route::get('/cashout', [CashoutController::class, 'index'])->name('cashout.index');
    Route::post('/cashout', [CashoutController::class, 'store'])->name('cashout.store');
    Route::get('/cashout/history', [CashoutController::class, 'history'])->name('cashout.history');
    
    Route::get('/affiliate', [AffiliateController::class, 'index'])->name('affiliates.index');
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password.update');

    // Daily Bonus
    Route::post('/bonus/claim', [DailyBonusController::class, 'claim'])->name('bonus.claim');
    
    // BitLabs Surveys
    Route::get('/surveys', [BitLabsController::class, 'index'])->name('bitlabs.index');
    Route::post('/surveys/click', [BitLabsController::class, 'clickSurvey'])->name('bitlabs.click');

    // Monlix Offers
    Route::get('/monlix', [MonlixController::class, 'index'])->name('monlix.index');
    Route::post('/monlix/click', [MonlixController::class, 'clickOffer'])->name('monlix.click');

    // Loot Boxes
    Route::get('/lootbox', [LootBoxController::class, 'index'])->name('lootbox.index');
    
    // Achievements
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
    Route::post('/achievements/claim', [AchievementController::class, 'claim'])->name('achievements.claim');
    
    // Push Notifications
    Route::post('/push/subscribe', [PushNotificationController::class, 'subscribe'])->name('push.subscribe');
    Route::post('/push/unsubscribe', [PushNotificationController::class, 'unsubscribe'])->name('push.unsubscribe');
    Route::post('/lootbox/purchase', [LootBoxController::class, 'purchase'])->name('lootbox.purchase');
    Route::post('/lootbox/open', [LootBoxController::class, 'open'])->name('lootbox.open');
    Route::post('/lootbox/claim', [LootBoxController::class, 'claimReward'])->name('lootbox.claim');
    
    // Tier System
    Route::get('/tiers', [TierController::class, 'index'])->name('tiers.index');
    
    // Crypto Deposit
    Route::get('/crypto/deposit', [CryptoController::class, 'deposit'])->name('crypto.deposit');
    Route::post('/crypto/create-payment', [CryptoController::class, 'createPayment'])->name('crypto.create-payment');
});

// BitLabs Webhook (no auth required)
Route::post('/callback/bitlabs', [BitLabsController::class, 'callback'])->name('bitlabs.callback');

// Monlix Postback (no auth required)
Route::post('/callback/monlix', [MonlixController::class, 'callback'])->name('monlix.callback');
