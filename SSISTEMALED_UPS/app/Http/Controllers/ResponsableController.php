<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    /**
     * Listar todos los responsables
     */
    public function index()
    {
        $responsables = Responsable::with('unidadesProductivas')->paginate(15);
        return response()->json($responsables);
    }

    /**
     * Crear un nuevo responsable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'contacto' => 'nullable|string|max:100',
            'ci' => 'required|string|max:50|unique:responsables',
            'correo' => 'required|email|unique:responsables'
        ]);

        $responsable = Responsable::create($validated);
        return response()->json($responsable, 201);
    }

    /**
     * Mostrar un responsable específico
     */
    public function show($id)
    {
        $responsable = Responsable::with('unidadesProductivas')->findOrFail($id);
        return response()->json($responsable);
    }

    /**
     * Actualizar un responsable
     */
    public function update(Request $request, $id)
    {
        $responsable = Responsable::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'contacto' => 'nullable|string|max:100',
            'ci' => 'sometimes|string|max:50|unique:responsables,ci,' . $id . ',id_responsable',
            'correo' => 'sometimes|email|unique:responsables,correo,' . $id . ',id_responsable'
        ]);

        $responsable->update($validated);
        return response()->json($responsable);
    }

    /**
     * Eliminar un responsable
     */
    public function destroy($id)
    {
        $responsable = Responsable::findOrFail($id);
        $responsable->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener unidades productivas del responsable
     */
    public function unidades($id)
    {
        $responsable = Responsable::findOrFail($id);
        return response()->json($responsable->unidadesProductivas()->with('pivot')->get());
    }
}
