<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreProducto' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'idUsuario' => 'required|exists:users,id',
            'idAlerta' => 'nullable|exists:alertas,id',
        ]);

        $producto = Producto::create($request->all());

        return response()->json($producto, 201);
    }

    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $request->validate([
            'nombreProducto' => 'sometimes|required|string',
            'descripcion' => 'sometimes|required|string',
            'precio' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'idUsuario' => 'sometimes|required|exists:users,id',
            'idAlerta' => 'nullable|exists:alertas,id',
        ]);

        $producto->update($request->all());

        return response()->json($producto, 200);
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}
