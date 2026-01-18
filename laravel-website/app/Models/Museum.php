<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Museum extends Model
{
    use HasFactory;

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
