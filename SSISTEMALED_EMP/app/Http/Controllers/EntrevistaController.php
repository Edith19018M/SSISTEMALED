<?php

namespace App\Http\Controllers;

use App\Models\Entrevista;
use Illuminate\Http\Request;

class EntrevistaController extends Controller
{
    /**
     * Listar todas las entrevistas
     */
    public function index()
    {
        $entrevistas = Entrevista::with('emprendimiento')->paginate(15);
        return response()->json($entrevistas);
    }

    /**
     * Crear una nueva entrevista
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'fecha' => 'required|date',
            'evaluador' => 'nullable|string|max:255',
            'resultado' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string'
        ]);

        $entrevista = Entrevista::create($validated);
        return response()->json($entrevista, 201);
    }

    /**
     * Mostrar una entrevista específica
     */
    public function show($id)
    {
        $entrevista = Entrevista::with('emprendimiento')->findOrFail($id);
        return response()->json($entrevista);
    }

    /**
     * Actualizar una entrevista
     */
    public function update(Request $request, $id)
    {
        $entrevista = Entrevista::findOrFail($id);
        
        $validated = $request->validate([
            'fecha' => 'sometimes|date',
            'evaluador' => 'nullable|string|max:255',
            'resultado' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string'
        ]);

        $entrevista->update($validated);
        return response()->json($entrevista);
    }

    /**
     * Eliminar una entrevista
     */
    public function destroy($id)
    {
        $entrevista = Entrevista::findOrFail($id);
        $entrevista->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener entrevistas de un emprendimiento
     */
    public function porEmprendimiento($id)
    {
        $entrevistas = Entrevista::where('id_emprendimiento', $id)->get();
        return response()->json($entrevistas);
    }
}
