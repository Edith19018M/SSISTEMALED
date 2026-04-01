<?php

namespace App\Http\Controllers;

use App\Models\PlanNegocio;
use Illuminate\Http\Request;

class PlanNegocioController extends Controller
{
    /**
     * Listar todos los planes de negocio
     */
    public function index()
    {
        $planes = PlanNegocio::with('emprendimiento')->paginate(15);
        return response()->json($planes);
    }

    /**
     * Crear un nuevo plan de negocio
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'fecha' => 'required|date',
            'documento_url' => 'nullable|string|max:255',
            'certificado_nacimiento' => 'sometimes|boolean'
        ]);

        $plan = PlanNegocio::create($validated);
        return response()->json($plan, 201);
    }

    /**
     * Mostrar un plan específico
     */
    public function show($id)
    {
        $plan = PlanNegocio::with('emprendimiento')->findOrFail($id);
        return response()->json($plan);
    }

    /**
     * Actualizar un plan
     */
    public function update(Request $request, $id)
    {
        $plan = PlanNegocio::findOrFail($id);
        
        $validated = $request->validate([
            'fecha' => 'sometimes|date',
            'documento_url' => 'nullable|string|max:255',
            'certificado_nacimiento' => 'sometimes|boolean'
        ]);

        $plan->update($validated);
        return response()->json($plan);
    }

    /**
     * Eliminar un plan
     */
    public function destroy($id)
    {
        $plan = PlanNegocio::findOrFail($id);
        $plan->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener planes de un emprendimiento
     */
    public function porEmprendimiento($id)
    {
        $planes = PlanNegocio::where('id_emprendimiento', $id)->get();
        return response()->json($planes);
    }
}
