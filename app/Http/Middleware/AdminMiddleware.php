<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
   public function handle(Request $request, Closure $next)
{
   
    if (auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')) {
        return $next($request); // Izinkan masuk!
    }

    
    return redirect('/')->with('error', 'Kamu tidak memiliki hak akses.');
}
}