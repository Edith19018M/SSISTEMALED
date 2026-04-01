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

        if (session('usuario_rol') === 'Emprendedor') {
            $path = $request->path();
            $permitidas = ['mi-perfil', 'cambiar-contrasena', 'logout', 'asesorias/formulario'];
            $permitido = collect($permitidas)->contains(fn($p) => str_starts_with($path, $p));
            if (!$permitido) {
                return redirect('/mi-perfil');
            }
        }

        return $next($request);
    }
}
