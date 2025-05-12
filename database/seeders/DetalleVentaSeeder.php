<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetalleVentaProducto;
use App\Models\Venta;
use App\Models\Producto;

class DetalleVentaSeeder extends Seeder
{
    public function run(): void
    {
        $ventas = Venta::all();
        $productos = Producto::inRandomOrder()->get();

        foreach ($ventas as $venta) {
            // Seleccionar de 2 a 4 productos aleatorios por venta
            $items = $productos->random(rand(2, 4));
            $total = 0;

            foreach ($items as $producto) {
                $subtotal = $producto->precio; // Aquí puedes simular cantidades si quieres

                DetalleVentaProducto::create([
                    'idVenta' => $venta->idVenta,
                    'idProducto' => $producto->id,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            // Actualizar el total en la tabla ventas
            $venta->update(['total' => $total]);
        }
    }
}
