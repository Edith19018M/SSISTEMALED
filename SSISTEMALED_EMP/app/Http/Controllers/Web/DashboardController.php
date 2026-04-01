<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use App\Models\Usuario;
use App\Models\SeguimientoEmprendimiento;
use App\Models\Emprendedor;
use App\Models\Asesoria;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'emprendimientos'    => Emprendimiento::count(),
            'usuarios'           => Usuario::count(),
            'emprendedores'      => Emprendedor::count(),
            'seguimientos_emp'   => SeguimientoEmprendimiento::count(),
            'asesorias'          => Asesoria::count(),
        ];

        $emprendimientos = Emprendimiento::with('categoria', 'municipio')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'emprendimientos'));
    }
}
