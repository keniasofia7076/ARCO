<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo_arco.png') }}">

    <title>Estudiantes | ARCO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark" style="background: linear-gradient(90deg, #101827, #174ea6);">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('img/logo_arco.png') }}" alt="Logo ARCO" width="45px">
                <span class="fw-bold">ARCO | Administración</span>
            </a>

            <a href="{{ route('admin.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
        </div>
    </nav>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Gestión de personal</h2>
                <p class="text-muted mb-0">Consulta y administra al personal de ARCO.</p>
            </div>

            <a href="{{ route('personas.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>Agregar personal
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <form action="{{ route('admin.estudiantes') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            name="buscar"
                            class="form-control"
                            placeholder="Buscar por matrícula o nombre del personal..."
                            value="{{ $busqueda ?? '' }}">

                        <select name="tipo_personal" class="form-select" style="max-width: 190px;">
                            <option value="">Todo el personal</option>
                            <option value="1" {{ request('tipo_personal') == '1' ? 'selected' : '' }}>
                                Estudiantes
                            </option>
                            <option value="2" {{ request('tipo_personal') == '2' ? 'selected' : '' }}>
                                Administradores
                            </option>
                            <option value="3" {{ request('tipo_personal') == '3' ? 'selected' : '' }}>
                                Seguridad
                            </option>
                        </select>

                        <button type="submit" class="btn btn-primary">
                            Buscar
                        </button>

                        @if(!empty($busqueda) || request()->filled('tipo_personal'))
                        <a href="{{ route('admin.estudiantes') }}" class="btn btn-outline-secondary">
                            Limpiar
                        </a>
                        @endif
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Matrícula</th>
                                <th>Nombre</th>
                                <th>Edificio</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($personas as $persona)
                            <tr>
                                <td>{{ $persona->matricula }}</td>

                                <td>
                                    {{ $persona->nombre }}
                                    {{ $persona->apellido_paterno }}
                                    {{ $persona->apellido_materno }}
                                </td>

                                <td>{{ $persona->edificio->nombre ?? 'Sin edificio' }}</td>

                                <td>
                                    @if($persona->activo)
                                    <span class="badge bg-success">Activo</span>
                                    @else
                                    <span class="badge bg-danger">Dado de baja</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('personas.edit', $persona->matricula) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    @if($persona->activo)
                                    <form action="{{ route('admin.estudiantes.baja', $persona->matricula) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Dar de baja a este estudiante y sus equipos?');">
                                        @csrf

                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="Dar de baja">
                                            <i class="bi bi-person-dash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('admin.estudiantes.reactivar', $persona->matricula) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Reactivar a este estudiante y sus equipos?');">
                                        @csrf

                                        <button type="submit" class="btn btn-sm btn-outline-success"
                                            title="Reactivar estudiante">
                                            <i class="bi bi-person-plus"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No hay estudiantes registrados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $personas->links() }}
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>