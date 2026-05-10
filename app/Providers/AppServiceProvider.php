<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Deteksi host secara dinamis
        $host = request()->header('host');
        if ($host) {
            if (str_contains($host, 'ngrok-free.dev') || app()->environment('production')) {
                config(['app.url' => 'https://' . $host]);
                URL::forceScheme('https');
            } else {
                config(['app.url' => 'http://' . $host]);
            }
        }

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

        // ══════════════════════════════════════════════════════
        // VIEW COMPOSERS
        // ══════════════════════════════════════════════════════
        \Illuminate\Support\Facades\View::composer('partials.header', function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $cartCount = \App\Models\Keranjang::where('user_id', \Illuminate\Support\Facades\Auth::id())->count();
                $wishlistCount = \App\Models\Wishlist::where('user_id', \Illuminate\Support\Facades\Auth::id())->count();
                $view->with(compact('cartCount', 'wishlistCount'));
            }
        });
    }
}
