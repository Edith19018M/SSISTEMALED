<?php

namespace App\Http\Controllers;

use App\Models\CategoriaUnidad;
use Illuminate\Http\Request;

class CategoriaUnidadController extends Controller
{
    /**
     * Listar todas las categorías de unidades
     */
    public function index()
    {
        $categorias = CategoriaUnidad::with('unidadesProductivas')->paginate(15);
        return response()->json($categorias);
    }

    /**
     * Crear una nueva categoría
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_categoria' => 'required|string|max:100|unique:categorias_unidad',
            'carrera_asociada' => 'nullable|string|max:150'
        ]);

        $categoria = CategoriaUnidad::create($validated);
        return response()->json($categoria, 201);
    }

    /**
     * Mostrar una categoría específica
     */
    public function show($id)
    {
        $categoria = CategoriaUnidad::with('unidadesProductivas')->findOrFail($id);
        return response()->json($categoria);
    }

    /**
     * Actualizar una categoría
     */
    public function update(Request $request, $id)
    {
        $categoria = CategoriaUnidad::findOrFail($id);
        
        $validated = $request->validate([
            'nombre_categoria' => 'required|string|max:100|unique:categorias_unidad,nombre_categoria,' . $id . ',id_categoria',
            'carrera_asociada' => 'nullable|string|max:150'
        ]);

        $categoria->update($validated);
        return response()->json($categoria);
    }

    /**
     * Eliminar una categoría
     */
    public function destroy($id)
    {
        $categoria = CategoriaUnidad::findOrFail($id);
        $categoria->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener unidades productivas de una categoría
     */
    public function unidades($id)
    {
        $categoria = CategoriaUnidad::findOrFail($id);
        return response()->json($categoria->unidadesProductivas()->paginate(10));
    }
}
