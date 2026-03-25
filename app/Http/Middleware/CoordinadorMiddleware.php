<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CoordinadorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $rol = session('usuario_rol');
        if (!in_array($rol, ['Administrador', 'Coordinador'])) {
            return redirect('/dashboard')->with('error', 'No tiene permisos para realizar esta acción.');
        }
        return $next($request);
    }
}
