<?php

namespace App\Http\Controllers;

use App\Models\SeguimientoEmprendimiento;
use Illuminate\Http\Request;

class SeguimientoEmprendimientoController extends Controller
{
    /**
     * Listar todos los seguimientos
     */
    public function index()
    {
        $seguimientos = SeguimientoEmprendimiento::with([
            'emprendimiento',
            'compromisos',
            'actividades'
        ])->paginate(15);
        return response()->json($seguimientos);
    }

    /**
     * Crear un nuevo seguimiento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'numero_seguimiento' => 'required|integer',
            'fecha' => 'required|date'
        ]);

        $seguimiento = SeguimientoEmprendimiento::create($validated);
        return response()->json($seguimiento, 201);
    }

    /**
     * Mostrar un seguimiento específico
     */
    public function show($id)
    {
        $seguimiento = SeguimientoEmprendimiento::with([
            'emprendimiento',
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
        $seguimiento = SeguimientoEmprendimiento::findOrFail($id);
        
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
        $seguimiento = SeguimientoEmprendimiento::findOrFail($id);
        $seguimiento->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener compromisos del seguimiento
     */
    public function compromisos($id)
    {
        $seguimiento = SeguimientoEmprendimiento::findOrFail($id);
        return response()->json($seguimiento->compromisos()->get());
    }

    /**
     * Obtener actividades del seguimiento
     */
    public function actividades($id)
    {
        $seguimiento = SeguimientoEmprendimiento::findOrFail($id);
        return response()->json($seguimiento->actividades()->get());
    }
}
