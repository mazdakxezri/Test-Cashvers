<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;

Route::get('/getWithdrawAndCompletedOffers', [DashboardController::class, 'getWithdrawAndCompletedOffers'])->name('getWithdrawAndCompletedOffers');

