 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Equipos ARCO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        h1 {
            color: #26354a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #26354a;
            color: white;
        }

        a, button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .nuevo { background: #198754; color: white; }
        .editar { background: #0d6efd; color: white; }
        .eliminar { background: #dc3545; color: white; }

        .mensaje {
            background: #d1e7dd;
            padding: 12px;
        }
    </style>
</head>
<body>

    <h1>Gestión de equipos</h1>

    @if(session('success'))
        <p class="mensaje">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <a href="{{ route('equipos.create') }}" class="nuevo">
        Registrar equipo
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Alumno</th>
                <th>Matrícula</th>
                <th>Marca</th>
                <th>Tipo</th>
                <th>Modelo</th>
                <th>Número de serie</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->id_equipo }}</td>
                    <td>
                        {{ $equipo->alumno->persona->nombre }}
                        {{ $equipo->alumno->persona->apellido_paterno }}
                    </td>
                    <td>{{ $equipo->alumno->matricula }}</td>
                    <td>{{ $equipo->marca->nombre }}</td>
                    <td>{{ $equipo->tipo_equipo }}</td>
                    <td>{{ $equipo->modelo ?? 'No especificado' }}</td>
                    <td>{{ $equipo->numero_serie }}</td>
                    <td>
                        <a href="{{ route('equipos.edit', $equipo->id_equipo) }}"
                           class="editar">Editar</a>

                        <form action="{{ route('equipos.destroy', $equipo->id_equipo) }}"
                              method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="eliminar"
                                onclick="return confirm('¿Eliminar este equipo?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay equipos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $equipos->links() }}

</body>
</html>
