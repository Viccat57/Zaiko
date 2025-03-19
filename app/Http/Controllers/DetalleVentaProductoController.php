<?php

namespace App\Http\Controllers;

use App\Models\DetalleVentaProducto;
use Illuminate\Http\Request;

class DetalleVentaProductoController extends Controller
{
    public function index()
    {
        return response()->json(DetalleVentaProducto::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idVenta' => 'required|exists:ventas,idVenta',
            'idProducto' => 'required|exists:productos,id',
            'subtotal' => 'required|numeric'
        ]);

        $detalle = DetalleVentaProducto::create($request->all());

        return response()->json($detalle, 201);
    }

    public function show($id)
    {
        $detalle = DetalleVentaProducto::find($id);
        if (!$detalle) return response()->json(['message' => 'Detalle no encontrado'], 404);

        return response()->json($detalle, 200);
    }

    public function update(Request $request, $id)
    {
        $detalle = DetalleVentaProducto::find($id);
        if (!$detalle) return response()->json(['message' => 'Detalle no encontrado'], 404);

        $detalle->update($request->all());
        return response()->json($detalle, 200);
    }

    public function destroy($id)
    {
        $detalle = DetalleVentaProducto::find($id);
        if (!$detalle) return response()->json(['message' => 'Detalle no encontrado'], 404);

        $detalle->delete();
        return response()->json(['message' => 'Detalle eliminado'], 200);
    }
}

