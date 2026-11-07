<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\MovimientoEquipo;
use Illuminate\Support\Facades\DB;

class MovimientoEquipoController extends Controller
{
    public function entrada($id)
    {
        $matricula = session('persona.matricula');

        $equipo = Equipo::where('propietario', $matricula)
            ->findOrFail($id);

        $movimientoAbierto = MovimientoEquipo::where(
            'id_equipo',
            $equipo->id_equipo
        )
        ->whereNull('fecha_hora_salida')
        ->exists();

        if ($movimientoAbierto) {
            return redirect()->route('home')
                ->with('error', 'Este equipo ya tiene una entrada registrada y todavía no tiene salida.');
        }

        MovimientoEquipo::create([
            'id_equipo' => $equipo->id_equipo,
            'fecha_hora_entrada' => now(),
            'fecha_hora_salida' => null,
        ]);

        return redirect()->route('home')
            ->with('success', 'Entrada del equipo registrada correctamente.');
    }

    public function salida($id)
{
    $matricula = session('persona.matricula');

    $equipo = Equipo::where('propietario', $matricula)
        ->findOrFail($id);

    $movimiento = $equipo->movimientos()
        ->whereNull('fecha_hora_salida')
        ->orderByDesc('fecha_hora_entrada')
        ->first();

    if (!$movimiento) {
        return redirect()->route('home')
            ->with('error', 'No hay una entrada pendiente para registrar la salida.');
    }

    $movimiento->fecha_hora_salida = now();
    $movimiento->save();

    return redirect()->route('home')
        ->with('success', 'Salida del equipo registrada correctamente.');
}
}
