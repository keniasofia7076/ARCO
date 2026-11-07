<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar equipo | ARCO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            padding: 35px 15px;
        }

        .contenedor {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        h1 {
            color: #102d50;
            font-weight: 700;
        }

        .descripcion {
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13,110,253,.12);
        }

        .botones {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .botones button,
        .cancelar {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
        }

        .guardar {
            background: #123f75;
            color: white;
            flex: 1;
        }

        .guardar:hover {
            background: #071a36;
        }

        .cancelar {
            background: #6c757d;
            color: white;
        }

        .cancelar:hover {
            background: #565e64;
            color: white;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>
        <i class="bi bi-pencil-square me-2"></i>
        Editar equipo
    </h1>

    <p class="descripcion">
        Modifica la información del equipo registrado.
    </p>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa los siguientes errores:</strong>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('equipos.update', $equipo->id_equipo) }}"
          method="POST">

        @csrf
        @method('PUT')

        {{-- Marca --}}

        <label for="id_marca">Marca del equipo</label>

        <select name="id_marca" id="id_marca" required>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id_marca }}"
                    {{ old('id_marca', $equipo->id_marca) == $marca->id_marca ? 'selected' : '' }}>
                    {{ $marca->nombre }}
                </option>
            @endforeach
        </select>

        {{-- Tipo de equipo --}}

        <label for="tipo_equipo">Tipo de equipo</label>

        <select name="tipo_equipo" id="tipo_equipo" required>
            @foreach(['Laptop', 'Computadora de escritorio', 'Tablet', 'Otro'] as $tipo)
                <option value="{{ $tipo }}"
                    {{ old('tipo_equipo', $equipo->tipo_equipo) == $tipo ? 'selected' : '' }}>
                    {{ $tipo }}
                </option>
            @endforeach
        </select>

        {{-- Modelo --}}

        <label for="modelo">Modelo</label>

        <input
            type="text"
            id="modelo"
            name="modelo"
            maxlength="100"
            value="{{ old('modelo', $equipo->modelo) }}"
        >

        {{-- Número de serie --}}

        <label for="numero_serie">Número de serie</label>

        <input
            type="text"
            id="numero_serie"
            name="numero_serie"
            maxlength="100"
            value="{{ old('numero_serie', $equipo->numero_serie) }}"
            required
        >

        {{-- Botones --}}

        <div class="botones">

            <button type="submit" class="guardar">
                <i class="bi bi-check-circle me-1"></i>
                Actualizar equipo
            </button>

            <a href="{{ route('home') }}" class="cancelar">
                Cancelar
            </a>

        </div>

    </form>

</div>

</body>
</html>