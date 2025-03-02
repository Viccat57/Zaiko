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
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->string('tipoMensaje'); // Columna para el tipo de mensaje (string)
            $table->dateTime('fecha'); // Columna para la fecha y hora (datetime)
            $table->string('estadoProducto'); // Columna para el estado del producto (string)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};
