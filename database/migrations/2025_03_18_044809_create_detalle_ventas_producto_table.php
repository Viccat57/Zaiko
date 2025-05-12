<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detalle_ventas_producto', function (Blueprint $table) {
            $table->id('idDetalle'); // Clave primaria
            $table->unsignedBigInteger('idVenta');
            $table->foreign('idVenta')->references('idVenta')->on('ventas')->onDelete('cascade');
            $table->foreignId('idProducto')->constrained('productos')->onDelete('cascade');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas_producto');
    }
};
