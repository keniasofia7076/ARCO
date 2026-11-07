<?php

use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\MovimientoEquipoController;

Route::get('/', function () {
    return view('login');
})->name('login');

// Login
Route::post('/login', [LoginController::class, 'login'])->name('login.validar');

// Cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Página principal
Route::get('/home', [HomeController::class, 'index'])->name('home');

//Persona
Route::get('/personas/crear', [PersonaController::class, 'create'])
    ->name('personas.create');

Route::post('/personas', [PersonaController::class, 'store'])
    ->name('personas.store');

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