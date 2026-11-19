<?php

use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\MovimientoEquipoController;
use App\Http\Controllers\EdificioController;
use App\Http\Controllers\VisitaController;

Route::get('/', function () {
    return view('login');
})->name('login');

// Login
Route::post('/login', [LoginController::class, 'login'])->name('login.validar');

// Cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Página principal
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Persona
Route::get('/personas/{id}/editar', [PersonaController::class, 'edit'])
    ->name('personas.edit');

Route::put('/personas/{id}', [PersonaController::class, 'update'])
    ->name('personas.update');

// Equipos
Route::resource('equipos', EquipoController::class);

Route::post('/equipos/{id}/entrada', [MovimientoEquipoController::class, 'entrada'])
    ->name('movimientos.entrada');

Route::post('/equipos/{id}/salida', [MovimientoEquipoController::class, 'salida'])
    ->name('movimientos.salida');

// Panel de administrador
Route::middleware(['admin'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');

    // Registro de estudiantes (solo administradores)
    Route::get('/personas/crear', [PersonaController::class, 'create'])
        ->name('personas.create');

    Route::post('/personas', [PersonaController::class, 'store'])
        ->name('personas.store');

    Route::get('/admin/estudiantes', [PersonaController::class, 'adminEstudiantes'])
        ->name('admin.estudiantes');

    Route::post('/admin/estudiantes/{id}/baja', [PersonaController::class, 'darDeBaja'])
        ->name('admin.estudiantes.baja');

    Route::post('/admin/estudiantes/{id}/reactivar', [PersonaController::class, 'reactivar'])
        ->name('admin.estudiantes.reactivar');

    Route::get('/admin/equipos', [EquipoController::class, 'adminEquipos'])
        ->name('admin.equipos');

    // Gestión de edificios
    Route::resource('/admin/edificios', EdificioController::class)
        ->names('admin.edificios');

    // Gestión de visitas
    Route::get('/admin/visitas', [VisitaController::class, 'index'])
        ->name('admin.visitas.index');

    Route::get('/admin/visitas/crear', [VisitaController::class, 'create'])
        ->name('admin.visitas.create');

    Route::post('/admin/visitas', [VisitaController::class, 'store'])
        ->name('admin.visitas.store');

    Route::post('/admin/visitas/{id}/salida', [VisitaController::class, 'salida'])
        ->name('admin.visitas.salida');
});
