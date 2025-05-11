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
        Schema::table('alertas', function (Blueprint $table) {
            $table->unsignedBigInteger('proveedor_id'); // Asegúrate de usar unsignedBigInteger
            $table->foreign('proveedor_id')
                  ->references('id')
                  ->on('proveedores')
                  ->onDelete('CASCADE'); // O la acción que prefieras
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alertas', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']); // Elimina la restricción de clave foránea primero
            $table->dropColumn('proveedor_id');
        });
    }
};