<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_visita';

    protected $fillable = [
        'nombreDelVisitante',
        'relacionConElPreso',
        'fechaDeVisita',
        'horaDeVisita',
        'id_preso',
    ];

    public function preso()
    {
        return $this->belongsTo(Preso::class, 'id_preso');
    }
}
