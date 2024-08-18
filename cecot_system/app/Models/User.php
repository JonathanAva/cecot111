<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // Nombre de la tabla

    protected $primaryKey = 'id_usuario'; // Clave primaria

    protected $fillable = [
        'nombre_usuario',
        'password',  // Utilizamos 'password' para mantener compatibilidad con Laravel
        'rol',
        'info_contacto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
