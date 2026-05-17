<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInputMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Bypass untuk route admin (Sesuai permintaan user)
        if ($request->is('admin') || $request->is('admin/*')) {
            return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function (&$value, $key) {
            // Jangan filter field password
            if (in_array(strtolower((string)$key), ['password', 'password_confirmation', 'current_password'])) {
                return;
            }

            if (is_string($value)) {
                $value = strip_tags($value);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
