<?php

namespace App\Http\Controllers;

use App\Models\Equipo;

class HomeController extends Controller
{
    public function index()
    {
        $matricula = session('persona.matricula');

        $equipos = Equipo::with('marca')
            ->where('propietario', $matricula)
            ->orderByDesc('id_equipo')
            ->get();

        foreach ($equipos as $equipo) {

            // Obtener el último movimiento registrado
            $equipo->ultimoMovimiento = $equipo->movimientos()
                ->orderByDesc('fecha_hora_entrada')
                ->first();

            // Comprobar si existe una entrada sin salida
            $equipo->entradaPendiente = $equipo->movimientos()
                ->whereNull('fecha_hora_salida')
                ->exists();
        }

        return view('home.index', compact('equipos'));
    }
}