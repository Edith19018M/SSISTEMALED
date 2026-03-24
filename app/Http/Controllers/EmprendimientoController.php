<?php

namespace App\Http\Controllers;

use App\Models\Emprendimiento;
use Illuminate\Http\Request;

class EmprendimientoController extends Controller
{
    /**
     * Listar todos los emprendimientos
     */
    public function index()
    {
        $emprendimientos = Emprendimiento::with([
            'categoria',
            'municipio',
            'productos',
            'emprendedores',
            'formularios',
            'entrevistas',
            'planesNegocio',
            'seguimientos',
            'asesorias'
        ])->paginate(15);
        return response()->json($emprendimientos);
    }

    /**
     * Crear un nuevo emprendimiento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias_emprendimiento,id_categoria',
            'municipio_id' => 'required|exists:municipios,id_municipio',
            'estado_proceso' => 'sometimes|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'sector_rubro' => 'nullable|string|max:100'
        ]);

        $emprendimiento = Emprendimiento::create($validated);
        return response()->json($emprendimiento, 201);
    }

    /**
     * Mostrar un emprendimiento específico
     */
    public function show($id)
    {
        $emprendimiento = Emprendimiento::with([
            'categoria',
            'municipio',
            'productos',
            'emprendedores',
            'formularios',
            'entrevistas',
            'planesNegocio',
            'seguimientos',
            'asesorias'
        ])->findOrFail($id);
        return response()->json($emprendimiento);
    }

    /**
     * Actualizar un emprendimiento
     */
    public function update(Request $request, $id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'categoria_id' => 'sometimes|exists:categorias_emprendimiento,id_categoria',
            'municipio_id' => 'sometimes|exists:municipios,id_municipio',
            'estado_proceso' => 'sometimes|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'sector_rubro' => 'nullable|string|max:100'
        ]);

        $emprendimiento->update($validated);
        return response()->json($emprendimiento);
    }

    /**
     * Eliminar un emprendimiento
     */
    public function destroy($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $emprendimiento->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtener seguimientos de un emprendimiento
     */
    public function seguimientos($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $seguimientos = $emprendimiento->seguimientos()->with([
            'compromisos',
            'actividades'
        ])->get();
        return response()->json($seguimientos);
    }

    /**
     * Obtener asesorías de un emprendimiento
     */
    public function asesorias($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $asesorias = $emprendimiento->asesorias()->with('compromisos')->get();
        return response()->json($asesorias);
    }
}
