<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CategoriaUnidad;
use Illuminate\Http\Request;

class CategoriaWebController extends Controller
{
    // ===== CATEGORÍAS DE UNIDAD PRODUCTIVA =====

    public function indexUnidad()
    {
        $categorias = CategoriaUnidad::withCount('unidadesProductivas')->get();
        return view('categorias.unidad', compact('categorias'));
    }

    public function storeUnidad(Request $request)
    {
        $request->validate([
            'nombre_categoria'  => 'required|string|max:100|unique:categorias_unidad,nombre_categoria',
            'carrera_asociada'  => 'nullable|string|max:150',
        ]);
        CategoriaUnidad::create($request->only(['nombre_categoria', 'carrera_asociada']));
        return back()->with('success', 'Categoría creada exitosamente.');
    }

    public function updateUnidad(Request $request, $id)
    {
        $categoria = CategoriaUnidad::findOrFail($id);
        $request->validate([
            'nombre_categoria' => 'required|string|max:100|unique:categorias_unidad,nombre_categoria,' . $id . ',id_categoria',
            'carrera_asociada' => 'nullable|string|max:150',
        ]);
        $categoria->update($request->only(['nombre_categoria', 'carrera_asociada']));
        return back()->with('success', 'Categoría actualizada.');
    }

    public function destroyUnidad($id)
    {
        $cat = CategoriaUnidad::withCount('unidadesProductivas')->findOrFail($id);
        if ($cat->unidades_productivas_count > 0) {
            return back()->with('error', 'No se puede eliminar: tiene unidades productivas asociadas.');
        }
        $cat->delete();
        return back()->with('success', 'Categoría eliminada.');
    }
}
