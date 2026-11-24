
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo_arco.png') }}">

    <title>Registrar visita | ARCO</title>

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

            <a href="{{ session('persona.tipo_personal') == 3 ? route('seguridad.index') : route('admin.index') }}"
                class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
        </div>
    </nav>

    <div class="container py-5">

        <div class="mb-4">
            <h2 class="fw-bold text-dark">Registrar visita</h2>
            <p class="text-muted mb-0">Ingresa los datos del visitante y el motivo de su visita.</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <form action="{{ session('persona.tipo_personal') == 3 ? route('seguridad.visitas.store') : route('admin.visitas.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label fw-semibold">Nombre</label>
                            <input type="text" name="nombre" id="nombre"
                                class="form-control" value="{{ old('nombre') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="apellido_paterno" class="form-label fw-semibold">Apellido paterno</label>
                            <input type="text" name="apellido_paterno" id="apellido_paterno"
                                class="form-control" value="{{ old('apellido_paterno') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="apellido_materno" class="form-label fw-semibold">Apellido materno</label>
                            <input type="text" name="apellido_materno" id="apellido_materno"
                                class="form-control" value="{{ old('apellido_materno') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
                            <input type="email" name="correo" id="correo"
                                class="form-control" value="{{ old('correo') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="id_edificio" class="form-label fw-semibold">Edificio que visita</label>

                            <select name="id_edificio" id="id_edificio" class="form-select" required>
                                <option value="">Selecciona un edificio</option>

                                @foreach ($edificios as $edificio)
                                <option value="{{ $edificio->id_edificio }}"
                                    {{ old('id_edificio') == $edificio->id_edificio ? 'selected' : '' }}>
                                    {{ $edificio->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="motivo" class="form-label fw-semibold">Motivo de la visita</label>
                            <textarea name="motivo" id="motivo" class="form-control"
                                rows="3" required>{{ old('motivo') }}</textarea>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-plus me-1"></i>Registrar visita
                        </button>

                        <a href="{{ session('persona.tipo_personal') == 3 ? route('seguridad.index') : route('admin.visitas.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
