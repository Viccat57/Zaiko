<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alerta extends Model
{
    use HasFactory;

    protected $fillable = ['tipoMensaje', 'fecha', 'estadoProducto', 'proveedor_id', 'producto_id'];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedores::class, 'proveedor_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($alerta) {
            if (!Proveedores::where('id', $alerta->proveedor_id)->exists()) {
                throw new \Exception("El proveedor no existe");
            }
            // Solo validar producto_id si tipoMensaje es "Alerta de producto"
            if ($alerta->tipoMensaje === 'Alerta de producto' && !Producto::where('id', $alerta->producto_id)->exists()) {
                throw new \Exception("El producto no existe");
            }
        });

        static::deleting(function ($alerta) {
            // No additional deletion logic needed since cascade is handled by DB
        });
    }
}