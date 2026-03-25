<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SeguimientoUnidad;
use App\Models\CompromisoUnidad;
use App\Models\ActividadUnidad;
use App\Models\UnidadProductiva;
use Illuminate\Http\Request;

class SeguimientoUnidadWebController extends Controller
{
    public function index(Request $request)
    {
        $query = SeguimientoUnidad::with('unidad');

        if ($request->filled('unidad_id')) {
            $query->where('id_unidad', $request->unidad_id);
        }

        $seguimientos = $query->latest()->paginate(15)->withQueryString();
        $unidades = UnidadProductiva::orderBy('nombre')->get();
        return view('seguimientos-unidad.index', compact('seguimientos', 'unidades'));
    }

    public function create()
    {
        $unidades = UnidadProductiva::orderBy('nombre')->get();
        return view('seguimientos-unidad.create', compact('unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_unidad'          => 'required|exists:unidades_productivas,id_unidad',
            'numero_seguimiento' => 'required|integer|min:1',
            'fecha'              => 'required|date',
        ]);

        $seguimiento = SeguimientoUnidad::create([
            'id_unidad'          => $request->id_unidad,
            'numero_seguimiento' => $request->numero_seguimiento,
            'fecha'              => $request->fecha,
        ]);

        return redirect('/seguimientos-unidad/' . $seguimiento->id_seguimiento)
            ->with('success', 'Seguimiento creado.');
    }

    public function show($id)
    {
        $seguimiento = SeguimientoUnidad::with([
            'unidad', 'compromisos', 'actividades.compromiso'
        ])->findOrFail($id);

        return view('seguimientos-unidad.show', compact('seguimiento'));
    }

    public function destroy($id)
    {
        SeguimientoUnidad::findOrFail($id)->delete();
        return redirect('/seguimientos-unidad')->with('success', 'Seguimiento eliminado.');
    }

    public function storeCompromiso(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'estado'      => 'required|string|max:100',
        ]);

        SeguimientoUnidad::findOrFail($id);
        CompromisoUnidad::create([
            'id_seguimiento' => $id,
            'descripcion'    => $request->descripcion,
            'estado'         => $request->estado,
        ]);

        return back()->with('success', 'Compromiso agregado.');
    }

    public function storeActividad(Request $request, $id)
    {
        $request->validate([
            'descripcion'         => 'required|string',
            'estado'              => 'required|string|max:100',
            'id_compromiso_origen' => 'nullable|exists:compromisos_unidad,id_compromiso',
        ]);

        SeguimientoUnidad::findOrFail($id);
        ActividadUnidad::create([
            'id_seguimiento'       => $id,
            'descripcion'          => $request->descripcion,
            'estado'               => $request->estado,
            'id_compromiso_origen' => $request->id_compromiso_origen ?: null,
        ]);

        return back()->with('success', 'Actividad agregada.');
    }

    public function destroyCompromiso($id)
    {
        CompromisoUnidad::findOrFail($id)->delete();
        return back()->with('success', 'Compromiso eliminado.');
    }

    public function destroyActividad($id)
    {
        ActividadUnidad::findOrFail($id)->delete();
        return back()->with('success', 'Actividad eliminada.');
    }
}
