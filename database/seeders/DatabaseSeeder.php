<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Pancho Altamirano',
            'email' => 'qwerty@za.com',
            'password' => Hash::make('12345678'),
        ]);

        User::factory()->create([
            'name' => 'Gabriel',
            'email' => 'gabriel@za.com',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Paquita la del Barrio',
            'email' => 'paquita@za.com',
            'password' => Hash::make('12345678'),
        ]);
        // Crear productos y ventas
        $this->call([
            ProductoSeeder::class,
            DetalleVentaSeeder::class,
            VentaSeeder::class,
        ]);


    }
}
