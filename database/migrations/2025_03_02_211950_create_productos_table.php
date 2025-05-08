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
            $table->string('nombreProducto');
            $table->text('descripcion');
            $table->decimal('precio', 8, 2);
            $table->integer('stock');
            
            // Llaves foráneas correctamente definidas
            $table->foreignId('idUsuario')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('idAlerta')->nullable()->constrained('alertas')->onDelete('set null');
            
            $table->timestamps();
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
