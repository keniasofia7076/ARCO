<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inicio | ARCO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f3f6fb;
            font-family: Arial, sans-serif;
        }

        .navbar-arco {
            background: linear-gradient(135deg, #071a36, #123f75);
        }

        .navbar-brand img {
            height: 42px;
            width: auto;
        }

        .welcome-card {
            background: linear-gradient(135deg, #071a36, #15549a);
            color: white;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .section-title {
            color: #102d50;
            font-weight: 700;
        }

        .equipment-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.07);
            transition: transform .2s;
        }

        .equipment-card:hover {
            transform: translateY(-4px);
        }

        .equipment-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: #e8f1ff;
            color: #14549a;
            font-size: 27px;
        }

        .btn-arco {
            background: #123f75;
            color: white;
            border: none;
        }

        .btn-arco:hover {
            background: #071a36;
            color: white;
        }

        .detail-label {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 3px;
        }

        .detail-value {
            font-weight: 600;
            color: #24364b;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-arco">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('img/logo_arco.png') }}" alt="Logo ARCO">
            <span class="fw-bold">ARCO</span>
        </a>

                <div class="ms-auto d-flex align-items-center gap-3">

            <div class="dropdown">

                <button
                    class="btn btn-outline-light dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <i class="bi bi-person-circle me-1"></i>
                    {{ session('persona.nombre') }}

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('personas.edit', session('persona.matricula')) }}">

                            <i class="bi bi-pencil-square me-2"></i>
                            Editar mis datos

                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button type="submit" class="dropdown-item text-danger">

                                <i class="bi bi-box-arrow-right me-2"></i>
                                Cerrar sesión

                            </button>
                        </form>
                    </li>

                </ul>

            </div>

        </div>

    </div>
</nav>

<div class="container py-5">

    {{-- Mensajes del sistema --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Bienvenida --}}

    <div class="welcome-card mb-5">
        <h2 class="fw-bold">
            ¡Bienvenido a ARCO!
        </h2>

        <p class="mb-0 fs-5">
            Hola, {{ session('persona.nombre') }}.
            Administra tus equipos y registra sus entradas y salidas.
        </p>
    </div>

    {{-- Encabezado de equipos --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h3 class="section-title mb-1">Mis equipos</h3>

            <p class="text-muted mb-0">
                Consulta y administra tus equipos registrados.
            </p>
        </div>

        <a href="{{ route('equipos.create') }}" class="btn btn-arco">
            <i class="bi bi-plus-circle me-1"></i>
            Registrar equipo
        </a>

    </div>

    {{-- Lista de equipos --}}

    <div class="row g-4">

        @forelse($equipos as $equipo)

            @php
                $ultimoMovimiento = $equipo->ultimoMovimiento;
                $entradaPendiente = $equipo->entradaPendiente;

                $ultimaEntrada = $ultimoMovimiento && $ultimoMovimiento->fecha_hora_entrada
                    ? $ultimoMovimiento->fecha_hora_entrada->timezone('America/Mexico_City')
                    : null;

                $ultimaSalida = $ultimoMovimiento && $ultimoMovimiento->fecha_hora_salida
                    ? $ultimoMovimiento->fecha_hora_salida->timezone('America/Mexico_City')
                    : null;
            @endphp

            <div class="col-md-6 col-lg-4">

                <div class="card equipment-card h-100">

                    <div class="card-body p-4">

                        {{-- Encabezado del equipo --}}

                        <div class="d-flex align-items-center gap-3 mb-3">

                            <div class="equipment-icon">
                                <i class="bi bi-laptop"></i>
                            </div>

                            <div>
                                <h5 class="fw-bold mb-1">
                                    {{ $equipo->marca->nombre ?? 'Sin marca' }}
                                </h5>

                                <span class="text-muted small">
                                    {{ $equipo->tipo_equipo }}
                                </span>
                            </div>

                        </div>

                        <hr>

                        {{-- Modelo --}}

                        <div class="mb-3">
                            <p class="detail-label">Modelo</p>

                            <p class="detail-value">
                                {{ $equipo->modelo ?: 'No especificado' }}
                            </p>
                        </div>

                        {{-- Número de serie --}}

                        <div class="mb-3">
                            <p class="detail-label">Número de serie</p>

                            <p class="detail-value">
                                {{ $equipo->numero_serie }}
                            </p>
                        </div>

                        {{-- Última entrada --}}

                        <div class="mb-3">
                            <p class="detail-label">Última entrada</p>

                            <p class="detail-value">
                                {{ $ultimaEntrada ? $ultimaEntrada->format('d/m/Y H:i') : 'Sin registros' }}
                            </p>
                        </div>

                        {{-- Última salida --}}

                        <div class="mb-3">
                            <p class="detail-label">Última salida</p>

                            <p class="detail-value">
                                {{ $ultimaSalida ? $ultimaSalida->format('d/m/Y H:i') : 'Sin registros' }}
                            </p>
                        </div>

                        {{-- Estado del equipo --}}

                        <div class="mb-3">

                            @if($entradaPendiente)

                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock me-1"></i>
                                    Dentro de la institución
                                </span>

                            @else

                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Sin entrada pendiente
                                </span>

                            @endif

                        </div>

                        <hr>

                        {{-- Registrar entrada o salida --}}

                        @if($entradaPendiente)

                            <form action="{{ route('movimientos.salida', $equipo->id_equipo) }}"
                                  method="POST"
                                  class="mb-2">

                                @csrf

                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="bi bi-box-arrow-right me-1"></i>
                                    Registrar salida
                                </button>

                            </form>

                        @else

                            <form action="{{ route('movimientos.entrada', $equipo->id_equipo) }}"
                                  method="POST"
                                  class="mb-2">

                                @csrf

                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>
                                    Registrar entrada
                                </button>

                            </form>

                        @endif

                        {{-- Botones de acciones --}}

                        <div class="d-flex gap-2">

                            <button type="button"
                                    class="btn btn-outline-primary flex-fill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEquipo{{ $equipo->id_equipo }}">

                                <i class="bi bi-eye"></i>
                                Detalles

                            </button>

                            <a href="{{ route('equipos.edit', $equipo->id_equipo) }}"
                               class="btn btn-outline-warning">

                                <i class="bi bi-pencil-square"></i>

                            </a>

                            <form action="{{ route('equipos.destroy', $equipo->id_equipo) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este equipo?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Modal de detalles --}}

            <div class="modal fade"
                 id="modalEquipo{{ $equipo->id_equipo }}"
                 tabindex="-1"
                 aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content border-0 rounded-4">

                        <div class="modal-header text-white"
                             style="background: linear-gradient(135deg, #071a36, #15549a);">

                            <h5 class="modal-title">
                                <i class="bi bi-laptop me-2"></i>
                                Detalles del equipo
                            </h5>

                            <button type="button"
                                    class="btn-close btn-close-white"
                                    data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body p-4">

                            <div class="mb-3">
                                <p class="detail-label">Propietario</p>

                                <p class="detail-value">
                                    {{ $equipo->persona->nombre ?? session('persona.nombre') }}
                                    {{ $equipo->persona->apellido_paterno ?? '' }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <p class="detail-label">Marca</p>

                                <p class="detail-value">
                                    {{ $equipo->marca->nombre ?? 'Sin marca' }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <p class="detail-label">Tipo de equipo</p>

                                <p class="detail-value">
                                    {{ $equipo->tipo_equipo }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <p class="detail-label">Modelo</p>

                                <p class="detail-value">
                                    {{ $equipo->modelo ?: 'No especificado' }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <p class="detail-label">Número de serie</p>

                                <p class="detail-value">
                                    {{ $equipo->numero_serie }}
                                </p>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <p class="detail-label">Última entrada</p>

                                <p class="detail-value">
                                    {{ $ultimaEntrada ? $ultimaEntrada->format('d/m/Y H:i') : 'Sin registros' }}
                                </p>
                            </div>

                            <div>
                                <p class="detail-label">Última salida</p>

                                <p class="detail-value">
                                    {{ $ultimaSalida ? $ultimaSalida->format('d/m/Y H:i') : 'Sin registros' }}
                                </p>
                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                Cerrar
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm rounded-4 text-center p-5">

                    <i class="bi bi-laptop display-3 text-secondary mb-3"></i>

                    <h5 class="fw-bold">
                        Aún no tienes equipos registrados
                    </h5>

                    <p class="text-muted">
                        Registra tu primer equipo para comenzar a utilizar ARCO.
                    </p>

                    <div>
                        <a href="{{ route('equipos.create') }}" class="btn btn-arco">
                            <i class="bi bi-plus-circle me-1"></i>
                            Registrar mi primer equipo
                        </a>
                    </div>

                </div>

            </div>

        @endforelse

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>