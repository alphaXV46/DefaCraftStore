<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\URL;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // trust ngrok proxy
        $middleware->trustProxies(at: '*');
        
        // Daftarkan Alias Middleware
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role'  => \App\Http\Middleware\RoleCheck::class,
        ]);

        // ✅ Daftarkan Middleware Keamanan Global & Optimasi
        $middleware->append(\App\Http\Middleware\SecurityHeadersMiddleware::class);
        $middleware->append(\App\Http\Middleware\SanitizeInputMiddleware::class);
        $middleware->append(\App\Http\Middleware\GzipResponse::class);
        $middleware->append(\App\Http\Middleware\CacheStaticAssets::class);

        // Exclude webhook dari CSRF
        $middleware->validateCsrfTokens(except: [
            'webhook/midtrans',
        ]);

        // kita paksa url di sini saja supaya aman
        if (env('APP_URL') && str_contains(env('APP_URL'), 'ngrok-free')) {
            URL::forceRootUrl(env('APP_URL'));
            if (str_contains(env('APP_URL'), 'https://')) {
                URL::forceScheme('https');
            }
        }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, \Illuminate\Http\Request $request) {
            \Illuminate\Support\Facades\Log::warning('Rate Limit Exceeded', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);

            if ($request->is('api/*') || $request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'error' => 'Terlalu banyak request. Silakan coba beberapa saat lagi.'
                ], 429);
            }

            return redirect()->back()->with('error', 'Terlalu banyak request. Silakan coba beberapa saat lagi.');
        });
    })->create();