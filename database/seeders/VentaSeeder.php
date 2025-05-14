<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use Carbon\Carbon;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 3 ventas distintas con fechas distintas
        for ($i = 1; $i <= 3; $i++) {
            Venta::create([
                'fecha' => Carbon::now(), // Venta de hace X días
                'total' => 0, // Se actualiza luego con el detalle
                'id_user' => 2,
            ]);
        }
    }
}
