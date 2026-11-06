<?php
namespace App\Http\Controllers;

use App\Models\Edificio;
use App\Models\Persona;
use App\Models\Visita;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    private function reglas(): array
    {
        return [
            'id_persona'         => 'required|exists:persona,id_persona',
            'id_edificio'        => 'required|exists:edificio,id_edificio',
            'fecha_hora_entrada' => 'required|date',
            'fecha_hora_salida'  => 'nullable|date|after_or_equal:fecha_hora_entrada',
            'motivo'             => 'required|string|max:255',
        ];
    }

    public function index()
    {
        $visitas = Visita::with(['persona', 'edificio'])
            ->orderByDesc('fecha_hora_entrada')
            ->paginate(15);

        return view('visitas.index', compact('visitas'));
    }

    public function create()
    {
        return view('visitas.create', [
            'personas'  => Persona::orderBy('nombre')->get(),
            'edificios' => Edificio::orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Visita::create($request->validate($this->reglas()));

        return redirect()->route('visitas.index')->with('ok', 'Visita registrada.');
    }

    public function show(Visita $visita)
    {
        $visita->load(['persona', 'edificio']);
        return view('visitas.show', compact('visita'));
    }

    public function edit(Visita $visita)
    {
        return view('visitas.edit', [
            'visita'    => $visita,
            'personas'  => Persona::orderBy('nombre')->get(),
            'edificios' => Edificio::orderBy('nombre')->get(),
        ]);
    }

    public function update(Request $request, Visita $visita)
    {
        $visita->update($request->validate($this->reglas()));

        return redirect()->route('visitas.index')->with('ok', 'Visita actualizada.');
    }

    public function destroy(Visita $visita)
    {
        $visita->delete();

        return redirect()->route('visitas.index')->with('ok', 'Visita eliminada.');
    }
    
    public function registrarSalida(Visita $visita)
    {
        $visita->update(['fecha_hora_salida' => now()]);

        return back()->with('ok', 'Salida registrada.');
    }
}