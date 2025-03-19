<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        return response()->json(Venta::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'idProducto' => 'required|exists:productos,id',
            'idUsuario' => 'required|exists:usuarios,id'
        ]);

        $venta = Venta::create($request->all());

        return response()->json($venta, 201);
    }

    public function show($id)
    {
        $venta = Venta::find($id);
        if (!$venta) return response()->json(['message' => 'Venta no encontrada'], 404);

        return response()->json($venta, 200);
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::find($id);
        if (!$venta) return response()->json(['message' => 'Venta no encontrada'], 404);

        $venta->update($request->all());
        return response()->json($venta, 200);
    }

    public function destroy($id)
    {
        $venta = Venta::find($id);
        if (!$venta) return response()->json(['message' => 'Venta no encontrada'], 404);

        $venta->delete();
        return response()->json(['message' => 'Venta eliminada'], 200);
    }
}
