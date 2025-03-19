<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Proveedores extends Model
{
    use HasFactory;

    protected $table = 'proveedores'; // Nombre de la tabla

    protected $fillable = [
        'nombre',
        'telefono',
        'email'
    ];
}
