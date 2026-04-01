<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmprendedorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('usuario_rol') !== 'Emprendedor') {
            return redirect('/dashboard')->with('error', 'Acceso no autorizado.');
        }
        return $next($request);
    }
}
