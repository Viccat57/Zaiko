<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class DetalleVentaProductoController extends Controller
{
    /**
     * Obtiene los detalles de una venta específica
     *
     * @param  int  $idVenta
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($idVenta)
    {
        try {
            // Obtener los detalles de venta con información del producto
            $detalles = DB::table('detalle_ventas_producto as dv')
                ->join('productos as p', 'dv.idProducto', '=', 'p.id')
                ->where('dv.idVenta', $idVenta)
                ->select(
                    'dv.idDetalle',
                    'dv.idVenta',
                    'dv.idProducto',
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
}
