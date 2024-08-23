<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    use HasFactory;

   
    protected $primaryKey = 'id_planilla'; 



    protected $fillable = [
        'id_usuario',  
        'turnos_Asignados', 
        'fechas_turno',
        'actividades_asignadas',
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
