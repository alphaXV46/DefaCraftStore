<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
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
        // ══════════════════════════════════════════════════════
        // RATE LIMITER: LOGIN
        // ══════════════════════════════════════════════════════
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // ══════════════════════════════════════════════════════
        // RATE LIMITER: ONGKIR (Shipping Cost API)
        // ══════════════════════════════════════════════════════
        RateLimiter::for('ongkir', function (Request $request) {
            $key = $request->user()
                ? 'user_' . $request->user()->id
                : $request->ip();

            return Limit::perMinute(10)->by($key);
        });

        // ══════════════════════════════════════════════════════
        // RATE LIMITER: WEBHOOK (Midtrans Notifications)
        // ══════════════════════════════════════════════════════
        RateLimiter::for('webhook', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
