<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Members\MembersController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\Networks\OffersController;
use App\Http\Controllers\Admin\Offers\CustomOffersController;
use App\Http\Controllers\Admin\GatewaysController;
use App\Http\Controllers\Admin\TosController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LeaderboardController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\FraudDetectionController;
use App\Http\Controllers\Admin\LootBoxAdminController;

Route::
        namespace('Admin\Auth')->group(function () {
            Route::get('/', [AuthController::class, 'index'])->name('login');
            Route::middleware('guest:admin')->group(function () {
                Route::post('/', [AuthController::class, 'login'])->name('login.submit');
                Route::get('password/reset', [ForgotPasswordController::class, 'index'])->name('password.request');
                Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email.send');
                Route::get('password/reset/{token}', [ResetPasswordController::class, 'index'])->name('password.reset.form');
                Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.submit');
            });
        });

Route::middleware(['auth:admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.submit');
    Route::get('/index', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [DashboardController::class, 'globaleSearch'])->name('global.search');
    Route::post('/cache/clear', [DashboardController::class, 'clearCache'])->name('cache.clear');

    Route::get('/members', [MembersController::class, 'index'])->name('members.index');
    Route::get('/members/info/{uid}', [MembersController::class, 'info'])->name('members.info');
    Route::put('/members/info/{id}', [MembersController::class, 'update'])->name('members.update');
    Route::put('/members/balance/add/{id}', [MembersController::class, 'addBalance'])->name('members.balance.add');
    Route::put('/members/balance/deduct/{id}', [MembersController::class, 'deductBalance'])->name('members.balance.deduct');
    Route::put('/members/{id}/{action}', [MembersController::class, 'changeStatus'])->name('members.status.change')->where('action', 'ban|unban');
    Route::get('/members/banned', [MembersController::class, 'banned'])->name('members.banned');

    // Fraud Detection
    Route::get('/fraud', [FraudDetectionController::class, 'index'])->name('fraud.index');
    Route::get('/fraud/user/{userId}', [FraudDetectionController::class, 'userDetails'])->name('fraud.user.details');

    Route::get('/api-offers', [OffersController::class, 'ApiOffers'])->name('offers.api');
    Route::post('/api-offers', [OffersController::class, 'StoreApi'])->name('offers.api.store');

    Route::get('offers/custom', [CustomOffersController::class, 'index'])->name('offers.custom.index');
    Route::get('offers/custom/create', [CustomOffersController::class, 'create'])->name('offers.custom.create');
    Route::post('offers/custom', [CustomOffersController::class, 'store'])->name('offers.custom.store');
    Route::get('offers/custom/edit/{id}', [CustomOffersController::class, 'edit'])->name('offers.custom.edit');
    Route::put('offers/custom/edit/{id}', [CustomOffersController::class, 'update'])->name('offers.custom.update');
    Route::delete('offers/custom/delete', [CustomOffersController::class, 'destroy'])->name('offers.custom.destroy');

    Route::get('/networks', [OffersController::class, 'index'])->name('networks.index');
    Route::get('/add-network', [OffersController::class, 'NewNetwork'])->name('network.add');
    Route::post('/add-network', [OffersController::class, 'StoreNetwork'])->name('network.store');
    Route::get('/edit-network/{id}', [OffersController::class, 'editNetwork'])->name('network.edit');
    Route::put('/edit-network/{id}', [OffersController::class, 'storeEditNetwork'])->name('network.update');
    Route::delete('/delete-network/{id}', [OffersController::class, 'deleteNetwork'])->name('network.delete');
    Route::post('/networks-order', [OffersController::class, 'saveNewtorkOrder'])->name('network.order');

    Route::resource('gateways', GatewaysController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('/gateways/{id}/items/add', [GatewaysController::class, 'addItems'])->name('gateways.items.add');
    Route::post('/gateways/{id}/items', [GatewaysController::class, 'storeItems'])->name('gateways.items.store');
    Route::delete('/gateways/{id}/items', [GatewaysController::class, 'deleteItem'])->name('gateways.items.delete');

    Route::delete('/categories/{id}', [GatewaysController::class, 'destroy'])->name('categories.destroy');

    Route::get('/withdraw', [GatewaysController::class, 'withdraw'])->name('withdraw.index');
    Route::put('/withdraw', [GatewaysController::class, 'markCompleted'])->name('withdraw.completed');
    Route::get('/withdraw/hold', [GatewaysController::class, 'withdrawHold'])->name('withdraw.hold');
    Route::put('/withdraw/cancel', [GatewaysController::class, 'CancelWithdraw'])->name('withdraw.cancel');

    Route::get('/tos', [TosController::class, 'index'])->name('tos.index');
    Route::post('/tos/privacy', [TosController::class, 'savePolicy'])->name('tos.privacy.save');
    Route::post('/tos/terms', [TosController::class, 'saveTerms'])->name('tos.terms.save');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    Route::get('/frauds', [SettingController::class, 'frauds'])->name('frauds.index');
    Route::put('/frauds/update', [SettingController::class, 'updateFraud'])->name('frauds.update');

    Route::get('/settings', [SettingController::class, 'settings'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'updateSettings'])->name('settings.update');
    Route::post('/social-media', [SettingController::class, 'socialMediaStore'])->name('social-media.store');
    Route::delete('/social-media/{id}', [SettingController::class, 'socialMediaDestroy'])->name('social-media.destroy');
    Route::resource('leaderboard', LeaderboardController::class)->only(['index', 'store']);
    Route::resource('levels', LevelController::class);
    Route::resource('faqs', FAQController::class);
    
    Route::get('/email-templates', [EmailTemplateController::class, 'index'])->name('email-templates.index');
    Route::put('/email-templates/update', [EmailTemplateController::class, 'updateAll'])->name('email-templates.updateAll');

});
