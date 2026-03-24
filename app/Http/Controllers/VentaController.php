<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Listar todas las ventas
     */
    public function index()
    {
        $ventas = Venta::with('unidad')->paginate(15);
        return response()->json($ventas);
    }

    /**
     * Crear una nueva venta
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_unidad' => 'required|exists:unidades_productivas,id_unidad',
            'fecha' => 'required|date',
            'producto' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0'
        ]);

        $venta = Venta::create($validated);
        return response()->json($venta, 201);
    }

    /**
     * Mostrar una venta específica
     */
    public function show($id)
    {
        $venta = Venta::with('unidad')->findOrFail($id);
        return response()->json($venta);
    }

    /**
     * Actualizar una venta
     */
    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);
        
        $validated = $request->validate([
            'fecha' => 'sometimes|date',
            'producto' => 'sometimes|string|max:255',
            'cantidad' => 'sometimes|integer|min:1',
            'precio' => 'sometimes|numeric|min:0'
        ]);

        $venta->update($validated);
        return response()->json($venta);
    }

    /**
     * Eliminar una venta
     */
    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener ventas de una unidad
     */
    public function porUnidad($id)
    {
        $ventas = Venta::where('id_unidad', $id)->latest('fecha')->paginate(10);
        return response()->json($ventas);
    }
}
