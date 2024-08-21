<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CeldaController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PresoController;


// Redirige la raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});


// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Rutas accesibles solo para administradores
    Route::get('/admin', [UserController::class, 'adminDashboard'])->name('admin.dashboard');

    // Ruta para gestionar celdas (solo administrador)
    Route::resource('celdas', CeldaController::class)->middleware('auth');
    Route::resource('presos', PresoController::class)->middleware('auth');

    // Rutas accesibles solo para usuarios normales
    Route::get('/user', [UserController::class, 'userDashboard'])->name('user.dashboard');

    // Ruta genérica para todos los usuarios autenticados
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});
