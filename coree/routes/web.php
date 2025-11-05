<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Postback\CallbackController;
use App\Http\Controllers\Postback\CustomController;
use App\Http\Controllers\Postback\Api\ApiCallbackController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CashoutController;
use App\Http\Controllers\Dashboard\AffiliateController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\DailyBonusController;

// Public routes
Route::middleware('guest')->group(function () {
    Route::get('/', [SiteController::class, 'index'])->name('home');
});
Route::get('/r/{referral_code}', [SiteController::class, 'referralCode'])->name('referral.code');
Route::get('/privacy-policy', [SiteController::class, 'privacy'])->name('privacy.policy');
Route::get('/terms-of-use', [SiteController::class, 'terms'])->name('terms.of.use');
Route::post('/contact', [SiteController::class, 'submitForm'])->name('contact');

// Postback routes
Route::match(['get', 'post'], '/callback/{param_secret}/{network_slug}', [CallbackController::class, 'index'])
    ->name('postback.callback');
// API Offers Postback routes
Route::get('/callback/api/{network_name}/{secret_key}', [ApiCallbackController::class, 'index'])->name('api.postback.callback');
// Custom Offers Postback routes
Route::get('/callback/custom/{param_secret}/{network_name}', [CustomController::class, 'index'])->name('custom.postback.callback');


// Authenticated routes
Route::middleware(['auth', 'active', 'auto_ban_country_change', 'auto_vpn_ban'])->group(function () {
    Route::get('/earn', [DashboardController::class, 'index'])->name('earnings.index');

    Route::resource('cashout', CashoutController::class)->only(['index', 'store'])->names([
        'index' => 'cashout.index',
        'store' => 'cashout.store',
    ]);
    Route::get('/affiliates', [AffiliateController::class, 'index'])->name('affiliates.index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'edit']);

    Route::get('/leaderboard', [DashboardController::class, 'leaderboard'])->name('leaderboard.index');
    Route::get('/offers', [DashboardController::class, 'getAllOffers'])->name('all.offers');

    // Daily Login Bonus
    Route::post('/bonus/claim', [DailyBonusController::class, 'claim'])->name('bonus.claim');
    Route::get('/bonus/calendar', [DailyBonusController::class, 'calendar'])->name('bonus.calendar');
});

