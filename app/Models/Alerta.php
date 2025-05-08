<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipoMensaje',
        'fecha',
        'estadoProducto'
    ];

   
    public function producto()
    {
        return $this->hasOne(Producto::class, 'idAlerta');
    }
}