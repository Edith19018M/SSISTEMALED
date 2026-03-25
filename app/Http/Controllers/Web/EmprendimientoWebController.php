<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use App\Models\CategoriaEmprendimiento;
use App\Models\Municipio;
use Illuminate\Http\Request;

class EmprendimientoWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Emprendimiento::with('categoria', 'municipio', 'emprendedores');

        if ($request->filled('busqueda')) {
            $query->where('nombre', 'like', '%' . $request->busqueda . '%');
        }
        if ($request->filled('estado')) {
            $query->where('estado_proceso', $request->estado);
        }

        $emprendimientos = $query->latest()->paginate(15)->withQueryString();
        return view('emprendimientos.index', compact('emprendimientos'));
    }

    public function create()
    {
        $categorias = CategoriaEmprendimiento::orderBy('nombre_categoria')->get();
        $municipios = Municipio::with('region')->orderBy('nombre_municipio')->get();
        return view('emprendimientos.create', compact('categorias', 'municipios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'         => 'required|string|max:255',
            'categoria_id'   => 'required|exists:categorias_emprendimiento,id_categoria',
            'municipio_id'   => 'required|exists:municipios,id_municipio',
            'estado_proceso' => 'nullable|string|max:100',
            'direccion'      => 'nullable|string|max:255',
            'sector_rubro'   => 'nullable|string|max:100',
        ]);

        $validated['estado_proceso'] = $validated['estado_proceso'] ?? 'pendiente';

        Emprendimiento::create($validated);
        return redirect('/emprendimientos')->with('success', 'Emprendimiento creado exitosamente.');
    }

    public function show($id)
    {
        $emprendimiento = Emprendimiento::with([
            'categoria', 'municipio', 'productos',
            'emprendedores', 'formularios', 'entrevistas',
            'planesNegocio', 'seguimientos.compromisos', 'asesorias',
            'historial'
        ])->findOrFail($id);

        return view('emprendimientos.show', compact('emprendimiento'));
    }

    public function edit($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $categorias = CategoriaEmprendimiento::orderBy('nombre_categoria')->get();
        $municipios = Municipio::with('region')->orderBy('nombre_municipio')->get();
        return view('emprendimientos.edit', compact('emprendimiento', 'categorias', 'municipios'));
    }

    public function update(Request $request, $id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);

        $validated = $request->validate([
            'nombre'         => 'required|string|max:255',
            'categoria_id'   => 'required|exists:categorias_emprendimiento,id_categoria',
            'municipio_id'   => 'required|exists:municipios,id_municipio',
            'estado_proceso' => 'nullable|string|max:100',
            'direccion'      => 'nullable|string|max:255',
            'sector_rubro'   => 'nullable|string|max:100',
        ]);

        $emprendimiento->update($validated);
        return redirect('/emprendimientos/' . $id)->with('success', 'Emprendimiento actualizado.');
    }

    public function destroy($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $emprendimiento->delete();
        return redirect('/emprendimientos')->with('success', 'Emprendimiento eliminado.');
    }
}
