<?php

namespace App\Http\Controllers;

use App\Models\CompromisoAsesoria;
use Illuminate\Http\Request;

class CompromisoAsesoriaController extends Controller
{
    /**
     * Listar todos los compromisos de asesorías
     */
    public function index()
    {
        $compromisos = CompromisoAsesoria::with('asesoria')->paginate(15);
        return response()->json($compromisos);
    }

    /**
     * Crear un nuevo compromiso
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_asesoria' => 'required|exists:asesorias,id_asesoria',
            'actividad' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'fecha' => 'required|date',
            'estado' => 'sometimes|string|max:100'
        ]);

        $compromiso = CompromisoAsesoria::create($validated);
        return response()->json($compromiso, 201);
    }

    /**
     * Mostrar un compromiso específico
     */
    public function show($id)
    {
        $compromiso = CompromisoAsesoria::with('asesoria')->findOrFail($id);
        return response()->json($compromiso);
    }

    /**
     * Actualizar un compromiso
     */
    public function update(Request $request, $id)
    {
        $compromiso = CompromisoAsesoria::findOrFail($id);
        
        $validated = $request->validate([
            'actividad' => 'sometimes|string|max:255',
            'responsable' => 'sometimes|string|max:255',
            'fecha' => 'sometimes|date',
            'estado' => 'sometimes|string|max:100'
        ]);

        $compromiso->update($validated);
        return response()->json($compromiso);
    }

    /**
     * Eliminar un compromiso
     */
    public function destroy($id)
    {
        $compromiso = CompromisoAsesoria::findOrFail($id);
        $compromiso->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener compromisos de una asesoría
     */
    public function porAsesoria($id)
    {
        $compromisos = CompromisoAsesoria::where('id_asesoria', $id)->get();
        return response()->json($compromisos);
    }
}
