<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registrar un nuevo usuario
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|unique:usuarios,correo',
            'contraseña' => 'required|string|min:6|confirmed',
            'rol_id' => 'required|integer|exists:roles,id_rol',
            'region_id' => 'required|integer|exists:regiones,id_region',
            'municipio_id' => 'required|integer|exists:municipios,id_municipio'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $usuario = Usuario::create([
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'contraseña' => Hash::make($request->contraseña),
                'rol_id' => $request->rol_id,
                'region_id' => $request->region_id,
                'municipio_id' => $request->municipio_id
            ]);

            $token = $usuario->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'usuario' => $usuario->load('rol', 'region', 'municipio'),
                'token' => $token
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Iniciar sesión (Login)
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|string|email',
            'contraseña' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $usuario = Usuario::where('correo', $request->correo)->first();

            if (!$usuario || !Hash::check($request->contraseña, $usuario->contraseña)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas'
                ], 401);
            }

            // Revocar tokens anteriores
            $usuario->tokens()->delete();

            $token = $usuario->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Sesión iniciada correctamente',
                'usuario' => $usuario->load('rol', 'region', 'municipio'),
                'token' => $token
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar sesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener usuario autenticado actual
     */
    public function me(Request $request)
    {
        try {
            $usuario = $request->user();
            return response()->json([
                'success' => true,
                'usuario' => $usuario->load('rol', 'region', 'municipio')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos del usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cerrar sesión (Logout)
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sesión cerrada exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar sesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cambiar contraseña
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contraseña_actual' => 'required|string',
            'contraseña_nueva' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $usuario = $request->user();

            if (!Hash::check($request->contraseña_actual, $usuario->contraseña)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La contraseña actual es incorrecta'
                ], 401);
            }

            $usuario->update([
                'contraseña' => Hash::make($request->contraseña_nueva)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contraseña cambiada exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar la contraseña',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
