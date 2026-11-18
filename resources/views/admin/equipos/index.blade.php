
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo_arco.png') }}">

    <title>Equipos | ARCO</title>

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

        <div class="mb-4">
            <h2 class="fw-bold text-dark">Gestión de equipos</h2>
            <p class="text-muted mb-0">Consulta los equipos registrados por los estudiantes.</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <form action="{{ route('admin.equipos') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            name="buscar"
                            class="form-control"
                            placeholder="Buscar por matrícula o número de serie..."
                            value="{{ $busqueda ?? '' }}">

                        <button type="submit" class="btn btn-primary">
                            Buscar
                        </button>

                        @if(!empty($busqueda))
                        <a href="{{ route('admin.equipos') }}" class="btn btn-outline-secondary">
                            Limpiar
                        </a>
                        @endif
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Propietario</th>
                                <th>Matrícula</th>
                                <th>Marca</th>
                                <th>Tipo</th>
                                <th>Modelo</th>
                                <th>Número de serie</th>
                                <th>Movimientos</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($equipos as $equipo)
                            <tr>
                                <td>
                                    {{ $equipo->persona->nombre ?? 'Sin propietario' }}
                                    {{ $equipo->persona->apellido_paterno ?? '' }}
                                </td>

                                <td>{{ $equipo->propietario }}</td>

                                <td>{{ $equipo->marca->nombre ?? 'Sin marca' }}</td>

                                <td>{{ $equipo->tipo_equipo }}</td>

                                <td>{{ $equipo->modelo ?: 'No especificado' }}</td>

                                <td>{{ $equipo->numero_serie }}</td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $equipo->movimientos_count }}
                                    </span>
                                </td>

                                <td>
                                    @if($equipo->activo)
                                    <span class="badge bg-success">Activo</span>
                                    @else
                                    <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalMovimientos{{ $equipo->id_equipo }}">
                                        <i class="bi bi-clock-history me-1"></i>
                                        Ver movimientos
                                    </button>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No hay equipos registrados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modales de movimientos -->
                @foreach($equipos as $equipo)
                <div class="modal fade" id="modalMovimientos{{ $equipo->id_equipo }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header text-white"
                                style="background: linear-gradient(90deg, #101827, #174ea6);">
                                <div>
                                    <h5 class="modal-title fw-bold">
                                        <i class="bi bi-clock-history me-2"></i>
                                        Historial de movimientos
                                    </h5>
                                    <small>
                                        Equipo: {{ $equipo->numero_serie }}
                                    </small>
                                </div>

                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <p class="mb-3">
                                    <strong>Propietario:</strong>
                                    {{ $equipo->persona->nombre ?? 'Sin propietario' }}
                                    {{ $equipo->persona->apellido_paterno ?? '' }}
                                    {{ $equipo->persona->apellido_materno ?? '' }}
                                    <br>

                                    <strong>Matrícula:</strong> {{ $equipo->propietario }}
                                </p>

                                @if($equipo->movimientos->isNotEmpty())

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha de entrada</th>
                                                <th>Fecha de salida</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($equipo->movimientos as $movimiento)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    {{ $movimiento->fecha_hora_entrada
                                                        ? $movimiento->fecha_hora_entrada->format('d/m/Y H:i')
                                                        : '—' }}
                                                </td>

                                                <td>
                                                    {{ $movimiento->fecha_hora_salida
                                                        ? $movimiento->fecha_hora_salida->format('d/m/Y H:i')
                                                        : 'Pendiente' }}
                                                </td>

                                                <td>
                                                    @if($movimiento->fecha_hora_salida)
                                                    <span class="badge bg-success">Completado</span>
                                                    @else
                                                    <span class="badge bg-warning text-dark">En curso</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @else
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1"></i>
                                    <p class="mt-2 mb-0">
                                        Este equipo todavía no tiene movimientos registrados.
                                    </p>
                                </div>
                                @endif

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

                <div class="mt-3">
                    {{ $equipos->links() }}
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
