<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Alumno;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipoController extends Controller
{
    // Mostrar todos los equipos
    public function index()
    {
        $equipos = Equipo::with([
            'alumno.persona',
            'marca'
        ])
        ->orderByDesc('id_equipo')
        ->paginate(10);

        return view('equipos.index', compact('equipos'));
    }

    // Mostrar formulario de registro
    public function create()
    {
        $alumnos = Alumno::with('persona')->get();

        $marcas = Marca::orderBy('nombre')->get();

        return view('equipos.create', compact(
            'alumnos',
            'marcas'
        ));
    }

    // Guardar equipo
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_alumno' => [
                'required',
                'exists:alumno,id_alumno'
            ],

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

        Equipo::create($datos);

        return redirect()
            ->route('equipos.index')
            ->with('success', 'Equipo registrado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(string $id)
    {
        $equipo = Equipo::findOrFail($id);

        $alumnos = Alumno::with('persona')->get();

        $marcas = Marca::orderBy('nombre')->get();

        return view('equipos.edit', compact(
            'equipo',
            'alumnos',
            'marcas'
        ));
    }

    // Actualizar equipo
    public function update(Request $request, string $id)
    {
        $equipo = Equipo::findOrFail($id);

        $datos = $request->validate([
            'id_alumno' => [
                'required',
                'exists:alumno,id_alumno'
            ],

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
            ->route('equipos.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    // Eliminar equipo
    public function destroy(string $id)
    {
        $equipo = Equipo::findOrFail($id);

        if ($equipo->movimientos()->exists()) {
            return redirect()
                ->route('equipos.index')
                ->with('error', 'No se puede eliminar porque tiene movimientos registrados.');
        }

        $equipo->delete();

        return redirect()
            ->route('equipos.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}