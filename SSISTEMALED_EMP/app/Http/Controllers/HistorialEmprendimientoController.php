<?php

namespace App\Http\Controllers;

use App\Models\HistorialEmprendimiento;
use Illuminate\Http\Request;

class HistorialEmprendimientoController extends Controller
{
    /**
     * Listar todos los historiales
     */
    public function index()
    {
        $historiales = HistorialEmprendimiento::with('emprendimiento')->paginate(15);
        return response()->json($historiales);
    }

    /**
     * Crear un nuevo registro en el historial
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'fecha' => 'required|date',
            'descripcion_cambio' => 'required|string'
        ]);

        $historial = HistorialEmprendimiento::create($validated);
        return response()->json($historial, 201);
    }

    /**
     * Mostrar un registro del historial
     */
    public function show($id)
    {
        $historial = HistorialEmprendimiento::with('emprendimiento')->findOrFail($id);
        return response()->json($historial);
    }

    /**
     * Actualizar un registro
     */
    public function update(Request $request, $id)
    {
        $historial = HistorialEmprendimiento::findOrFail($id);
        
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
        $historial = HistorialEmprendimiento::findOrFail($id);
        $historial->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener historial de un emprendimiento
     */
    public function porEmprendimiento($id)
    {
        $historial = HistorialEmprendimiento::where('id_emprendimiento', $id)->latest('fecha')->get();
        return response()->json($historial);
    }
}
