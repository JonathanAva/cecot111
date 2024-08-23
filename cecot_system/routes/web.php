<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CeldaController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PresoController;
use App\Http\Controllers\DelitoController;
use App\Http\Controllers\PresoDelitoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\VisitaController; 

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
    Route::get('/planillas', [PlanillaController::class, 'index'])->name('planillas.index');
    Route::get('/presos/{id}/delitos', [PresoController::class, 'getDelitos'])->name('presos.getDelitos');
    Route::get('/presos/{id}/edit', [PresoController::class, 'edit'])->name('presos.edit');
    Route::get('/celdas/{id}/presos', [CeldaController::class, 'getPresosByCelda']);
    Route::delete('/celdas/{celda}/presos/{preso}', [CeldaController::class, 'retirarPreso'])->name('celdas.retirarPreso');

    // Rutas accesibles solo para administradores
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
        
        Route::get('/planillas/create', [PlanillaController::class, 'create'])->name('planillas.create');
        Route::post('/planillas', [PlanillaController::class, 'store'])->name('planillas.store');
        Route::get('/planillas/{id}/edit', [PlanillaController::class, 'edit'])->name('planillas.edit');
        Route::put('/planillas/{id}', [PlanillaController::class, 'update'])->name('planillas.update');
        Route::delete('/planillas/{id}', [PlanillaController::class, 'destroy'])->name('planillas.destroy');
        
        // Rutas de gestión de visitas (solo para administradores)
        Route::get('/visitas', [VisitaController::class, 'index'])->name('visitas.index');
        Route::get('/visitas/create', [VisitaController::class, 'create'])->name('visitas.create');
        Route::post('/visitas', [VisitaController::class, 'store'])->name('visitas.store');
        Route::get('/visitas/{id}/edit', [VisitaController::class, 'edit'])->name('visitas.edit');
        Route::put('/visitas/{id}', [VisitaController::class, 'update'])->name('visitas.update');
        Route::delete('/visitas/{id}', [VisitaController::class, 'destroy'])->name('visitas.destroy');

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
