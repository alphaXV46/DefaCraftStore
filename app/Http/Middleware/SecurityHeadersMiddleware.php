<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Jangan set header jika response bukan object yang memiliki method headers
        if (!method_exists($response, 'headers')) {
            return $response;
        }

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Header Strict-Transport-Security (HSTS)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // Content Security Policy
        // Menambahkan CDN yang diminta user: cdn.jsdelivr.net, cdnjs.cloudflare.com, Google Fonts
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://app.midtrans.com https://app.sandbox.midtrans.com https://unpkg.com https://cdn.jsdelivr.net; " .
               "style-src 'self' 'unsafe-inline' https://unpkg.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com; " .
               "font-src 'self' data: https://cdnjs.cloudflare.com https://fonts.gstatic.com; " .
               "img-src 'self' data: https://unpkg.com; " .
               "connect-src 'self' https://app.midtrans.com https://app.sandbox.midtrans.com; " .
               "frame-src 'self' https://app.midtrans.com https://app.sandbox.midtrans.com;";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
