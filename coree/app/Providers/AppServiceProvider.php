<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\WithdrawalHistory;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $activeTemplate = get_current_template();
        view()->share('activeTemplate', 'templates/' . $activeTemplate);
        
        View::composer('*', function ($view) {
        if (Auth::guard('admin')->check()) {
            $pendingWithdrawals = WithdrawalHistory::where('status', 'pending')->count();
                $view->with('pendingWithdrawals', $pendingWithdrawals);
            }
        });
    }
}
