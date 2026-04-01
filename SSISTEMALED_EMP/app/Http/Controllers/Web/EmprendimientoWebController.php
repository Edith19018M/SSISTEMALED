<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use App\Models\CategoriaEmprendimiento;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            // Datos del emprendimiento
            'nombre'             => 'required|string|max:255',
            'categoria_id'       => 'required|exists:categorias_emprendimiento,id_categoria',
            'municipio_id'       => 'required|exists:municipios,id_municipio',
            'estado_proceso'     => 'nullable|string|max:100',
            'direccion'          => 'nullable|string|max:255',
            'sector_rubro'       => 'nullable|string|max:100',
            // Datos del primer emprendedor (obligatorio)
            'emp_codigo'         => 'required|string|max:50|unique:emprendedores,codigo',
            'emp_nombre'         => 'required|string|max:100',
            'emp_apellidos'      => 'required|string|max:100',
            'emp_ci'             => 'nullable|string|max:50',
            'emp_edad'           => 'nullable|integer|min:1|max:120',
            'emp_sexo'           => 'nullable|in:M,F,Otro',
            'emp_celular'        => 'nullable|string|max:20',
            'emp_correo'         => 'nullable|email|max:100',
            'emp_carrera'        => 'nullable|string|max:100',
            'emp_año_estudio'    => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            $emprendimiento = Emprendimiento::create([
                'nombre'         => $request->nombre,
                'categoria_id'   => $request->categoria_id,
                'municipio_id'   => $request->municipio_id,
                'estado_proceso' => $request->estado_proceso ?? 'pendiente',
                'direccion'      => $request->direccion,
                'sector_rubro'   => $request->sector_rubro,
            ]);

            $emprendimiento->emprendedores()->create([
                'codigo'       => $request->emp_codigo,
                'nombre'       => $request->emp_nombre,
                'apellidos'    => $request->emp_apellidos,
                'ci'           => $request->emp_ci,
                'edad'         => $request->emp_edad,
                'sexo'         => $request->emp_sexo,
                'celular'      => $request->emp_celular,
                'correo'       => $request->emp_correo,
                'carrera'      => $request->emp_carrera,
                'año_estudio'  => $request->emp_año_estudio,
            ]);
        });

        return redirect('/emprendimientos')->with('success', 'Emprendimiento creado con su primer emprendedor.');
    }

    public function show($id)
    {
        $emprendimiento = Emprendimiento::with([
            'categoria', 'municipio', 'productos',
            'emprendedores', 'formularios', 'entrevistas',
            'planesNegocio', 'seguimientos.compromisos', 'asesorias',
            'historial',
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

        $request->validate([
            'nombre'         => 'required|string|max:255',
            'categoria_id'   => 'required|exists:categorias_emprendimiento,id_categoria',
            'municipio_id'   => 'required|exists:municipios,id_municipio',
            'estado_proceso' => 'nullable|string|max:100',
            'direccion'      => 'nullable|string|max:255',
            'sector_rubro'   => 'nullable|string|max:100',
        ]);

        $emprendimiento->update($request->only(['nombre', 'categoria_id', 'municipio_id', 'estado_proceso', 'direccion', 'sector_rubro']));
        return redirect('/emprendimientos/' . $id)->with('success', 'Emprendimiento actualizado.');
    }

    public function destroy($id)
    {
        Emprendimiento::findOrFail($id)->delete();
        return redirect('/emprendimientos')->with('success', 'Emprendimiento eliminado.');
    }
}
