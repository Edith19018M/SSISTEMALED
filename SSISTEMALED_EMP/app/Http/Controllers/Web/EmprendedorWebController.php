<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Emprendedor;
use App\Models\Emprendimiento;
use App\Models\Municipio;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmprendedorWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Emprendedor::with('emprendimiento');

        if ($request->filled('busqueda')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('apellidos', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('ci', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('codigo', 'like', '%' . $request->busqueda . '%');
            });
        }

        $emprendedores = $query->latest()->paginate(15)->withQueryString();
        return view('emprendedores.index', compact('emprendedores'));
    }

    public function create()
    {
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        // Si viene desde la vista de un emprendimiento específico
        $emprendimiento_id = request('emprendimiento_id');
        return view('emprendedores.create', compact('emprendimientos', 'emprendimiento_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'nombre'          => 'required|string|max:100',
            'apellidos'       => 'required|string|max:100',
            'edad'            => 'nullable|integer|min:1|max:120',
            'sexo'            => 'nullable|in:M,F,Otro',
            'ci'              => 'required|string|max:50|unique:emprendedores,ci',
            'celular'         => 'nullable|string|max:20',
            'correo'          => 'nullable|email|max:100',
            'direccion'       => 'nullable|string|max:255',
            'carrera'         => 'nullable|string|max:100',
            'año_estudio'     => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            $codigo = $this->generarCodigo($request->id_emprendimiento);

            $emprendedor = Emprendedor::create(array_merge(
                $request->only([
                    'id_emprendimiento', 'nombre', 'apellidos',
                    'edad', 'sexo', 'ci', 'celular', 'correo',
                    'direccion', 'carrera', 'año_estudio',
                ]),
                ['codigo' => $codigo]
            ));

            // Auto-crear usuario con CI como correo y contraseña
            $rolEmprendedor = Rol::where('nombre_rol', 'Emprendedor')->first();
            if ($rolEmprendedor) {
                Usuario::create([
                    'nombre'         => $emprendedor->nombre . ' ' . $emprendedor->apellidos,
                    'correo'         => $emprendedor->ci . '@emp.local',
                    'contraseña'     => Hash::make($emprendedor->ci),
                    'rol_id'         => $rolEmprendedor->id_rol,
                    'emprendedor_id' => $emprendedor->id_emprendedor,
                ]);
            }
        });

        $destino = $request->filled('redirect_to') ? $request->redirect_to : '/emprendedores';
        return redirect($destino)->with('success',
            'Emprendedor registrado. Usuario creado: correo = ' . $request->ci . '@emp.local | contraseña = ' . $request->ci
        );
    }

    public function show($id)
    {
        $emprendedor = Emprendedor::with('emprendimiento.categoria')->findOrFail($id);
        return view('emprendedores.show', compact('emprendedor'));
    }

    public function edit($id)
    {
        $emprendedor = Emprendedor::findOrFail($id);
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        return view('emprendedores.edit', compact('emprendedor', 'emprendimientos'));
    }

    private function generarCodigo(int $emprendimientoId): string
    {
        $emprendimiento = Emprendimiento::with('municipio')->find($emprendimientoId);
        $municipioNombre = $emprendimiento?->municipio?->nombre_municipio ?? 'Xx';

        // Abreviatura: primera letra de cada palabra, máx 3 caracteres
        $palabras = preg_split('/\s+/', trim($municipioNombre));
        $abrev = '';
        foreach ($palabras as $i => $palabra) {
            $letra = mb_strtoupper(mb_substr($palabra, 0, 1));
            if ($i === 0) {
                $abrev .= $letra . mb_strtolower(mb_substr($palabra, 1, 1));
            } else {
                $abrev .= $letra;
            }
        }

        $año = date('Y');
        $secuencial = Emprendedor::count() + 1;

        return "E-{$año}{$abrev}{$secuencial}";
    }

    public function update(Request $request, $id)
    {
        $emprendedor = Emprendedor::findOrFail($id);

        $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'nombre'            => 'required|string|max:100',
            'apellidos'         => 'required|string|max:100',
            'edad'              => 'nullable|integer|min:1|max:120',
            'sexo'              => 'nullable|in:M,F,Otro',
            'ci'                => 'nullable|string|max:50',
            'celular'           => 'nullable|string|max:20',
            'correo'            => 'nullable|email|max:100',
            'direccion'         => 'nullable|string|max:255',
            'carrera'           => 'nullable|string|max:100',
            'año_estudio'       => 'nullable|string|max:50',
        ]);

        $emprendedor->update($request->only([
            'id_emprendimiento', 'nombre', 'apellidos',
            'edad', 'sexo', 'ci', 'celular', 'correo',
            'direccion', 'carrera', 'año_estudio',
        ]));

        return redirect('/emprendedores/' . $id)->with('success', 'Emprendedor actualizado.');
    }

    public function destroy($id)
    {
        Emprendedor::findOrFail($id)->delete();
        return redirect('/emprendedores')->with('success', 'Emprendedor eliminado.');
    }

    public function registroPublico()
    {
        $emprendimientos = Emprendimiento::orderBy('nombre')->get();
        return view('emprendedores.registro-publico', compact('emprendimientos'));
    }

    public function registroPublicoStore(Request $request)
    {
        $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'nombre'            => 'required|string|max:100',
            'apellidos'         => 'required|string|max:100',
            'edad'              => 'nullable|integer|min:1|max:120',
            'sexo'              => 'nullable|in:M,F,Otro',
            'ci'                => 'required|string|max:50|unique:emprendedores,ci',
            'celular'           => 'nullable|string|max:20',
            'correo'            => 'nullable|email|max:100',
            'direccion'         => 'nullable|string|max:255',
            'carrera'           => 'nullable|string|max:100',
            'año_estudio'       => 'nullable|string|max:50',
            'contrasena'        => 'required|string|min:6|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $codigo = $this->generarCodigo($request->id_emprendimiento);

            $emprendedor = Emprendedor::create(array_merge(
                $request->only([
                    'id_emprendimiento', 'nombre', 'apellidos',
                    'edad', 'sexo', 'ci', 'celular', 'correo',
                    'direccion', 'carrera', 'año_estudio',
                ]),
                ['codigo' => $codigo]
            ));

            $rolEmprendedor = Rol::where('nombre_rol', 'Emprendedor')->first();
            if ($rolEmprendedor) {
                Usuario::create([
                    'nombre'         => $emprendedor->nombre . ' ' . $emprendedor->apellidos,
                    'correo'         => $emprendedor->ci . '@emp.local',
                    'contraseña'     => Hash::make($request->contrasena),
                    'rol_id'         => $rolEmprendedor->id_rol,
                    'emprendedor_id' => $emprendedor->id_emprendedor,
                ]);
            }
        });

        return redirect('/login')->with('success',
            'Registro exitoso. Tu usuario es: ' . $request->ci . '@emp.local'
        );
    }
}
