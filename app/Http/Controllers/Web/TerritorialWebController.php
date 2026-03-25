<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\Region;
use App\Models\Municipio;
use Illuminate\Http\Request;

class TerritorialWebController extends Controller
{
    // ======= ROLES =======

    public function indexRoles()
    {
        $roles = Rol::withCount('usuarios')->get();
        return view('territoriales.roles', compact('roles'));
    }

    public function storeRol(Request $request)
    {
        $request->validate(['nombre_rol' => 'required|string|max:100|unique:roles,nombre_rol']);
        Rol::create(['nombre_rol' => $request->nombre_rol]);
        return back()->with('success', 'Rol creado.');
    }

    public function destroyRol($id)
    {
        $rol = Rol::withCount('usuarios')->findOrFail($id);
        if ($rol->usuarios_count > 0) {
            return back()->with('error', 'No se puede eliminar el rol porque tiene usuarios asignados.');
        }
        $rol->delete();
        return back()->with('success', 'Rol eliminado.');
    }

    // ======= REGIONES =======

    public function indexRegiones()
    {
        $regiones = Region::withCount('municipios')->get();
        return view('territoriales.regiones', compact('regiones'));
    }

    public function storeRegion(Request $request)
    {
        $request->validate(['nombre_region' => 'required|string|max:100|unique:regiones,nombre_region']);
        Region::create(['nombre_region' => $request->nombre_region]);
        return back()->with('success', 'Región creada.');
    }

    public function destroyRegion($id)
    {
        Region::findOrFail($id)->delete();
        return back()->with('success', 'Región eliminada.');
    }

    // ======= MUNICIPIOS =======

    public function indexMunicipios()
    {
        $municipios = Municipio::with('region')->orderBy('nombre_municipio')->paginate(20);
        $regiones = Region::orderBy('nombre_region')->get();
        return view('territoriales.municipios', compact('municipios', 'regiones'));
    }

    public function storeMunicipio(Request $request)
    {
        $request->validate([
            'nombre_municipio' => 'required|string|max:100',
            'id_region'        => 'required|exists:regiones,id_region',
        ]);
        Municipio::create($request->only(['nombre_municipio', 'id_region']));
        return back()->with('success', 'Municipio creado.');
    }

    public function destroyMunicipio($id)
    {
        Municipio::findOrFail($id)->delete();
        return back()->with('success', 'Municipio eliminado.');
    }
}
