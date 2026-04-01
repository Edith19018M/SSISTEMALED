<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\UnidadProductiva;
use Illuminate\Http\Request;

class CompraVentaWebController extends Controller
{
    // ======= COMPRAS =======

    public function indexCompras(Request $request)
    {
        $query = Compra::with('unidad');

        if ($request->filled('unidad_id')) {
            $query->where('id_unidad', $request->unidad_id);
        }

        $compras = $query->latest()->paginate(15)->withQueryString();
        $unidades = UnidadProductiva::orderBy('nombre')->get();
        return view('compras.index', compact('compras', 'unidades'));
    }

    public function createCompra()
    {
        $unidades = UnidadProductiva::orderBy('nombre')->get();
        return view('compras.create', compact('unidades'));
    }

    public function storeCompra(Request $request)
    {
        $request->validate([
            'id_unidad' => 'required|exists:unidades_productivas,id_unidad',
            'fecha'     => 'required|date',
            'producto'  => 'required|string|max:255',
            'cantidad'  => 'required|integer|min:1',
            'costo'     => 'required|numeric|min:0',
        ]);

        Compra::create($request->only(['id_unidad', 'fecha', 'producto', 'cantidad', 'costo']));
        return redirect('/compras')->with('success', 'Compra registrada exitosamente.');
    }

    public function destroyCompra($id)
    {
        Compra::findOrFail($id)->delete();
        return redirect('/compras')->with('success', 'Compra eliminada.');
    }

    // ======= VENTAS =======

    public function indexVentas(Request $request)
    {
        $query = Venta::with('unidad');

        if ($request->filled('unidad_id')) {
            $query->where('id_unidad', $request->unidad_id);
        }

        $ventas = $query->latest()->paginate(15)->withQueryString();
        $unidades = UnidadProductiva::orderBy('nombre')->get();
        return view('ventas.index', compact('ventas', 'unidades'));
    }

    public function createVenta()
    {
        $unidades = UnidadProductiva::orderBy('nombre')->get();
        return view('ventas.create', compact('unidades'));
    }

    public function storeVenta(Request $request)
    {
        $request->validate([
            'id_unidad' => 'required|exists:unidades_productivas,id_unidad',
            'fecha'     => 'required|date',
            'producto'  => 'required|string|max:255',
            'cantidad'  => 'required|integer|min:1',
            'precio'    => 'required|numeric|min:0',
        ]);

        Venta::create($request->only(['id_unidad', 'fecha', 'producto', 'cantidad', 'precio']));
        return redirect('/ventas')->with('success', 'Venta registrada exitosamente.');
    }

    public function destroyVenta($id)
    {
        Venta::findOrFail($id)->delete();
        return redirect('/ventas')->with('success', 'Venta eliminada.');
    }
}
