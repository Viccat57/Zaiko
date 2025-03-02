<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $table = 'alertas'; // Nombre de la tabla

    protected $fillable = [
        'tipoMensaje',
        'fecha',
        'estadoProducto'
    ];
}
