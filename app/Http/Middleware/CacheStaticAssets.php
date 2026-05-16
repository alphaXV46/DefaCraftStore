<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheStaticAssets
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Jika response berhasil dan URL mengandung /build/assets
        if ($response->isSuccessful() && $request->is('build/assets/*')) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
        }

        return $response;
    }
}
