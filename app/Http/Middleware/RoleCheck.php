<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek: Apakah user sudah login? Dan apakah role user ada di daftar yang diizinkan?
        if (!$request->user() || !in_array($request->user()->role, $roles)) {
            // Jika tidak punya akses, tendang ke halaman 403 (Forbidden)
            abort(403, 'Maaf, area ini khusus Superadmin!');
        }

        return $next($request);
    }
}