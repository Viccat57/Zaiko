<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVentaProducto extends Model
{
    use HasFactory;

    protected $table = 'detalle_ventas_producto';
    protected $primaryKey = 'id_detalle';
    protected $fillable = ['id_venta', 'id_producto', 'subtotal'];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

}
