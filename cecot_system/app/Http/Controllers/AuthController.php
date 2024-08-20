<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Maneja la autenticación
    public function login(Request $request)
    {
        // Validación de las credenciales
        $credentials = $request->validate([
            'nombre_usuario' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Intentar la autenticación usando 'nombre_usuario' y 'password'
        if (Auth::attempt(['nombre_usuario' => $credentials['nombre_usuario'], 'password' => $credentials['password']])) {
            // Si la autenticación es exitosa, redirigir según el rol del usuario
            if (Auth::user()->rol == 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        // Si la autenticación falla, redirigir de vuelta al formulario de login con un mensaje de error
        return back()->withErrors(['message' => 'Credenciales incorrectas']);
    }

    // Maneja el cierre de sesión
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
