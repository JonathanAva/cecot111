<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function adminDashboard()
    {
        if (auth()->user()->rol !== 'admin') {
            return redirect()->route('dashboard');
        }
        
        return view('admin.dashboard');
    }

    
    public function userDashboard()
    {
        if (auth()->user()->rol !== 'usuario') {
            return redirect()->route('dashboard');
        }
        
        return view('user.dashboard');
    }


    public function dashboard()
    {
        if (auth()->user()->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->rol === 'usuario') {
            return redirect()->route('user.dashboard');
        } else {
            
            abort(403, 'No tienes acceso a esta sección.');
        }
    }
}
