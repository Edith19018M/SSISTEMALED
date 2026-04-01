<?php

namespace App\Http\Controllers;

use App\Models\HistorialUnidad;
use Illuminate\Http\Request;

class HistorialUnidadController extends Controller
{
    /**
     * Listar todos los historiales
     */
    public function index()
    {
        $historiales = HistorialUnidad::with('unidad')->paginate(15);
        return response()->json($historiales);
    }

    /**
     * Crear un nuevo registro en el historial
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_unidad' => 'required|exists:unidades_productivas,id_unidad',
            'fecha' => 'required|date',
            'descripcion_cambio' => 'required|string'
        ]);

        $historial = HistorialUnidad::create($validated);
        return response()->json($historial, 201);
    }

    /**
     * Mostrar un registro del historial
     */
    public function show($id)
    {
        $historial = HistorialUnidad::with('unidad')->findOrFail($id);
        return response()->json($historial);
    }

    /**
     * Actualizar un registro
     */
    public function update(Request $request, $id)
    {
        $historial = HistorialUnidad::findOrFail($id);
        
        $validated = $request->validate([
            'fecha' => 'sometimes|date',
            'descripcion_cambio' => 'sometimes|string'
        ]);

        $historial->update($validated);
        return response()->json($historial);
    }

    /**
     * Eliminar un registro
     */
    public function destroy($id)
    {
        $historial = HistorialUnidad::findOrFail($id);
        $historial->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener historial de una unidad
     */
    public function porUnidad($id)
    {
        $historial = HistorialUnidad::where('id_unidad', $id)->latest('fecha')->get();
        return response()->json($historial);
    }
}
