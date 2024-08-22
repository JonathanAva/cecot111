<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CeldaController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PresoController;
use App\Http\Controllers\DelitoController;
use App\Http\Controllers\PresoDelitoController;
use App\Http\Controllers\EmpleadoController;

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

    
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/presos/{id}/delitos', [PresoController::class, 'getDelitos'])->name('presos.getDelitos');
    Route::get('/presos/{id}/edit', [PresoController::class, 'edit'])->name('presos.edit');
    Route::get('/celdas/{id}/presos', [CeldaController::class, 'getPresosByCelda']);
    Route::delete('/celdas/{celda}/presos/{preso}', [CeldaController::class, 'retirarPreso'])->name('celdas.retirarPreso');




    // Rutas accesibles solo para administradores
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
        
        
        // Protege rutas solo accesibles por administradores en el controlador
        Route::resource('empleados', EmpleadoController::class)->except(['show']);
        Route::resource('celdas', CeldaController::class)->except(['show']);
        Route::resource('presos', PresoController::class)->except(['show']);
        Route::resource('delitos', DelitoController::class)->except(['show']);
        Route::resource('preso_delito', PresoDelitoController::class)->only(['store', 'destroy']);
    });

    // Rutas accesibles solo para usuarios normales
    Route::get('/user', [UserController::class, 'userDashboard'])->name('user.dashboard');


    // Ruta genérica para todos los usuarios autenticados
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});
