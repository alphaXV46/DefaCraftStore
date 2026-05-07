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
    
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);

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
        //
    })->create();