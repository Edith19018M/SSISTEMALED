<?php

namespace App\Http\Controllers;

use App\Models\Emprendedor;
use Illuminate\Http\Request;

class EmprendedorController extends Controller
{
    /**
     * Listar todos los emprendedores
     */
    public function index()
    {
        $emprendedores = Emprendedor::with('emprendimientos')->paginate(15);
        return response()->json($emprendedores);
    }

    /**
     * Crear un nuevo emprendedor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'edad' => 'nullable|integer|min:0|max:120',
            'sexo' => 'nullable|in:M,F,O',
            'ci' => 'required|string|max:50|unique:emprendedores',
            'celular' => 'nullable|string|max:20',
            'correo' => 'required|email|unique:emprendedores',
            'direccion' => 'nullable|string|max:255',
            'carrera' => 'nullable|string|max:150',
            'año_estudio' => 'nullable|string|max:50'
        ]);

        $emprendedor = Emprendedor::create($validated);
        return response()->json($emprendedor, 201);
    }

    /**
     * Mostrar un emprendedor específico
     */
    public function show($id)
    {
        $emprendedor = Emprendedor::with('emprendimientos')->findOrFail($id);
        return response()->json($emprendedor);
    }

    /**
     * Actualizar un emprendedor
     */
    public function update(Request $request, $id)
    {
        $emprendedor = Emprendedor::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'apellidos' => 'sometimes|string|max:100',
            'edad' => 'nullable|integer|min:0|max:120',
            'sexo' => 'nullable|in:M,F,O',
            'ci' => 'sometimes|string|max:50|unique:emprendedores,ci,' . $id . ',id_emprendedor',
            'celular' => 'nullable|string|max:20',
            'correo' => 'sometimes|email|unique:emprendedores,correo,' . $id . ',id_emprendedor',
            'direccion' => 'nullable|string|max:255',
            'carrera' => 'nullable|string|max:150',
            'año_estudio' => 'nullable|string|max:50'
        ]);

        $emprendedor->update($validated);
        return response()->json($emprendedor);
    }

    /**
     * Eliminar un emprendedor
     */
    public function destroy($id)
    {
        $emprendedor = Emprendedor::findOrFail($id);
        $emprendedor->delete();
        return response()->json(null, 204);
    }

    /**
     * Asociar emprendedor a emprendimiento
     */
    public function asociarEmprendimiento(Request $request, $id)
    {
        $emprendedor = Emprendedor::findOrFail($id);
        
        $validated = $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'es_responsable_principal' => 'sometimes|boolean'
        ]);

        $emprendedor->emprendimientos()->attach(
            $validated['id_emprendimiento'],
            ['es_responsable_principal' => $validated['es_responsable_principal'] ?? false]
        );

        return response()->json(['message' => 'Emprendedor asociado exitosamente'], 201);
    }
}
