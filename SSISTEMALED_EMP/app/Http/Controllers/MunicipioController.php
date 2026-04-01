<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Listar todos los municipios
     */
    public function index()
    {
        $municipios = Municipio::with(['region', 'usuarios', 'emprendimientos', 'unidadesProductivas'])->paginate(15);
        return response()->json($municipios);
    }

    /**
     * Crear un nuevo municipio
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_municipio' => 'required|string|max:100',
            'id_region' => 'required|exists:regiones,id_region'
        ]);

        $municipio = Municipio::create($validated);
        return response()->json($municipio, 201);
    }

    /**
     * Mostrar un municipio específico
     */
    public function show($id)
    {
        $municipio = Municipio::with(['region', 'usuarios', 'emprendimientos', 'unidadesProductivas'])->findOrFail($id);
        return response()->json($municipio);
    }

    /**
     * Actualizar un municipio
     */
    public function update(Request $request, $id)
    {
        $municipio = Municipio::findOrFail($id);
        
        $validated = $request->validate([
            'nombre_municipio' => 'required|string|max:100',
            'id_region' => 'required|exists:regiones,id_region'
        ]);

        $municipio->update($validated);
        return response()->json($municipio);
    }

    /**
     * Eliminar un municipio
     */
    public function destroy($id)
    {
        $municipio = Municipio::findOrFail($id);
        $municipio->delete();
        return response()->json(null, 204);
    }
}
