<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UnidadProductiva;
use App\Models\CategoriaUnidad;
use App\Models\Municipio;
use App\Models\Responsable;
use Illuminate\Http\Request;

class UnidadProductivaWebController extends Controller
{
    public function index(Request $request)
    {
        $query = UnidadProductiva::with('categoria', 'municipio', 'responsables');

        if ($request->filled('busqueda')) {
            $query->where('nombre', 'like', '%' . $request->busqueda . '%');
        }

        $unidades = $query->latest()->paginate(15)->withQueryString();
        return view('unidades.index', compact('unidades'));
    }

    public function create()
    {
        $categorias = CategoriaUnidad::orderBy('nombre_categoria')->get();
        $municipios = Municipio::with('region')->orderBy('nombre_municipio')->get();
        return view('unidades.create', compact('categorias', 'municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias_unidad,id_categoria',
            'municipio_id' => 'required|exists:municipios,id_municipio',
            'direccion'    => 'nullable|string|max:255',
        ]);

        UnidadProductiva::create($request->only(['nombre', 'categoria_id', 'municipio_id', 'direccion']));
        return redirect('/unidades')->with('success', 'Unidad productiva creada exitosamente.');
    }

    public function show($id)
    {
        $unidad = UnidadProductiva::with([
            'categoria', 'municipio',
            'responsables', 'seguimientos.compromisos',
            'compras', 'ventas', 'historial'
        ])->findOrFail($id);

        $responsables = Responsable::orderBy('nombre')->get();
        return view('unidades.show', compact('unidad', 'responsables'));
    }

    public function edit($id)
    {
        $unidad = UnidadProductiva::findOrFail($id);
        $categorias = CategoriaUnidad::orderBy('nombre_categoria')->get();
        $municipios = Municipio::with('region')->orderBy('nombre_municipio')->get();
        return view('unidades.edit', compact('unidad', 'categorias', 'municipios'));
    }

    public function update(Request $request, $id)
    {
        $unidad = UnidadProductiva::findOrFail($id);

        $request->validate([
            'nombre'       => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias_unidad,id_categoria',
            'municipio_id' => 'required|exists:municipios,id_municipio',
            'direccion'    => 'nullable|string|max:255',
        ]);

        $unidad->update($request->only(['nombre', 'categoria_id', 'municipio_id', 'direccion']));
        return redirect('/unidades/' . $id)->with('success', 'Unidad productiva actualizada.');
    }

    public function destroy($id)
    {
        UnidadProductiva::findOrFail($id)->delete();
        return redirect('/unidades')->with('success', 'Unidad productiva eliminada.');
    }

    public function asociarResponsable(Request $request, $id)
    {
        $request->validate([
            'id_responsable' => 'required|exists:responsables,id_responsable',
            'fecha_inicio'   => 'required|date',
            'fecha_fin'      => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $unidad = UnidadProductiva::findOrFail($id);
        $unidad->responsables()->attach($request->id_responsable, [
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
        ]);

        return back()->with('success', 'Responsable asociado exitosamente.');
    }
}
