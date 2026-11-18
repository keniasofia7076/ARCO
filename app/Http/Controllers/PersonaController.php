<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $matriculaSesion = session('persona.matricula');
        $tipoPersonal = session('persona.tipo_personal');

        // Verificar que exista una sesión.
        if (!$matriculaSesion) {
            abort(403);
        }

        // Los estudiantes solamente pueden editar sus propios datos.
        if ($tipoPersonal == 1 && $id != $matriculaSesion) {
            abort(403);
        }

        // Solamente estudiantes y administradores pueden editar.
        if (!in_array($tipoPersonal, [1, 2])) {
            abort(403);
        }

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
        $matriculaSesion = $request->session()->get('persona.matricula');
        $tipoPersonal = $request->session()->get('persona.tipo_personal');

        // Verificar que exista una sesión.
        if (!$matriculaSesion) {
            abort(403);
        }

        // Los estudiantes solamente pueden modificar sus propios datos.
        if ($tipoPersonal == 1 && $id != $matriculaSesion) {
            abort(403);
        }

        // Solamente estudiantes y administradores pueden actualizar.
        if (!in_array($tipoPersonal, [1, 2])) {
            abort(403);
        }

        $persona = Persona::findOrFail($id);

        // Identificar si está editando sus propios datos.
        $esPropioPerfil = $persona->matricula == $matriculaSesion;

        $reglas = [
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
        ];

        // Solicitar contraseña actual cuando edita su propio perfil.
        if ($esPropioPerfil) {
            $reglas['current_password'] = 'required|string';
        }

        $datos = $request->validate($reglas);

        // Comprobar que la contraseña actual sea correcta.
        if ($esPropioPerfil && !Hash::check(
            $datos['current_password'],
            $persona->password
        )) {
            return back()
                ->withErrors([
                    'current_password' => 'La contraseña actual es incorrecta.',
                ])
                ->withInput();
        }

        // Eliminar el campo de contraseña actual para no guardarlo.
        unset($datos['current_password']);

        // Si no escribe una nueva contraseña, conserva la actual.
        if (empty($datos['password'])) {
            unset($datos['password']);
        }

        $persona->update($datos);

        // Si está editando sus propios datos, actualizar la sesión.
        if ($esPropioPerfil) {
            $request->session()->put('persona', [
                'matricula' => $persona->matricula,
                'nombre' => $persona->nombre,
                'tipo_personal' => $persona->tipo_personal,
            ]);

            return redirect()->route('home')
                ->with('success', 'Tus datos se actualizaron correctamente.');
        }

        // Si el administrador edita a otro estudiante, regresar al listado.
        return redirect()->route('admin.estudiantes')
            ->with('success', 'Los datos del estudiante se actualizaron correctamente.');
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
