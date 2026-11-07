<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipoController extends Controller
{
    // Mostrar los equipos del usuario
    public function index()
    {
        $matricula = session('persona.matricula');

        $equipos = Equipo::with(['persona', 'marca'])
            ->where('propietario', $matricula)
            ->orderByDesc('id_equipo')
            ->paginate(10);

        return view('equipos.index', compact('equipos'));
    }

    // Mostrar formulario de registro
    public function create()
    {
        $marcas = Marca::orderBy('nombre')->get();

        return view('equipos.create', compact('marcas'));
    }

    // Guardar equipo
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_marca' => [
                'required',
                'exists:marca,id_marca'
            ],

            'numero_serie' => [
                'required',
                'string',
                'max:100',
                'unique:equipo,numero_serie'
            ],

            'tipo_equipo' => [
                'required',
                'string',
                'max:80'
            ],

            'modelo' => [
                'nullable',
                'string',
                'max:100'
            ]
        ]);

        $matricula = session('persona.matricula');

        if (!$matricula) {
            return redirect()->route('login');
        }

        $datos['propietario'] = $matricula;

        Equipo::create($datos);

        return redirect()
            ->route('home')
            ->with('success', 'Equipo registrado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(string $id)
    {
        $matricula = session('persona.matricula');

        $equipo = Equipo::where('propietario', $matricula)
            ->findOrFail($id);

        $marcas = Marca::orderBy('nombre')->get();

        return view('equipos.edit', compact('equipo', 'marcas'));
    }

    // Actualizar equipo
    public function update(Request $request, string $id)
    {
        $matricula = session('persona.matricula');

        $equipo = Equipo::where('propietario', $matricula)
            ->findOrFail($id);

        $datos = $request->validate([
            'id_marca' => [
                'required',
                'exists:marca,id_marca'
            ],

            'numero_serie' => [
                'required',
                'string',
                'max:100',
                Rule::unique('equipo', 'numero_serie')
                    ->ignore($equipo->id_equipo, 'id_equipo')
            ],

            'tipo_equipo' => [
                'required',
                'string',
                'max:80'
            ],

            'modelo' => [
                'nullable',
                'string',
                'max:100'
            ]
        ]);

        $equipo->update($datos);

        return redirect()
            ->route('home')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    // Eliminar equipo
    public function destroy(string $id)
    {
        $matricula = session('persona.matricula');

        $equipo = Equipo::where('propietario', $matricula)
            ->findOrFail($id);

        if ($equipo->movimientos()->exists()) {
            return redirect()
                ->route('home')
                ->with('error', 'No se puede eliminar porque tiene movimientos registrados.');
        }

        $equipo->delete();

        return redirect()
            ->route('home')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}