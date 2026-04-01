<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('usuario_id')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión para continuar.');
        }
        return $next($request);
    }
}
