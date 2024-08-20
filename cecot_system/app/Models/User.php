<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; 

    protected $primaryKey = 'id_usuario'; 

    protected $fillable = [
        'nombre_usuario',
        'password', 
        'rol',
        'info_contacto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Método accesor para obtener el rol del usuario
    public function getRoleAttribute()
    {
        return $this->attributes['rol'];
    }
}
