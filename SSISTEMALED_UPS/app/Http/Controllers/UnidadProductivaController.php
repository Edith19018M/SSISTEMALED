<?php

namespace App\Http\Controllers;

use App\Models\UnidadProductiva;
use Illuminate\Http\Request;

class UnidadProductivaController extends Controller
{
    /**
     * Listar todas las unidades productivas
     */
    public function index()
    {
        $unidades = UnidadProductiva::with([
            'categoria',
            'municipio',
            'responsables',
            'seguimientos',
            'compras',
            'ventas'
        ])->paginate(15);
        return response()->json($unidades);
    }

    /**
     * Crear una nueva unidad productiva
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias_unidad,id_categoria',
            'municipio_id' => 'required|exists:municipios,id_municipio',
            'direccion' => 'nullable|string|max:255'
        ]);

        $unidad = UnidadProductiva::create($validated);
        return response()->json($unidad, 201);
    }

    /**
     * Mostrar una unidad productiva específica
     */
    public function show($id)
    {
        $unidad = UnidadProductiva::with([
            'categoria',
            'municipio',
            'responsables',
            'seguimientos',
            'compras',
            'ventas'
        ])->findOrFail($id);
        return response()->json($unidad);
    }

    /**
     * Actualizar una unidad productiva
     */
    public function update(Request $request, $id)
    {
        $unidad = UnidadProductiva::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'categoria_id' => 'sometimes|exists:categorias_unidad,id_categoria',
            'municipio_id' => 'sometimes|exists:municipios,id_municipio',
            'direccion' => 'nullable|string|max:255'
        ]);

        $unidad->update($validated);
        return response()->json($unidad);
    }

    /**
     * Eliminar una unidad productiva
     */
    public function destroy($id)
    {
        $unidad = UnidadProductiva::findOrFail($id);
        $unidad->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener seguimientos de una unidad
     */
    public function seguimientos($id)
    {
        $unidad = UnidadProductiva::findOrFail($id);
        $seguimientos = $unidad->seguimientos()->with([
            'compromisos',
            'actividades'
        ])->get();
        return response()->json($seguimientos);
    }

    /**
     * Obtener compras de una unidad
     */
    public function compras($id)
    {
        $unidad = UnidadProductiva::findOrFail($id);
        return response()->json($unidad->compras()->latest()->get());
    }

    /**
     * Obtener ventas de una unidad
     */
    public function ventas($id)
    {
        $unidad = UnidadProductiva::findOrFail($id);
        return response()->json($unidad->ventas()->latest()->get());
    }

    /**
     * Asociar responsable a unidad
     */
    public function asociarResponsable(Request $request, $id)
    {
        $unidad = UnidadProductiva::findOrFail($id);
        
        $validated = $request->validate([
            'id_responsable' => 'required|exists:responsables,id_responsable',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date'
        ]);

        $unidad->responsables()->attach(
            $validated['id_responsable'],
            [
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_fin' => $validated['fecha_fin'] ?? null
            ]
        );

        return response()->json(['message' => 'Responsable asociado exitosamente'], 201);
    }
}
