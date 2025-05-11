<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Alerta extends Model
{
    use HasFactory;

    
    protected $fillable = ['tipoMensaje', 'fecha', 'estadoProducto', 'proveedor_id'];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedores::class, 'proveedor_id');
    }

    protected static function boot()
{
    parent::boot();

    
    static::saving(function ($alerta) {
        if (!Proveedores::where('id', $alerta->proveedor_id)->exists()) {
            throw new \Exception("El proveedor no existe");
        }
    });

    
    static::deleting(function ($proveedor) {
        Alerta::where('proveedor_id', $proveedor->id)->delete();
    });
}
}