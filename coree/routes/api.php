<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Postback\Api\ApiCallbackController;

Route::get('/getWithdrawAndCompletedOffers', [DashboardController::class, 'getWithdrawAndCompletedOffers'])->name('getWithdrawAndCompletedOffers');

// API Postback route for admin panel display
Route::get('/postback/{network_name}/{secret_key}', [ApiCallbackController::class, 'index'])->name('api.postback.callback');

