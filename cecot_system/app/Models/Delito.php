<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delito extends Model
{
    protected $primaryKey = 'id_delito';

    protected $fillable = ['descripcion'];

    public function presos()
    {
        return $this->belongsToMany(Preso::class, 'preso_delito', 'id_delito', 'id_preso');
    }
}
