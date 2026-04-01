<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('usuario_rol') !== 'Administrador') {
            return redirect('/dashboard')->with('error', 'No tiene permisos para realizar esta acción.');
        }
        return $next($request);
    }
}
