<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    protected $fillable = ['fecha', 'total', 'id_producto', 'id_user'];

    public function detalles()
    {
        return $this->hasMany(DetalleVentaProducto::class, 'id_venta');
    }
}
