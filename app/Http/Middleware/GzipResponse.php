<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GzipResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya kompres jika browser mendukung gzip dan response bukan file download
        if (
            extension_loaded('zlib') &&
            str_contains($request->header('Accept-Encoding'), 'gzip') &&
            !$response->headers->has('Content-Encoding') &&
            $response->getContent() !== false &&
            (
                str_contains($response->headers->get('Content-Type'), 'text/html') ||
                str_contains($response->headers->get('Content-Type'), 'application/json') ||
                str_contains($response->headers->get('Content-Type'), 'text/css') ||
                str_contains($response->headers->get('Content-Type'), 'application/javascript')
            )
        ) {
            $response->setContent(gzencode($response->getContent(), 9));
            $response->headers->set('Content-Encoding', 'gzip');
            $response->headers->set('Vary', 'Accept-Encoding');
            $response->headers->set('Content-Length', strlen($response->getContent()));
        }

        return $response;
    }
}
