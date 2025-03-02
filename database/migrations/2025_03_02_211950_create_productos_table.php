<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombreProducto'); // Columna para el nombre del producto
            $table->text('descripcion'); // Columna para la descripción del producto
            $table->decimal('precio', 8, 2); // Columna para el precio (8 dígitos en total, 2 decimales)
            $table->integer('stock'); // Columna para el stock (número entero)
            $table->unsignedBigInteger('idUsuario'); // Columna para el ID del usuario (clave foránea)
            $table->unsignedBigInteger('idAlerta'); // Columna para el ID de la alerta (clave foránea)
            $table->timestamps();
            // Definir claves foráneas
            $table->foreign('idUsuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idAlerta')->references('id')->on('alertas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
