<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo_arco.png') }}">

    <title>Visitas | ARCO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark" style="background: linear-gradient(90deg, #101827, #174ea6);">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2"
                href="{{ session('persona.tipo_personal') == 3 ? route('seguridad.index') : route('admin.index') }}">
                <img src="{{ asset('img/logo_arco.png') }}" alt="Logo ARCO" width="45px">
                <span class="fw-bold">ARCO | Administración</span>
            </a>

            <a href="{{ session('persona.tipo_personal') == 3 ? route('seguridad.index') : route('admin.index') }}"
                class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
        </div>
    </nav>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Gestión de visitas</h2>
                <p class="text-muted mb-0">Consulta y administra las visitas registradas.</p>
            </div>

            <a href="{{ session('persona.tipo_personal') == 3 ? route('seguridad.visitas.create') : route('admin.visitas.create') }}"
                class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>Registrar visita
            </a>
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

                <form action="{{ session('persona.tipo_personal') == 3 ? route('seguridad.visitas.activas') : route('admin.visitas.index') }}"
                    method="GET" class="mb-4">

                    <div class="row g-2">

                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input
                                    type="text"
                                    name="buscar"
                                    class="form-control"
                                    placeholder="Buscar por nombre, apellidos o correo..."
                                    value="{{ $busqueda ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-calendar-event"></i>
                                </span>

                                <input
                                    type="date"
                                    name="fecha"
                                    class="form-control"
                                    value="{{ $fecha ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                Buscar
                            </button>

                            <a href="{{ session('persona.tipo_personal') == 3 ? route('seguridad.visitas.activas') : route('admin.visitas.index') }}"
                                class="btn btn-outline-secondary">
                                {{ session('persona.tipo_personal') == 3 ? 'Todas' : 'Hoy' }}
                            </a>
                        </div>

                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Visitante</th>
                                <th>Correo</th>
                                <th>Edificio</th>
                                <th>Motivo</th>
                                <th>Fecha de entrada</th>
                                <th>Fecha de salida</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($visitas as $visita)
                            <tr>
                                <td>
                                    {{ $visita->nombre }}
                                    {{ $visita->apellido_paterno }}
                                    {{ $visita->apellido_materno }}
                                </td>

                                <td>{{ $visita->correo ?: 'No especificado' }}</td>

                                <td>{{ $visita->edificio->nombre ?? 'Sin edificio' }}</td>

                                <td>{{ $visita->motivo }}</td>

                                <td>
                                    {{ $visita->fecha_hora_entrada
                                        ? $visita->fecha_hora_entrada->format('d/m/Y H:i')
                                        : '—' }}
                                </td>

                                <td>
                                    {{ $visita->fecha_hora_salida
                                        ? $visita->fecha_hora_salida->format('d/m/Y H:i')
                                        : 'Pendiente' }}
                                </td>

                                <td>
                                    @if($visita->fecha_hora_salida)
                                    <span class="badge bg-success">Finalizada</span>
                                    @else
                                    <span class="badge bg-warning text-dark">En curso</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if(!$visita->fecha_hora_salida)
                                    <form action="{{ session('persona.tipo_personal') == 3
                                        ? route('seguridad.visitas.salida', $visita->id_visita)
                                        : route('admin.visitas.salida', $visita->id_visita) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Registrar la salida de este visitante?')">
                                        @csrf

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-box-arrow-right me-1"></i>
                                            Registrar salida
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-muted">Sin acciones</span>
                                    @endif
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1"></i>
                                    <p class="mt-2 mb-0">No hay visitas registradas.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $visitas->links() }}
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>