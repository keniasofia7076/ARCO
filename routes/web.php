<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitaController;

Route::get('/', fn () => redirect()->route('visitas.index'));
Route::resource('visitas', VisitaController::class)
    ->parameters(['visitas' => 'visita']);
Route::patch('visitas/{visita}/salida', [VisitaController::class, 'registrarSalida'])
    ->name('visitas.salida');
    
Route::get('/', function () {
    return view('login');
});
