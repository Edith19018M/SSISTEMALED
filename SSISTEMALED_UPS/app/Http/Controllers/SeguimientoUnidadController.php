<?php

namespace App\Http\Controllers;

use App\Models\SeguimientoUnidad;
use Illuminate\Http\Request;

class SeguimientoUnidadController extends Controller
{
    /**
     * Listar todos los seguimientos de unidades
     */
    public function index()
    {
        $seguimientos = SeguimientoUnidad::with([
            'unidad',
            'compromisos',
            'actividades'
        ])->paginate(15);
        return response()->json($seguimientos);
    }

    /**
     * Crear un nuevo seguimiento de unidad
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_unidad' => 'required|exists:unidades_productivas,id_unidad',
            'numero_seguimiento' => 'required|integer',
            'fecha' => 'required|date'
        ]);

        $seguimiento = SeguimientoUnidad::create($validated);
        return response()->json($seguimiento, 201);
    }

    /**
     * Mostrar un seguimiento específico
     */
    public function show($id)
    {
        $seguimiento = SeguimientoUnidad::with([
            'unidad',
            'compromisos',
            'actividades'
        ])->findOrFail($id);
        return response()->json($seguimiento);
    }

    /**
     * Actualizar un seguimiento
     */
    public function update(Request $request, $id)
    {
        $seguimiento = SeguimientoUnidad::findOrFail($id);
        
        $validated = $request->validate([
            'numero_seguimiento' => 'sometimes|integer',
            'fecha' => 'sometimes|date'
        ]);

        $seguimiento->update($validated);
        return response()->json($seguimiento);
    }

    /**
     * Eliminar un seguimiento
     */
    public function destroy($id)
    {
        $seguimiento = SeguimientoUnidad::findOrFail($id);
        $seguimiento->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener compromisos del seguimiento
     */
    public function compromisos($id)
    {
        $seguimiento = SeguimientoUnidad::findOrFail($id);
        return response()->json($seguimiento->compromisos()->get());
    }

    /**
     * Obtener actividades del seguimiento
     */
    public function actividades($id)
    {
        $seguimiento = SeguimientoUnidad::findOrFail($id);
        return response()->json($seguimiento->actividades()->get());
    }
}
