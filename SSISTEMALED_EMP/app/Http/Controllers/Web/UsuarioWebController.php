<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Region;
use App\Models\Municipio;
use App\Models\Emprendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::with('rol', 'region', 'municipio');

        if ($request->filled('busqueda')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('correo', 'like', '%' . $request->busqueda . '%');
            });
        }

        if ($request->filled('rol_id')) {
            $query->where('rol_id', $request->rol_id);
        }

        $usuarios = $query->latest()->paginate(15)->withQueryString();
        $roles = Rol::all();
        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    public function create()
    {
        $roles = Rol::all();
        $regiones = Region::orderBy('nombre_region')->get();
        $municipios = Municipio::with('region')->orderBy('nombre_municipio')->get();
        $emprendedores = Emprendedor::orderBy('nombre')->get();
        return view('usuarios.create', compact('roles', 'regiones', 'municipios', 'emprendedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:100',
            'correo'        => 'required|email|unique:usuarios,correo',
            'contraseña'    => 'required|string|min:6|confirmed',
            'rol_id'        => 'required|exists:roles,id_rol',
            'region_id'     => 'nullable|exists:regiones,id_region',
            'municipio_id'  => 'nullable|exists:municipios,id_municipio',
            'emprendedor_id' => 'nullable|exists:emprendedores,id_emprendedor',
        ]);

        Usuario::create([
            'nombre'         => $request->nombre,
            'correo'         => $request->correo,
            'contraseña'     => Hash::make($request->contraseña),
            'rol_id'         => $request->rol_id,
            'region_id'      => $request->region_id,
            'municipio_id'   => $request->municipio_id,
            'emprendedor_id' => $request->emprendedor_id,
        ]);

        return redirect('/usuarios')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::all();
        $regiones = Region::orderBy('nombre_region')->get();
        $municipios = Municipio::with('region')->orderBy('nombre_municipio')->get();
        $emprendedores = Emprendedor::orderBy('nombre')->get();
        return view('usuarios.edit', compact('usuario', 'roles', 'regiones', 'municipios', 'emprendedores'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre'         => 'required|string|max:100',
            'correo'         => 'required|email|unique:usuarios,correo,' . $id . ',id_usuario',
            'rol_id'         => 'required|exists:roles,id_rol',
            'region_id'      => 'nullable|exists:regiones,id_region',
            'municipio_id'   => 'nullable|exists:municipios,id_municipio',
            'emprendedor_id' => 'nullable|exists:emprendedores,id_emprendedor',
        ]);

        $data = $request->only(['nombre', 'correo', 'rol_id', 'region_id', 'municipio_id', 'emprendedor_id']);

        if ($request->filled('contraseña')) {
            $request->validate(['contraseña' => 'min:6|confirmed']);
            $data['contraseña'] = Hash::make($request->contraseña);
        }

        $usuario->update($data);
        return redirect('/usuarios')->with('success', 'Usuario actualizado.');
    }

    public function destroy($id)
    {
        if ($id == session('usuario_id')) {
            return back()->with('error', 'No puede eliminar su propio usuario.');
        }
        Usuario::findOrFail($id)->delete();
        return redirect('/usuarios')->with('success', 'Usuario eliminado.');
    }
}
