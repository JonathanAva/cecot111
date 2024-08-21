<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preso extends Model
{
    protected $primaryKey = 'id_preso';
    
    protected $fillable = [
        'nombre',
        'apellido',
        'fechaNacimiento',
        'numeroIdentificacion',
        'fechaIngreso',
        'fechaLiberacion',
        'estado',
        'condena',
        'id_celda',
    ];

    // Relación con Celda
    public function celda()
    {
        return $this->belongsTo(Celda::class, 'id_celda');
    }
}
