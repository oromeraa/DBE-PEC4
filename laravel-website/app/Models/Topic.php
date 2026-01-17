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
