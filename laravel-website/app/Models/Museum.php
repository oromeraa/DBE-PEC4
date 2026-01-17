<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Museum extends Model
{
    protected $fillable = [
        'nombre',
        'ciudad',
        'fechas_horarios',
        'visitas_guiadas',
        'precio',
        'imagen_portada',
    ];
    
    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }
}
