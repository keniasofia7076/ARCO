<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ isset($persona) ? 'Actualizar persona' : 'Registro de persona' }} | ARCO</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo_arco.png') }}">
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
</head>

<body>

    <div class="contenedor">
        <div class="tarjeta">

            <div class="encabezado">
                <div class="icono">
                    <i class="fa-solid fa-user-plus"></i>
                </div>

                <h1>
                    {{ isset($persona) ? 'Actualizar persona' : 'Crear cuenta' }}
                </h1>

                <p>
                    {{ isset($persona)
                        ? 'Modifica tu información personal.'
                        : 'Ingresa tus datos para registrarte en ARCO.' }}
                </p>
            </div>

            <form
                action="{{ isset($persona) ? route('personas.update', $persona->matricula) : route('personas.store') }}"
                method="POST">

                @csrf

                @if(isset($persona))
                @method('PUT')
                @endif

                <!-- Matricula -->
                <div class="campo">
                    <label for="matricula">Matrícula</label>
                    <input
                        type="number"
                        id="matricula"
                        placeholder="Ingresa tu matrícula"
                        name="matricula"
                        value="{{ old('matricula', $persona->matricula ?? '') }}"
                        required>
                    @error('matricula')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nombre -->
                <div class="campo">
                    <label for="nombre">Nombre(s)</label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        placeholder="Ingresa tu nombre"
                        value="{{ old('nombre', $persona->nombre ?? '') }}"
                        maxlength="100"
                        required>

                    @error('nombre')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Apellido paterno -->
                <div class="campo">
                    <label for="apellido_paterno">Apellido paterno</label>

                    <input
                        type="text"
                        id="apellido_paterno"
                        name="apellido_paterno"
                        placeholder="Ingresa tu apellido paterno"
                        value="{{ old('apellido_paterno', $persona->apellido_paterno ?? '') }}"
                        maxlength="100"
                        required>

                    @error('apellido_paterno')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Apellido materno -->
                <div class="campo">
                    <label for="apellido_materno">Apellido materno</label>

                    <input
                        type="text"
                        id="apellido_materno"
                        name="apellido_materno"
                        placeholder="Ingresa tu apellido materno"
                        value="{{ old('apellido_materno', $persona->apellido_materno ?? '') }}"
                        maxlength="100">

                    @error('apellido_materno')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="{{ isset($persona) ? 'Deja vacío para conservar la contraseña actual' : 'Ingresa tu contraseña' }}"
                        {{ isset($persona) ? '' : 'required' }}>
                    @error('password')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmar contraseña -->
                <div class="campo">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirma tu contraseña"
                        {{ isset($persona) ? '' : 'required' }}>
                </div>

                <!-- Edificio -->
                <div class="campo">
                    <label for="id_edificio">Edificio / División</label>

                    <select id="id_edificio" name="id_edificio">

                        <option value="">No aplica</option>

                        @foreach($edificios as $edificio)
                        <option
                            value="{{ $edificio->id_edificio }}"
                            {{ old('id_edificio', $persona->id_edificio ?? '') == $edificio->id_edificio ? 'selected' : '' }}>
                            {{ $edificio->nombre }} - {{ $edificio->division }}
                        </option>
                        @endforeach

                    </select>

                    @error('id_edificio')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Botón -->
                <button type="submit" class="btn-registrar">
                    {{ isset($persona) ? 'Actualizar información' : 'Registrarme' }}
                </button>

                <a href="{{ url('/') }}" class="btn-regresar">
                    Volver al inicio de sesión
                </a>

            </form>

            <div class="pie">
                <p>ARCO · Sistema de Registro y Control de Acceso</p>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>

</body>

</html>