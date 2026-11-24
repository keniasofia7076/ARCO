<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeguridadMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si hay una sesión iniciada.
        if (!$request->session()->has('persona')) {
            return redirect()->route('login');
        }

        // Verificar si la persona pertenece al personal de seguridad.
        if ($request->session()->get('persona.tipo_personal') != 3) {
            return redirect()->route('home')
                ->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
