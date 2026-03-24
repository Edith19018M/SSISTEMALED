<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Listar todos los usuarios
     */
    public function index()
    {
        $usuarios = Usuario::with(['rol', 'region', 'municipio'])->paginate(15);
        return response()->json($usuarios);
    }

    /**
     * Crear un nuevo usuario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios',
            'contraseña' => 'required|string|min:8',
            'rol_id' => 'required|exists:roles,id_rol',
            'region_id' => 'nullable|exists:regiones,id_region',
            'municipio_id' => 'nullable|exists:municipios,id_municipio'
        ]);

        $validated['contraseña'] = Hash::make($validated['contraseña']);
        $usuario = Usuario::create($validated);
        
        return response()->json($usuario, 201);
    }

    /**
     * Mostrar un usuario específico
     */
    public function show($id)
    {
        $usuario = Usuario::with(['rol', 'region', 'municipio'])->findOrFail($id);
        return response()->json($usuario);
    }

    /**
     * Actualizar un usuario
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'correo' => 'sometimes|email|unique:usuarios,correo,' . $id . ',id_usuario',
            'contraseña' => 'sometimes|string|min:8',
            'rol_id' => 'sometimes|exists:roles,id_rol',
            'region_id' => 'nullable|exists:regiones,id_region',
            'municipio_id' => 'nullable|exists:municipios,id_municipio'
        ]);

        if (isset($validated['contraseña'])) {
            $validated['contraseña'] = Hash::make($validated['contraseña']);
        }

        $usuario->update($validated);
        return response()->json($usuario);
    }

    /**
     * Eliminar un usuario
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return response()->json(null, 204);
    }
}
