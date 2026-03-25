<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Emprendedor;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;

class EmprendedorWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Emprendedor::with('emprendimientos');

        if ($request->filled('busqueda')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('apellidos', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('ci', 'like', '%' . $request->busqueda . '%');
            });
        }

        $emprendedores = $query->latest()->paginate(15)->withQueryString();
        return view('emprendedores.index', compact('emprendedores'));
    }

    public function create()
    {
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        return view('emprendedores.create', compact('emprendimientos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:100',
            'apellidos'    => 'required|string|max:100',
            'edad'         => 'nullable|integer|min:1|max:120',
            'sexo'         => 'nullable|in:M,F,Otro',
            'ci'           => 'nullable|string|max:50',
            'celular'      => 'nullable|string|max:20',
            'correo'       => 'nullable|email|max:100',
            'direccion'    => 'nullable|string|max:255',
            'carrera'      => 'nullable|string|max:100',
            'año_estudio'  => 'nullable|string|max:50',
        ]);

        $emprendedor = Emprendedor::create($validated);

        // Asociar emprendimiento si se seleccionó
        if ($request->filled('emprendimiento_id')) {
            $emprendedor->emprendimientos()->attach($request->emprendimiento_id, [
                'es_responsable_principal' => $request->boolean('es_responsable_principal'),
            ]);
        }

        return redirect('/emprendedores')->with('success', 'Emprendedor registrado exitosamente.');
    }

    public function show($id)
    {
        $emprendedor = Emprendedor::with('emprendimientos.categoria')->findOrFail($id);
        return view('emprendedores.show', compact('emprendedor'));
    }

    public function edit($id)
    {
        $emprendedor = Emprendedor::findOrFail($id);
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        return view('emprendedores.edit', compact('emprendedor', 'emprendimientos'));
    }

    public function update(Request $request, $id)
    {
        $emprendedor = Emprendedor::findOrFail($id);

        $validated = $request->validate([
            'nombre'       => 'required|string|max:100',
            'apellidos'    => 'required|string|max:100',
            'edad'         => 'nullable|integer|min:1|max:120',
            'sexo'         => 'nullable|in:M,F,Otro',
            'ci'           => 'nullable|string|max:50',
            'celular'      => 'nullable|string|max:20',
            'correo'       => 'nullable|email|max:100',
            'direccion'    => 'nullable|string|max:255',
            'carrera'      => 'nullable|string|max:100',
            'año_estudio'  => 'nullable|string|max:50',
        ]);

        $emprendedor->update($validated);
        return redirect('/emprendedores/' . $id)->with('success', 'Emprendedor actualizado.');
    }

    public function destroy($id)
    {
        Emprendedor::findOrFail($id)->delete();
        return redirect('/emprendedores')->with('success', 'Emprendedor eliminado.');
    }
}
