<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function index()
    {
        $alertas = Alerta::with('proveedor')->get();
        return response()->json($alertas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipoMensaje' => 'required|string',
            'fecha' => 'required|date',
            'estadoProducto' => 'required|string',
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        $alerta = Alerta::create($request->all());
        return response()->json($alerta, 201);
    }

    public function show($id)
    {
        $alerta = Alerta::find($id);

        if (!$alerta) {
            return response()->json(['message' => 'Alerta no encontrada'], 404);
        }

        return response()->json($alerta, 200);
    }

    public function update(Request $request, $id)
    {
        $alerta = Alerta::findOrFail($id);

        $request->validate([
            'tipoMensaje' => 'string',
            'fecha' => 'date',
            'estadoProducto' => 'string',
            'proveedor_id' => 'exists:proveedores,id',
        ]);

        $alerta->update($request->all());
        return response()->json($alerta);
    }

    public function destroy($id)
    {
        Alerta::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
