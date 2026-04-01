<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Asesoria;
use App\Models\CompromisoAsesoria;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;

class AsesoriaWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Asesoria::with('emprendimiento', 'compromisos');

        if ($request->filled('emprendimiento_id')) {
            $query->where('id_emprendimiento', $request->emprendimiento_id);
        }

        $asesorias = $query->latest()->paginate(15)->withQueryString();
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        return view('asesorias.index', compact('asesorias', 'emprendimientos'));
    }

    public function create()
    {
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        return view('asesorias.create', compact('emprendimientos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'fecha'             => 'required|date',
            'hora_inicio'       => 'required',
            'hora_fin'          => 'required',
            'tipo'              => 'required|string|max:100',
            'tematica'          => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'observaciones'     => 'nullable|string',
        ]);

        $asesoria = Asesoria::create($request->only([
            'id_emprendimiento', 'fecha', 'hora_inicio', 'hora_fin',
            'tipo', 'tematica', 'descripcion', 'observaciones'
        ]));

        return redirect('/asesorias/' . $asesoria->id_asesoria)
            ->with('success', 'Asesoría creada exitosamente.');
    }

    public function show($id)
    {
        $asesoria = Asesoria::with('emprendimiento', 'compromisos')->findOrFail($id);
        return view('asesorias.show', compact('asesoria'));
    }

    public function edit($id)
    {
        $asesoria = Asesoria::findOrFail($id);
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        return view('asesorias.edit', compact('asesoria', 'emprendimientos'));
    }

    public function update(Request $request, $id)
    {
        $asesoria = Asesoria::findOrFail($id);
        $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'fecha'             => 'required|date',
            'hora_inicio'       => 'required',
            'hora_fin'          => 'required',
            'tipo'              => 'required|string|max:100',
            'tematica'          => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'observaciones'     => 'nullable|string',
        ]);

        $asesoria->update($request->only([
            'id_emprendimiento', 'fecha', 'hora_inicio', 'hora_fin',
            'tipo', 'tematica', 'descripcion', 'observaciones'
        ]));

        return redirect('/asesorias/' . $id)->with('success', 'Asesoría actualizada.');
    }

    public function destroy($id)
    {
        Asesoria::findOrFail($id)->delete();
        return redirect('/asesorias')->with('success', 'Asesoría eliminada.');
    }

    public function storeCompromiso(Request $request, $id)
    {
        $request->validate([
            'actividad'   => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'fecha'       => 'required|date',
            'estado'      => 'required|string|max:100',
        ]);

        Asesoria::findOrFail($id);

        CompromisoAsesoria::create([
            'id_asesoria' => $id,
            'actividad'   => $request->actividad,
            'responsable' => $request->responsable,
            'fecha'       => $request->fecha,
            'estado'      => $request->estado,
        ]);

        return back()->with('success', 'Compromiso agregado.');
    }

    public function destroyCompromiso($id)
    {
        CompromisoAsesoria::findOrFail($id)->delete();
        return back()->with('success', 'Compromiso eliminado.');
    }
}
