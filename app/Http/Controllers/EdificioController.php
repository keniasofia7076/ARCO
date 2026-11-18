<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EdificioController extends Controller
{
    // Mostrar los edificios registrados.
    public function index()
    {
        $edificios = Edificio::orderBy('nombre')
            ->paginate(10);

        return view('admin.edificios.index', compact('edificios'));
    }

    // Mostrar formulario para registrar un edificio.
    public function create()
    {
        return view('admin.edificios.create');
    }

    // Guardar un nuevo edificio.
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100|unique:edificio,nombre',
            'division' => 'required|string|max:100',
        ]);

        Edificio::create($datos);

        return redirect()
            ->route('admin.edificios.index')
            ->with('success', 'Edificio registrado correctamente.');
    }

    // Mostrar formulario para editar un edificio.
    public function edit(string $id)
    {
        $edificio = Edificio::findOrFail($id);

        return view('admin.edificios.edit', compact('edificio'));
    }

    // Actualizar un edificio.
    public function update(Request $request, string $id)
    {
        $edificio = Edificio::findOrFail($id);

        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('edificio', 'nombre')
                    ->ignore($edificio->id_edificio, 'id_edificio'),
            ],
            'division' => 'required|string|max:100',
        ]);

        $edificio->update($datos);

        return redirect()
            ->route('admin.edificios.index')
            ->with('success', 'Edificio actualizado correctamente.');
    }

    // Eliminar un edificio.
    public function destroy(string $id)
    {
        $edificio = Edificio::findOrFail($id);

        // Verificar que no tenga personas ni visitas relacionadas.
        if ($edificio->personas()->exists() || $edificio->visitas()->exists()) {
            return redirect()
                ->route('admin.edificios.index')
                ->with('error', 'No se puede eliminar el edificio porque tiene personas o visitas relacionadas.');
        }

        $edificio->delete();

        return redirect()
            ->route('admin.edificios.index')
            ->with('success', 'Edificio eliminado correctamente.');
    }
}
