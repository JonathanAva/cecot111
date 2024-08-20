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
        return view('dashboard');
    }
}



