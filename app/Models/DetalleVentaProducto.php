<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVentaProducto extends Model
{
    use HasFactory;

    protected $table = 'detalle_ventas_producto';
    protected $primaryKey = 'idDetalle';
    protected $fillable = ['idVenta', 'idProducto', 'subtotal'];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idVenta');
    }
}
