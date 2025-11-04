<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Auth Routes
            Route::middleware('web')
                ->group(base_path('routes/auth.php'));

            // Admin Routes (with /backend prefix and admin. route name prefix)
            Route::prefix('backend')
                ->middleware('web')
                ->name('admin.')
                ->group(function () {
                    require base_path('routes/admin.php');
                });
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectTo(
            guests: '/',
            users: '/earn',
        );

        $middleware->alias([
            'guest:admin' => \App\Http\Middleware\Admin::class,
            'active' => \App\Http\Middleware\CheckUserStatus::class,
            'auto_ban_country_change' => \App\Http\Middleware\AutoBanOnCountryChange::class,
            'auto_vpn_ban' => \App\Http\Middleware\AutoBanVPN::class,
            'track_session' => \App\Http\Middleware\TrackUserSession::class,
        ]);
        
        // Track user sessions for fraud detection
        $middleware->append(\App\Http\Middleware\TrackUserSession::class);

        $middleware->validateCsrfTokens(except: [
            'callback/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
