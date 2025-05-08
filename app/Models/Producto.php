<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreProducto',
        'descripcion',
        'precio',
        'stock',
        'idUsuario',  // Asegúrate que esté aquí
        'idAlerta'
    ];
    
    // Haz las relaciones opcionales
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario')->withDefault();
    }
    
    public function alerta()
    {
        return $this->belongsTo(Alerta::class, 'idAlerta')->withDefault();
    }
    
    public function verificarStock()
    {
        if ($this->stock < 10) {
            $this->generarAlerta();
        } else {
            // Eliminar alerta si el stock se normaliza
            if ($this->alerta) {
                $this->alerta()->delete();
                $this->idAlerta = null;
                $this->save();
            }
        }
    }
    
    protected function generarAlerta()
    {
        // Solo crear alerta si no existe una
        if (!$this->alerta) {
            $alerta = Alerta::create([
                'tipoMensaje' => 'Stock Bajo',
                'fecha' => now(),
                'estadoProducto' => 'Stock crítico: ' . $this->stock . ' unidades'
            ]);
    
            $this->idAlerta = $alerta->id;
            $this->save();
        }
    }
}