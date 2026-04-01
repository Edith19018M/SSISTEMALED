<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CategoriaEmprendimiento;
use Illuminate\Http\Request;

class CategoriaWebController extends Controller
{
    // ===== CATEGORÍAS DE EMPRENDIMIENTO =====

    public function indexEmprendimiento()
    {
        $categorias = CategoriaEmprendimiento::withCount('emprendimientos')->get();
        return view('categorias.emprendimiento', compact('categorias'));
    }

    public function storeEmprendimiento(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:100|unique:categorias_emprendimiento,nombre_categoria',
        ]);
        CategoriaEmprendimiento::create(['nombre_categoria' => $request->nombre_categoria]);
        return back()->with('success', 'Categoría creada exitosamente.');
    }

    public function updateEmprendimiento(Request $request, $id)
    {
        $categoria = CategoriaEmprendimiento::findOrFail($id);
        $request->validate([
            'nombre_categoria' => 'required|string|max:100|unique:categorias_emprendimiento,nombre_categoria,' . $id . ',id_categoria',
        ]);
        $categoria->update(['nombre_categoria' => $request->nombre_categoria]);
        return back()->with('success', 'Categoría actualizada.');
    }

    public function destroyEmprendimiento($id)
    {
        $cat = CategoriaEmprendimiento::withCount('emprendimientos')->findOrFail($id);
        if ($cat->emprendimientos_count > 0) {
            return back()->with('error', 'No se puede eliminar: tiene emprendimientos asociados.');
        }
        $cat->delete();
        return back()->with('success', 'Categoría eliminada.');
    }
}
