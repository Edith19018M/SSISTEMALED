<?php

namespace App\Http\Controllers;

use App\Models\FormularioInscripcion;
use Illuminate\Http\Request;

class FormularioInscripcionController extends Controller
{
    /**
     * Listar todos los formularios
     */
    public function index()
    {
        $formularios = FormularioInscripcion::with('emprendimiento')->paginate(15);
        return response()->json($formularios);
    }

    /**
     * Crear un nuevo formulario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'fecha_envio' => 'required|date',
            'datos_json' => 'nullable|json'
        ]);

        $formulario = FormularioInscripcion::create($validated);
        return response()->json($formulario, 201);
    }

    /**
     * Mostrar un formulario específico
     */
    public function show($id)
    {
        $formulario = FormularioInscripcion::with('emprendimiento')->findOrFail($id);
        return response()->json($formulario);
    }

    /**
     * Actualizar un formulario
     */
    public function update(Request $request, $id)
    {
        $formulario = FormularioInscripcion::findOrFail($id);
        
        $validated = $request->validate([
            'fecha_envio' => 'sometimes|date',
            'datos_json' => 'nullable|json'
        ]);

        $formulario->update($validated);
        return response()->json($formulario);
    }

    /**
     * Eliminar un formulario
     */
    public function destroy($id)
    {
        $formulario = FormularioInscripcion::findOrFail($id);
        $formulario->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener formularios de un emprendimiento
     */
    public function porEmprendimiento($id)
    {
        $formularios = FormularioInscripcion::where('id_emprendimiento', $id)->get();
        return response()->json($formularios);
    }
}
