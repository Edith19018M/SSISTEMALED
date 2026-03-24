<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Listar todas las regiones
     */
    public function index()
    {
        $regiones = Region::with(['municipios', 'usuarios'])->paginate(15);
        return response()->json($regiones);
    }

    /**
     * Crear una nueva región
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_region' => 'required|string|max:100|unique:regiones'
        ]);

        $region = Region::create($validated);
        return response()->json($region, 201);
    }

    /**
     * Mostrar una región específica
     */
    public function show($id)
    {
        $region = Region::with(['municipios', 'usuarios'])->findOrFail($id);
        return response()->json($region);
    }

    /**
     * Actualizar una región
     */
    public function update(Request $request, $id)
    {
        $region = Region::findOrFail($id);
        
        $validated = $request->validate([
            'nombre_region' => 'required|string|max:100|unique:regiones,nombre_region,' . $id . ',id_region'
        ]);

        $region->update($validated);
        return response()->json($region);
    }

    /**
     * Eliminar una región
     */
    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();
        return response()->json(null, 204);
    }
}
