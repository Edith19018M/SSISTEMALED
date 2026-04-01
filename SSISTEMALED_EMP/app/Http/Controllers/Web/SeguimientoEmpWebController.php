<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SeguimientoEmprendimiento;
use App\Models\CompromisoEmprendimiento;
use App\Models\ActividadEmprendimiento;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;

class SeguimientoEmpWebController extends Controller
{
    public function index(Request $request)
    {
        $query = SeguimientoEmprendimiento::with('emprendimiento');

        if ($request->filled('emprendimiento_id')) {
            $query->where('id_emprendimiento', $request->emprendimiento_id);
        }

        $seguimientos = $query->latest()->paginate(15)->withQueryString();
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        return view('seguimientos-emp.index', compact('seguimientos', 'emprendimientos'));
    }

    public function create()
    {
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        return view('seguimientos-emp.create', compact('emprendimientos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_emprendimiento'  => 'required|exists:emprendimientos,id_emprendimiento',
            'numero_seguimiento' => 'required|integer|min:1',
            'fecha'              => 'required|date',
        ]);

        $seguimiento = SeguimientoEmprendimiento::create([
            'id_emprendimiento'  => $request->id_emprendimiento,
            'numero_seguimiento' => $request->numero_seguimiento,
            'fecha'              => $request->fecha,
        ]);

        return redirect('/seguimientos-emprendimiento/' . $seguimiento->id_seguimiento)
            ->with('success', 'Seguimiento creado. Ahora puede agregar compromisos y actividades.');
    }

    public function show($id)
    {
        $seguimiento = SeguimientoEmprendimiento::with([
            'emprendimiento',
            'compromisos',
            'actividades.compromiso',
        ])->findOrFail($id);

        return view('seguimientos-emp.show', compact('seguimiento'));
    }

    public function destroy($id)
    {
        SeguimientoEmprendimiento::findOrFail($id)->delete();
        return redirect('/seguimientos-emprendimiento')->with('success', 'Seguimiento eliminado.');
    }

    // Compromisos
    public function storeCompromiso(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'estado'      => 'required|string|max:100',
        ]);

        SeguimientoEmprendimiento::findOrFail($id);

        CompromisoEmprendimiento::create([
            'id_seguimiento' => $id,
            'descripcion'    => $request->descripcion,
            'estado'         => $request->estado,
        ]);

        return back()->with('success', 'Compromiso agregado.');
    }

    // Actividades
    public function storeActividad(Request $request, $id)
    {
        $request->validate([
            'descripcion'         => 'required|string',
            'estado'              => 'required|string|max:100',
            'id_compromiso_origen' => 'nullable|exists:compromisos_emprendimiento,id_compromiso',
        ]);

        SeguimientoEmprendimiento::findOrFail($id);

        ActividadEmprendimiento::create([
            'id_seguimiento'       => $id,
            'descripcion'          => $request->descripcion,
            'estado'               => $request->estado,
            'id_compromiso_origen' => $request->id_compromiso_origen ?: null,
        ]);

        return back()->with('success', 'Actividad agregada.');
    }

    public function destroyCompromiso($id)
    {
        CompromisoEmprendimiento::findOrFail($id)->delete();
        return back()->with('success', 'Compromiso eliminado.');
    }

    public function destroyActividad($id)
    {
        ActividadEmprendimiento::findOrFail($id)->delete();
        return back()->with('success', 'Actividad eliminada.');
    }
}
