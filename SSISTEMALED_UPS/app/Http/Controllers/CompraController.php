<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Listar todas las compras
     */
    public function index()
    {
        $compras = Compra::with('unidad')->paginate(15);
        return response()->json($compras);
    }

    /**
     * Crear una nueva compra
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_unidad' => 'required|exists:unidades_productivas,id_unidad',
            'fecha' => 'required|date',
            'producto' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'costo' => 'required|numeric|min:0'
        ]);

        $compra = Compra::create($validated);
        return response()->json($compra, 201);
    }

    /**
     * Mostrar una compra específica
     */
    public function show($id)
    {
        $compra = Compra::with('unidad')->findOrFail($id);
        return response()->json($compra);
    }

    /**
     * Actualizar una compra
     */
    public function update(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);
        
        $validated = $request->validate([
            'fecha' => 'sometimes|date',
            'producto' => 'sometimes|string|max:255',
            'cantidad' => 'sometimes|integer|min:1',
            'costo' => 'sometimes|numeric|min:0'
        ]);

        $compra->update($validated);
        return response()->json($compra);
    }

    /**
     * Eliminar una compra
     */
    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);
        $compra->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener compras de una unidad
     */
    public function porUnidad($id)
    {
        $compras = Compra::where('id_unidad', $id)->latest('fecha')->paginate(10);
        return response()->json($compras);
    }
}
