<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';
    protected $primaryKey = 'id_reporte';

    protected $fillable = [
        'id_usuario',
        'id_preso',
        'tipo_reporte',
        'fecha_reporte',
        'hora_reporte',
        'descripcion'
    ];

 
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
    

  
    public function preso()
    {
        return $this->belongsTo(Preso::class, 'id_preso', 'id_preso');
    }
}
