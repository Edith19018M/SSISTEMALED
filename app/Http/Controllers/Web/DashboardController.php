<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use App\Models\UnidadProductiva;
use App\Models\Usuario;
use App\Models\SeguimientoEmprendimiento;
use App\Models\SeguimientoUnidad;
use App\Models\Emprendedor;
use App\Models\Responsable;
use App\Models\Asesoria;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'emprendimientos'    => Emprendimiento::count(),
            'unidades'           => UnidadProductiva::count(),
            'usuarios'           => Usuario::count(),
            'emprendedores'      => Emprendedor::count(),
            'responsables'       => Responsable::count(),
            'seguimientos_emp'   => SeguimientoEmprendimiento::count(),
            'seguimientos_uni'   => SeguimientoUnidad::count(),
            'asesorias'          => Asesoria::count(),
        ];

        $emprendimientos = Emprendimiento::with('categoria', 'municipio')
            ->latest()
            ->take(5)
            ->get();

        $unidades = UnidadProductiva::with('categoria', 'municipio')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'emprendimientos', 'unidades'));
    }
}
