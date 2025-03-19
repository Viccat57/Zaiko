<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';
    protected $primaryKey = 'idVenta';
    protected $fillable = ['fecha', 'total', 'idProducto', 'idUsuario'];

    public function detalles()
    {
        return $this->hasMany(DetalleVentaProducto::class, 'idVenta');
    }
}
