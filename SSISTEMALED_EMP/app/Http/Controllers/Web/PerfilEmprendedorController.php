<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Emprendedor;
use Illuminate\Http\Request;

class PerfilEmprendedorController extends Controller
{
    public function index()
    {
        $emprendedorId = session('emprendedor_id');

        if (!$emprendedorId) {
            return view('perfil.sin-vinculo');
        }

        $emprendedor = Emprendedor::with('emprendimiento')->findOrFail($emprendedorId);

        return view('perfil.index', compact('emprendedor'));
    }

    public function edit()
    {
        $emprendedorId = session('emprendedor_id');

        if (!$emprendedorId) {
            return redirect('/mi-perfil')->with('error', 'No tienes un perfil de emprendedor vinculado.');
        }

        $emprendedor = Emprendedor::findOrFail($emprendedorId);

        return view('perfil.editar', compact('emprendedor'));
    }

    public function update(Request $request)
    {
        $emprendedorId = session('emprendedor_id');

        if (!$emprendedorId) {
            return redirect('/mi-perfil')->with('error', 'No tienes un perfil de emprendedor vinculado.');
        }

        $emprendedor = Emprendedor::findOrFail($emprendedorId);

        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'apellidos'   => 'required|string|max:255',
            'edad'        => 'nullable|integer|min:1|max:120',
            'sexo'        => 'nullable|in:Masculino,Femenino,Otro',
            'ci'          => 'nullable|string|max:20',
            'celular'     => 'nullable|string|max:20',
            'correo'      => 'nullable|email|max:255',
            'direccion'   => 'nullable|string|max:500',
            'carrera'     => 'nullable|string|max:255',
            'año_estudio' => 'nullable|string|max:50',
        ]);

        $emprendedor->update($validated);

        return redirect('/mi-perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
