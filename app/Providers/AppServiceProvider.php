<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        RateLimiter::for('products', function ($request) {
            return $request->user()?->role === 'admin'
                ? Limit::none()
                : Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
            // Limit::perMinute(6)->by($request->user()?->id ?: $request->ip()); // ?? isset
        });
    }
}
