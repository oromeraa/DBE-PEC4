<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    protected $fillable = ['tematica'];

    public function museums()
    {
        return $this->belongsToMany(Museum::class);
    }
}

$guggenheim = App\Models\Museum::create(['nombre' => 'Museo Guggenheim Bilbao', 'ciudad' => 'Bilbao', 'fechas_horarios' => 'Martes a Domingo: 10:00 - 20:00', 'visitas_guiadas' => 'si', 'precio' => 16.00, 'imagen_portada' => 'museums/guggenheim.jpg']);

$cosmocaixa = App\Models\Museum::create(['nombre' => 'CosmoCaixa Barcelona', 'ciudad' => 'Barcelona', 'fechas_horarios' => 'Todos los días: 10:00 - 20:00', 'visitas_guiadas' => 'si', 'precio' => 6.00, 'imagen_portada' => 'museums/cosmocaixa.jpg']);
// Vincular con las dos temáticas
$cosmocaixa->topics()->attach([$t1->id, $t2->id]);