<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Listar todos los roles
     */
    public function index()
    {
        $roles = Rol::with('usuarios')->paginate(15);
        return response()->json($roles);
    }

    /**
     * Crear un nuevo rol
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_rol' => 'required|string|max:100|unique:roles'
        ]);

        $rol = Rol::create($validated);
        return response()->json($rol, 201);
    }

    /**
     * Mostrar un rol específico
     */
    public function show($id)
    {
        $rol = Rol::with('usuarios')->findOrFail($id);
        return response()->json($rol);
    }

    /**
     * Actualizar un rol
     */
    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);
        
        $validated = $request->validate([
            'nombre_rol' => 'required|string|max:100|unique:roles,nombre_rol,' . $id . ',id_rol'
        ]);

        $rol->update($validated);
        return response()->json($rol);
    }

    /**
     * Eliminar un rol
     */
    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();
        return response()->json(null, 204);
    }
}
