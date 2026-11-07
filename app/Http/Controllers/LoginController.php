<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $datos = $request->validate([
            'matricula' => 'required|integer',
            'password' => 'required|string',
        ]);

        $persona = Persona::find($datos['matricula']);

        if (!$persona || !$persona->password ||
            !Hash::check($datos['password'], $persona->password)) {

            return back()->withErrors([
                'matricula' => 'La matrícula o contraseña son incorrectas.',
            ])->onlyInput('matricula');
        }

        $request->session()->regenerate();

        $request->session()->put('persona', [
            'matricula' => $persona->matricula,
            'nombre' => $persona->nombre,
            'tipo_personal' => $persona->tipo_personal,
        ]);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('persona');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
