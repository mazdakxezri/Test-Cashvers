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
        
        // Register Socialite providers
        $this->bootSocialiteProviders();
    }

    /**
     * Boot Socialite providers (Discord, Steam, etc.)
     */
    protected function bootSocialiteProviders(): void
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        
        // Discord Provider
        $socialite->extend('discord', function ($app) use ($socialite) {
            $config = $app['config']['services.discord'];
            return $socialite->buildProvider(
                \SocialiteProviders\Discord\Provider::class,
                $config
            );
        });
        
        // Steam Provider  
        $socialite->extend('steam', function ($app) use ($socialite) {
            $config = $app['config']['services.steam'];
            return $socialite->buildProvider(
                \SocialiteProviders\Steam\Provider::class,
                $config
            );
        });
    }
}
