 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar equipo | ARCO</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
        }

        .contenedor {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,.08);
        }

        h1 {
            color: #26354a;
            margin-bottom: 8px;
        }

        .descripcion {
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #0d6efd;
        }

        .botones {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        button, .cancelar {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
        }

        button {
            background: #198754;
            color: white;
        }

        .cancelar {
            background: #6c757d;
            color: white;
        }

        .errores {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Registrar equipo</h1>
    <p class="descripcion">
        Ingresa la información del equipo que se registrará en ARCO.
    </p>

    @if($errors->any())
        <div class="errores">
            <strong>Revisa los siguientes errores:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('equipos.store') }}" method="POST">
        @csrf

        <label>Alumno propietario</label>

        <select name="id_alumno" required>
            <option value="">Selecciona un alumno</option>

            @foreach($alumnos as $alumno)
                <option value="{{ $alumno->id_alumno }}"
                    {{ old('id_alumno') == $alumno->id_alumno ? 'selected' : '' }}>

                    {{ $alumno->matricula }} -
                    {{ $alumno->persona->nombre }}
                    {{ $alumno->persona->apellido_paterno }}

                </option>
            @endforeach
        </select>

        <label>Marca del equipo</label>

        <select name="id_marca" required>
            <option value="">Selecciona una marca</option>

            @foreach($marcas as $marca)
                <option value="{{ $marca->id_marca }}"
                    {{ old('id_marca') == $marca->id_marca ? 'selected' : '' }}>
                    {{ $marca->nombre }}
                </option>
            @endforeach
        </select>

        <label>Tipo de equipo</label>

        <select name="tipo_equipo" required>
            <option value="">Selecciona el tipo de equipo</option>
            <option value="Laptop" {{ old('tipo_equipo') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
            <option value="Computadora de escritorio" {{ old('tipo_equipo') == 'Computadora de escritorio' ? 'selected' : '' }}>Computadora de escritorio</option>
            <option value="Tablet" {{ old('tipo_equipo') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
            <option value="Otro" {{ old('tipo_equipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
        </select>

        <label>Modelo</label>

        <input
            type="text"
            name="modelo"
            placeholder="Ejemplo: HP Pavilion 15"
            maxlength="100"
            value="{{ old('modelo') }}"
        >

        <label>Número de serie</label>

        <input
            type="text"
            name="numero_serie"
            placeholder="Ingresa el número de serie"
            maxlength="100"
            value="{{ old('numero_serie') }}"
            required
        >

        <div class="botones">
            <button type="submit">Guardar equipo</button>

            <a href="{{ route('equipos.index') }}" class="cancelar">
                Cancelar
            </a>
        </div>

    </form>

</div>

</body>
</html>
