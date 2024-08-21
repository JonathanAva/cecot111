<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Mostrar el dashboard de administrador
    public function adminDashboard()
    {
        if (auth()->user()->rol !== 'admin') {
            return redirect()->route('dashboard');
        }
        
        return view('admin.dashboard');
    }

    // Mostrar el dashboard de usuario normal
    public function userDashboard()
    {
        if (auth()->user()->rol !== 'usuario') {
            return redirect()->route('dashboard');
        }
        
        return view('user.dashboard');
    }

    // Redirigir al dashboard adecuado según el rol
    public function dashboard()
    {
        if (auth()->user()->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->rol === 'usuario') {
            return redirect()->route('user.dashboard');
        } else {
            // Redirigir a una página de error o mostrar un mensaje si el rol no es válido
            abort(403, 'No tienes acceso a esta sección.');
        }
    }
}
