<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Celda extends Model
{
    protected $primaryKey = 'id_celda';

    protected $fillable = [
        'numeroCelda',
        'estado',
        'capacidad',
        'numeroDePresos',
    ];

    public function presos()
    {
        return $this->hasMany(Preso::class, 'id_celda');
    }
}

