<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos'; // Nombre de la tabla

    protected $fillable = [
        'nombreProducto',
        'descripcion',
        'precio',
        'stock',
        'idUsuario',
        'idAlerta'
    ];

    // Relaciones con otras tablas
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function alerta()
    {
        return $this->belongsTo(Alerta::class, 'idAlerta');
    }

    public function proveedor()
    {
        return $this->belongsTo(Alerta::class, 'idproveedor');
    }
}
