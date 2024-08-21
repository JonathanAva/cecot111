<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresoDelito extends Model
{
    // Indica la tabla asociada si no sigue la convención plural
    protected $table = 'preso_delito';

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = ['id_preso', 'id_delito'];

    // Si tienes claves primarias personalizadas o compuestas, puedes definirlas aquí
    // protected $primaryKey = ['id_preso', 'id_delito'];
    // public $incrementing = false; // Si las claves no son auto-incrementables
}
