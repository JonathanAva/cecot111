<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    use HasFactory;

    protected $table = 'expedientes';
    protected $primaryKey = 'id_expediente';

    protected $fillable = [
        'descripcionDelCaso',
        'estadoDelCaso',
        'id_preso',
    ];

    public function preso()
    {
        return $this->belongsTo(Preso::class, 'id_preso');
    }
}
