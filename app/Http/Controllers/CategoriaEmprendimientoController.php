<?php

namespace App\Http\Controllers;

use App\Models\CategoriaEmprendimiento;
use Illuminate\Http\Request;

class CategoriaEmprendimientoController extends Controller
{
    /**
     * Listar todas las categorías
     */
    public function index()
    {
        $categorias = CategoriaEmprendimiento::with('emprendimientos')->paginate(15);
        return response()->json($categorias);
    }

    /**
     * Crear una nueva categoría
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_categoria' => 'required|string|max:100|unique:categorias_emprendimiento'
        ]);

        $categoria = CategoriaEmprendimiento::create($validated);
        return response()->json($categoria, 201);
    }

    /**
     * Mostrar una categoría específica
     */
    public function show($id)
    {
        $categoria = CategoriaEmprendimiento::with('emprendimientos')->findOrFail($id);
        return response()->json($categoria);
    }

    /**
     * Actualizar una categoría
     */
    public function update(Request $request, $id)
    {
        $categoria = CategoriaEmprendimiento::findOrFail($id);
        
        $validated = $request->validate([
            'nombre_categoria' => 'required|string|max:100|unique:categorias_emprendimiento,nombre_categoria,' . $id . ',id_categoria'
        ]);

        $categoria->update($validated);
        return response()->json($categoria);
    }

    /**
     * Eliminar una categoría
     */
    public function destroy($id)
    {
        $categoria = CategoriaEmprendimiento::findOrFail($id);
        $categoria->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener emprendimientos de una categoría
     */
    public function emprendimientos($id)
    {
        $categoria = CategoriaEmprendimiento::findOrFail($id);
        return response()->json($categoria->emprendimientos()->paginate(10));
    }
}
