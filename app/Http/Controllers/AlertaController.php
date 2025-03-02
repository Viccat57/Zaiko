<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function index()
    {
        return response()->json(Alerta::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipoMensaje' => 'required|string',
            'fecha' => 'required|date',
            'estadoProducto' => 'required|string',
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
        $alerta = Alerta::find($id);

        if (!$alerta) {
            return response()->json(['message' => 'Alerta no encontrada'], 404);
        }

        $alerta->update($request->all());

        return response()->json($alerta, 200);
    }

    public function destroy($id)
    {
        $alerta = Alerta::find($id);

        if (!$alerta) {
            return response()->json(['message' => 'Alerta no encontrada'], 404);
        }

        $alerta->delete();

        return response()->json(['message' => 'Alerta eliminada'], 200);
    }
}

