<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function index()
    {
        $alertas = Alerta::with(['proveedor', 'producto'])->get();
        return response()->json($alertas);
    }

    public function store(Request $request)
    {
        $rules = [
            'tipoMensaje' => 'required|string|in:Alerta de producto,Alerta de proveedor',
            'fecha' => 'required|date',
            'estadoProducto' => 'required|string',
            'proveedor_id' => 'required|exists:proveedores,id',
        ];

        // Añadir validación de producto_id solo si tipoMensaje es "Alerta de producto"
        if ($request->input('tipoMensaje') === 'Alerta de producto') {
            $rules['producto_id'] = 'required|exists:productos,id';
        }

        $request->validate($rules);

        $alerta = Alerta::create($request->all());
        return response()->json($alerta, 201);
    }

    public function update(Request $request, $id)
    {
        $alerta = Alerta::findOrFail($id);

        $rules = [
            'tipoMensaje' => 'string|in:Alerta de producto,Alerta de proveedor',
            'fecha' => 'date',
            'estadoProducto' => 'string',
            'proveedor_id' => 'exists:proveedores,id',
        ];

        // Añadir validación de producto_id solo si tipoMensaje es "Alerta de producto"
        if ($request->input('tipoMensaje') === 'Alerta de producto') {
            $rules['producto_id'] = 'required|exists:productos,id';
        }

        $request->validate($rules);

        $alerta->update($request->all());
        return response()->json($alerta);
    }

    public function destroy($id)
    {
        Alerta::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}