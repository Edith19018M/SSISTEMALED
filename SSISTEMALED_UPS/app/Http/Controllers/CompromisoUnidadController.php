<?php

namespace App\Http\Controllers;

use App\Models\CompromisoUnidad;
use Illuminate\Http\Request;

class CompromisoUnidadController extends Controller
{
    /**
     * Listar todos los compromisos de unidades
     */
    public function index()
    {
        $compromisos = CompromisoUnidad::with(['seguimiento', 'actividades'])->paginate(15);
        return response()->json($compromisos);
    }

    /**
     * Crear un nuevo compromiso
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_seguimiento' => 'required|exists:seguimientos_unidad,id_seguimiento',
            'descripcion' => 'required|string',
            'estado' => 'sometimes|string|max:100'
        ]);

        $compromiso = CompromisoUnidad::create($validated);
        return response()->json($compromiso, 201);
    }

    /**
     * Mostrar un compromiso específico
     */
    public function show($id)
    {
        $compromiso = CompromisoUnidad::with(['seguimiento', 'actividades'])->findOrFail($id);
        return response()->json($compromiso);
    }

    /**
     * Actualizar un compromiso
     */
    public function update(Request $request, $id)
    {
        $compromiso = CompromisoUnidad::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => 'sometimes|string',
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
        $compromiso = CompromisoUnidad::findOrFail($id);
        $compromiso->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener actividades del compromiso
     */
    public function actividades($id)
    {
        $compromiso = CompromisoUnidad::findOrFail($id);
        return response()->json($compromiso->actividades()->get());
    }
}
