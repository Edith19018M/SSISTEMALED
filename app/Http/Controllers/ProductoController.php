<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Listar todos los productos
     */
    public function index()
    {
        $productos = Producto::with('emprendimiento')->paginate(15);
        return response()->json($productos);
    }

    /**
     * Crear un nuevo producto
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_referencial' => 'nullable|numeric|min:0',
            'atributos' => 'nullable|json'
        ]);

        $producto = Producto::create($validated);
        return response()->json($producto, 201);
    }

    /**
     * Mostrar un producto específico
     */
    public function show($id)
    {
        $producto = Producto::with('emprendimiento')->findOrFail($id);
        return response()->json($producto);
    }

    /**
     * Actualizar un producto
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_referencial' => 'nullable|numeric|min:0',
            'atributos' => 'nullable|json'
        ]);

        $producto->update($validated);
        return response()->json($producto);
    }

    /**
     * Eliminar un producto
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(null, 204);
    }

    /**
     * Listar productos de un emprendimiento
     */
    public function porEmprendimiento($id)
    {
        $productos = Producto::where('id_emprendimiento', $id)->get();
        return response()->json($productos);
    }
}
