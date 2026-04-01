<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthWebController extends Controller
{
    public function showLogin()
    {
        if (session('usuario_id')) {
            if (session('usuario_rol') === 'Emprendedor') {
                return redirect('/mi-perfil');
            }
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo'    => 'required|email',
            'contraseña' => 'required|string',
        ]);

        $usuario = Usuario::where('correo', $request->correo)->with('rol', 'region', 'municipio')->first();

        if (!$usuario || !Hash::check($request->contraseña, $usuario->contraseña)) {
            return back()->withErrors(['correo' => 'Credenciales inválidas.'])->withInput(['correo' => $request->correo]);
        }

        $rol = $usuario->rol->nombre_rol ?? 'Sin rol';

        session([
            'usuario_id'     => $usuario->id_usuario,
            'usuario_nombre' => $usuario->nombre,
            'usuario_rol'    => $rol,
            'emprendedor_id' => $usuario->emprendedor_id,
        ]);

        if ($rol === 'Emprendedor') {
            return redirect('/mi-perfil')->with('success', '¡Bienvenido, ' . $usuario->nombre . '!');
        }

        return redirect('/dashboard')->with('success', '¡Bienvenido, ' . $usuario->nombre . '!');
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/login')->with('success', 'Sesión cerrada correctamente.');
    }

    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'contraseña_actual' => 'required|string',
            'contraseña_nueva'  => 'required|string|min:6|confirmed',
        ]);

        $usuario = Usuario::findOrFail(session('usuario_id'));

        if (!Hash::check($request->contraseña_actual, $usuario->contraseña)) {
            return back()->withErrors(['contraseña_actual' => 'La contraseña actual es incorrecta.']);
        }

        $usuario->update(['contraseña' => Hash::make($request->contraseña_nueva)]);

        return back()->with('success', 'Contraseña cambiada exitosamente.');
    }
}
