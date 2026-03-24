<?php

namespace App\Http\Controllers;

use App\Models\Asesoria;
use Illuminate\Http\Request;

class AsesoriaController extends Controller
{
    /**
     * Listar todas las asesorías
     */
    public function index()
    {
        $asesorias = Asesoria::with(['emprendimiento', 'compromisos'])->paginate(15);
        return response()->json($asesorias);
    }

    /**
     * Crear una nueva asesoría
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'tipo' => 'required|string|max:100',
            'tematica' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'observaciones' => 'nullable|string'
        ]);

        $asesoria = Asesoria::create($validated);
        return response()->json($asesoria, 201);
    }

    /**
     * Mostrar una asesoría específica
     */
    public function show($id)
    {
        $asesoria = Asesoria::with(['emprendimiento', 'compromisos'])->findOrFail($id);
        return response()->json($asesoria);
    }

    /**
     * Actualizar una asesoría
     */
    public function update(Request $request, $id)
    {
        $asesoria = Asesoria::findOrFail($id);
        
        $validated = $request->validate([
            'id_emprendimiento' => 'sometimes|exists:emprendimientos,id_emprendimiento',
            'fecha' => 'sometimes|date',
            'hora_inicio' => 'sometimes|date_format:H:i',
            'hora_fin' => 'sometimes|date_format:H:i',
            'tipo' => 'sometimes|string|max:100',
            'tematica' => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'observaciones' => 'nullable|string'
        ]);

        $asesoria->update($validated);
        return response()->json($asesoria);
    }

    /**
     * Eliminar una asesoría
     */
    public function destroy($id)
    {
        $asesoria = Asesoria::findOrFail($id);
        $asesoria->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener compromisos de una asesoría
     */
    public function compromisos($id)
    {
        $asesoria = Asesoria::findOrFail($id);
        return response()->json($asesoria->compromisos()->get());
    }
}
