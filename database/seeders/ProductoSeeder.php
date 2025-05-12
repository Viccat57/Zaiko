<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\User;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener un usuario aleatorio (si hay usuarios en la base)
        $user = User::inRandomOrder()->first();

        // Productos de abarrotes
        $productos = [
            [
                'nombreProducto' => 'Arroz 1kg',
                'descripcion' => 'Paquete de arroz blanco de 1 kilogramo.',
                'precio' => 18.50,
                'stock' => 100,
            ],
            [
                'nombreProducto' => 'Frijoles negros 900g',
                'descripcion' => 'Frijoles negros secos, paquete de 900 gramos.',
                'precio' => 22.00,
                'stock' => 80,
            ],
            [
                'nombreProducto' => 'Aceite vegetal 1L',
                'descripcion' => 'Botella de aceite vegetal comestible de 1 litro.',
                'precio' => 35.75,
                'stock' => 60,
            ],
            [
                'nombreProducto' => 'Azúcar 1kg',
                'descripcion' => 'Bolsa de azúcar refinada de 1 kilogramo.',
                'precio' => 20.00,
                'stock' => 90,
            ],
            [
                'nombreProducto' => 'Papel higiénico (4 rollos)',
                'descripcion' => 'Paquete con 4 rollos de papel higiénico doble hoja.',
                'precio' => 25.00,
                'stock' => 50,
            ],
            [
                'nombreProducto' => 'Leche entera 1L',
                'descripcion' => 'Caja de leche entera ultrapasteurizada de 1 litro.',
                'precio' => 17.25,
                'stock' => 70,
            ],
        ];

        foreach ($productos as $item) {
            Producto::create([
                'nombreProducto' => $item['nombreProducto'],
                'descripcion' => $item['descripcion'],
                'precio' => $item['precio'],
                'stock' => $item['stock'],
                'idUsuario' => $user?->id,
            ]);
        }
    }
}
