<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleVentaProducto;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class DetalleVentaProductoController extends Controller
{
    /**
     * Obtiene los detalles de una venta específica
     *
     * @param  int  $id_venta
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id_venta)
    {
        try {
            // Obtener los detalles de venta con información del producto
            $detalles = DB::table('detalle_ventas_producto as dv')
                ->join('productos as p', 'dv.id_producto', '=', 'p.id')
                ->where('dv.id_venta', $id_venta)
                ->select(
                    'dv.id_detalle',
                    'dv.id_venta',
                    'dv.id_producto',
                    'dv.subtotal',
                    'dv.created_at',
                    'dv.updated_at',
                    'p.nombreProducto',
                    'p.descripcion',
                    'p.precio'
                )
                ->get();

            if ($detalles->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron detalles para esta venta'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'detalles' => $detalles
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los detalles de la venta',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_venta' => 'required|integer|exists:ventas,id_venta',
            'id_producto' => 'required|integer|exists:productos,id',
            'subtotal' => 'required|numeric|min:0',
        ]);

        try {
            $detalle = DetalleVentaProducto::create([
                'id_venta' => $request->id_venta,
                'id_producto' => $request->id_producto,
                'subtotal' => $request->subtotal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Detalle de venta creado correctamente',
                'detalle' => $detalle
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el detalle de venta',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
