<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    
    public function index()
    {
        $proveedores = Proveedores::all();
        return response()->json($proveedores);
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:proveedores,email',
        ]);

        $proveedor = Proveedores::create($request->all());
        return response()->json($proveedor, 201);
    }


    public function show($id)
    {
        $proveedor = Proveedores::findOrFail($id);
        return response()->json($proveedor);
    }

 
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'telefono' => 'sometimes|required|string|max:20',
            'email' => 'sometimes|required|email|unique:proveedores,email,' . $id,
        ]);

        $proveedor = Proveedores::findOrFail($id);
        $proveedor->update($request->all());

        return response()->json($proveedor);
    }


    public function destroy($id)
    {
        $proveedor = Proveedores::findOrFail($id);
        $proveedor->delete();
        return response()->json(['message' => 'Proveedor eliminado correctamente']);
    }
}
