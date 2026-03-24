<?php

namespace App\Http\Controllers;

use App\Models\ActividadEmprendimiento;
use Illuminate\Http\Request;

class ActividadEmprendimientoController extends Controller
{
    /**
     * Listar todas las actividades
     */
    public function index()
    {
        $actividades = ActividadEmprendimiento::with(['seguimiento', 'compromiso'])->paginate(15);
        return response()->json($actividades);
    }

    /**
     * Crear una nueva actividad
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_seguimiento' => 'required|exists:seguimientos_emprendimiento,id_seguimiento',
            'descripcion' => 'required|string',
            'estado' => 'sometimes|string|max:100',
            'id_compromiso_origen' => 'nullable|exists:compromisos_emprendimiento,id_compromiso'
        ]);

        $actividad = ActividadEmprendimiento::create($validated);
        return response()->json($actividad, 201);
    }

    /**
     * Mostrar una actividad específica
     */
    public function show($id)
    {
        $actividad = ActividadEmprendimiento::with(['seguimiento', 'compromiso'])->findOrFail($id);
        return response()->json($actividad);
    }

    /**
     * Actualizar una actividad
     */
    public function update(Request $request, $id)
    {
        $actividad = ActividadEmprendimiento::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => 'sometimes|string',
            'estado' => 'sometimes|string|max:100',
            'id_compromiso_origen' => 'nullable|exists:compromisos_emprendimiento,id_compromiso'
        ]);

        $actividad->update($validated);
        return response()->json($actividad);
    }

    /**
     * Eliminar una actividad
     */
    public function destroy($id)
    {
        $actividad = ActividadEmprendimiento::findOrFail($id);
        $actividad->delete();
        return response()->json(null, 204);
    }
}
