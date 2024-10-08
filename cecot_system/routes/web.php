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
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ExpedienteController;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/planillas', [PlanillaController::class, 'index'])->name('planillas.index');
    Route::get('/presos/{id}/delitos', [PresoController::class, 'getDelitos'])->name('presos.getDelitos');
    Route::get('/presos/{id}/edit', [PresoController::class, 'edit'])->name('presos.edit');
    Route::get('/celdas/{id}/presos', [CeldaController::class, 'getPresosByCelda']);
    Route::delete('/celdas/{celda}/presos/{preso}', [CeldaController::class, 'retirarPreso'])->name('celdas.retirarPreso');

    
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
        
        Route::get('/planillas/create', [PlanillaController::class, 'create'])->name('planillas.create');
        Route::post('/planillas', [PlanillaController::class, 'store'])->name('planillas.store');
        Route::get('/planillas/{id}/edit', [PlanillaController::class, 'edit'])->name('planillas.edit');
        Route::put('/planillas/{id}', [PlanillaController::class, 'update'])->name('planillas.update');
        Route::delete('/planillas/{id}', [PlanillaController::class, 'destroy'])->name('planillas.destroy');

        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/create', [ReporteController::class, 'create'])->name('reportes.create');
        Route::post('/reportes', [ReporteController::class, 'store'])->name('reportes.store');
        Route::get('/reportes/{id}/edit', [ReporteController::class, 'edit'])->name('reportes.edit');
        Route::put('/reportes/{id}', [ReporteController::class, 'update'])->name('reportes.update');
        Route::delete('/reportes/{id}', [ReporteController::class, 'destroy'])->name('reportes.destroy');
        Route::get('/reportes/print/{id}', [ReporteController::class, 'print'])->name('reportes.print');

        Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');
        Route::get('/expedientes/create', [ExpedienteController::class, 'create'])->name('expedientes.create');
        Route::post('/expedientes', [ExpedienteController::class, 'store'])->name('expedientes.store');
        Route::get('/expedientes/{id_expediente}', [ExpedienteController::class, 'show'])->name('expedientes.show');
        Route::get('/expedientes/{id_expediente}/edit', [ExpedienteController::class, 'edit'])->name('expedientes.edit');
        Route::put('/expedientes/{id_expediente}', [ExpedienteController::class, 'update'])->name('expedientes.update');
        Route::delete('/expedientes/{id_expediente}', [ExpedienteController::class, 'destroy'])->name('expedientes.destroy');
        Route::get('/expedientes/print/{id_expediente}', [ExpedienteController::class, 'print'])->name('expedientes.print');

        
        
        Route::get('/visitas', [VisitaController::class, 'index'])->name('visitas.index');
        Route::get('/visitas/create', [VisitaController::class, 'create'])->name('visitas.create');
        Route::post('/visitas', [VisitaController::class, 'store'])->name('visitas.store');
        Route::get('/visitas/{id}/edit', [VisitaController::class, 'edit'])->name('visitas.edit');
        Route::put('/visitas/{id}', [VisitaController::class, 'update'])->name('visitas.update');
        Route::delete('/visitas/{id}', [VisitaController::class, 'destroy'])->name('visitas.destroy');

        
        Route::resource('empleados', EmpleadoController::class)->except(['show']);
        Route::resource('celdas', CeldaController::class)->except(['show']);
        Route::resource('presos', PresoController::class)->except(['show']);
        Route::resource('delitos', DelitoController::class)->except(['show']);
        Route::resource('preso_delito', PresoDelitoController::class)->only(['store', 'destroy']);
    });

    
    Route::get('/user', [UserController::class, 'userDashboard'])->name('user.dashboard');

   
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});
