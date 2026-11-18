<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Persona;
use App\Models\Edificio;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personas = Persona::with('edificio')
            ->orderBy('matricula')
            ->paginate(10);

        return redirect()
            ->route('home');
    }

    // Listado de estudiantes para el administrador.
    public function adminEstudiantes(Request $request)
    {
        $busqueda = $request->input('buscar');

        $personas = Persona::with('edificio')
            ->where('tipo_personal', 1)
            ->when($busqueda, function ($query) use ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('matricula', 'ILIKE', "%{$busqueda}%")
                        ->orWhere('nombre', 'ILIKE', "%{$busqueda}%")
                        ->orWhere('apellido_paterno', 'ILIKE', "%{$busqueda}%")
                        ->orWhere('apellido_materno', 'ILIKE', "%{$busqueda}%");
                });
            })
            ->orderBy('matricula')
            ->paginate(10)
            ->withQueryString();

        return view('admin.estudiantes.index', compact('personas', 'busqueda'));
    }

    // Dar de baja a un estudiante y sus equipos.
    public function darDeBaja(string $id)
    {
        $persona = Persona::where('tipo_personal', 1)
            ->findOrFail($id);

        DB::transaction(function () use ($persona) {

            // Desactivar todos los equipos del estudiante.
            $persona->equipos()->update([
                'activo' => false,
            ]);

            // Dar de baja al estudiante.
            $persona->update([
                'activo' => false,
            ]);
        });

        return redirect()
            ->route('admin.estudiantes')
            ->with('success', 'El estudiante y sus equipos fueron dados de baja correctamente.');
    }

    // Reactivar a un estudiante y sus equipos.
    public function reactivar(string $id)
    {
        $persona = Persona::where('tipo_personal', 1)
            ->findOrFail($id);

        DB::transaction(function () use ($persona) {

            // Reactivar los equipos del estudiante.
            $persona->equipos()->update([
                'activo' => true,
            ]);

            // Reactivar al estudiante.
            $persona->update([
                'activo' => true,
            ]);
        });

        return redirect()
            ->route('admin.estudiantes')
            ->with('success', 'El estudiante y sus equipos fueron reactivados correctamente.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $edificios = Edificio::all();

        return view('personas.registro', compact('edificios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'matricula' => 'required|integer|min:1|unique:persona,matricula',
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'id_edificio' => 'nullable|exists:edificio,id_edificio',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $datos['tipo_personal'] = 1;

        Persona::create($datos);

        return redirect()->route('login')
            ->with('success', 'Persona registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $persona = Persona::with('edificio')
            ->findOrFail($id);

        return view('personas.show', compact('persona'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $persona = Persona::findOrFail($id);

        $edificios = Edificio::all();

        return view('personas.registro', compact(
            'persona',
            'edificios'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $persona = Persona::findOrFail($id);

        $datos = $request->validate([
            'matricula' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('persona', 'matricula')
                    ->ignore($persona->matricula, 'matricula'),
            ],
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'id_edificio' => 'nullable|exists:edificio,id_edificio',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Si no escribe una nueva contraseña, conserva la actual.
        if (empty($datos['password'])) {
            unset($datos['password']);
        }

        $persona->update($datos);

        // Si quien edita es administrador, regresar al listado.
        if ($request->session()->get('persona.tipo_personal') == 2) {
            return redirect()->route('admin.estudiantes')
                ->with('success', 'Los datos del estudiante se actualizaron correctamente.');
        }

        // Si es estudiante, actualizar sus datos de sesión.
        $request->session()->put('persona', [
            'matricula' => $persona->matricula,
            'nombre' => $persona->nombre,
            'tipo_personal' => $persona->tipo_personal,
        ]);

        return redirect()->route('home')
            ->with('success', 'Tus datos se actualizaron correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $persona = Persona::findOrFail($id);

        $persona->delete();

        return redirect()
            ->route('home');
    }
}
