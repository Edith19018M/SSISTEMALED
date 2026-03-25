<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Responsable;
use Illuminate\Http\Request;

class ResponsableWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Responsable::with('unidadesProductivas');

        if ($request->filled('busqueda')) {
            $query->where('nombre', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('ci', 'like', '%' . $request->busqueda . '%');
        }

        $responsables = $query->latest()->paginate(15)->withQueryString();
        return view('responsables.index', compact('responsables'));
    }

    public function create()
    {
        return view('responsables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'contacto'  => 'nullable|string|max:100',
            'ci'        => 'nullable|string|max:50',
            'correo'    => 'nullable|email|max:100',
        ]);

        Responsable::create($request->only(['nombre', 'contacto', 'ci', 'correo']));
        return redirect('/responsables')->with('success', 'Responsable registrado exitosamente.');
    }

    public function edit($id)
    {
        $responsable = Responsable::findOrFail($id);
        return view('responsables.edit', compact('responsable'));
    }

    public function update(Request $request, $id)
    {
        $responsable = Responsable::findOrFail($id);
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'contacto'  => 'nullable|string|max:100',
            'ci'        => 'nullable|string|max:50',
            'correo'    => 'nullable|email|max:100',
        ]);

        $responsable->update($request->only(['nombre', 'contacto', 'ci', 'correo']));
        return redirect('/responsables')->with('success', 'Responsable actualizado.');
    }

    public function destroy($id)
    {
        Responsable::findOrFail($id)->delete();
        return redirect('/responsables')->with('success', 'Responsable eliminado.');
    }
}
