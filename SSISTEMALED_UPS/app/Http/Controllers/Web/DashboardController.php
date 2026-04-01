<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UnidadProductiva;
use App\Models\Usuario;
use App\Models\SeguimientoUnidad;
use App\Models\Responsable;
use App\Models\Compra;
use App\Models\Venta;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'unidades'           => UnidadProductiva::count(),
            'usuarios'           => Usuario::count(),
            'responsables'       => Responsable::count(),
            'seguimientos_uni'   => SeguimientoUnidad::count(),
            'compras'            => Compra::count(),
            'ventas'             => Venta::count(),
        ];

        $unidades = UnidadProductiva::with('categoria', 'municipio')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'unidades'));
    }
}
