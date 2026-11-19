<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Edificio;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    // Mostrar las visitas registradas.
    public function index(Request $request)
    {
        $busqueda = $request->input('buscar');
        $fecha = $request->input('fecha', now()->toDateString());

        $visitas = Visita::with('edificio')
            ->when($fecha, function ($query) use ($fecha) {
                $query->whereDate('fecha_hora_entrada', $fecha);
            })
            ->when($busqueda, function ($query) use ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombre', 'ILIKE', "%{$busqueda}%")
                        ->orWhere('apellido_paterno', 'ILIKE', "%{$busqueda}%")
                        ->orWhere('apellido_materno', 'ILIKE', "%{$busqueda}%")
                        ->orWhere('correo', 'ILIKE', "%{$busqueda}%");
                });
            })
            ->orderBy('fecha_hora_entrada', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.visitas.index', compact('visitas', 'busqueda', 'fecha'));
    }

    // Mostrar formulario para registrar una visita.
    public function create()
    {
        $edificios = Edificio::orderBy('nombre')->get();

        return view('admin.visitas.create', compact('edificios'));
    }

    // Registrar una nueva visita.
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'correo' => 'nullable|email|max:150',
            'id_edificio' => 'required|exists:edificio,id_edificio',
            'motivo' => 'required|string|max:250',
        ]);

        Visita::create($datos);

        return redirect()
            ->route('admin.visitas.index')
            ->with('success', 'Visita registrada correctamente.');
    }

    // Registrar la salida de un visitante.
    public function salida(string $id)
    {
        $visita = Visita::findOrFail($id);

        if ($visita->fecha_hora_salida === null) {
            $visita->update([
                'fecha_hora_salida' => now(),
            ]);
        }

        return redirect()
            ->route('admin.visitas.index')
            ->with('success', 'Salida registrada correctamente.');
    }
}
