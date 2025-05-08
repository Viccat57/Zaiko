<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlertasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Borrar datos existentes (opcional)
        DB::table('alertas')->truncate();

        $alertas = [
            [
                'tipoMensaje' => 'Notificación de stock',
                'fecha' => Carbon::now()->subDays(2),
                'estadoProducto' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipoMensaje' => 'Alerta de inventario',
                'fecha' => Carbon::now()->subDays(1),
                'estadoProducto' => 'agotado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipoMensaje' => 'Actualización de producto',
                'fecha' => Carbon::now(),
                'estadoProducto' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipoMensaje' => 'Urgente: producto agotado',
                'fecha' => Carbon::now()->subHours(5),
                'estadoProducto' => 'agotado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipoMensaje' => 'Reabastecimiento completado',
                'fecha' => Carbon::now()->subHours(2),
                'estadoProducto' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('alertas')->insert($alertas);
    }
}
