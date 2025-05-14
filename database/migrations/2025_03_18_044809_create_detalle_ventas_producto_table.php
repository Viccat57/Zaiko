<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detalle_ventas_producto', function (Blueprint $table) {
            $table->id('id_detalle'); // Clave primaria
            $table->unsignedBigInteger('id_venta');
            $table->foreign('id_venta')->references('id_venta')->on('ventas')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('productos')->onDelete('cascade');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas_producto');
    }
};
