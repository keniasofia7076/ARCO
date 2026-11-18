
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo_arco.png') }}">

    <title>Registrar edificio | ARCO</title>

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

            <a href="{{ route('admin.edificios.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
        </div>
    </nav>

    <div class="container py-5">

        <div class="mb-4">
            <h2 class="fw-bold text-dark">Registrar edificio</h2>
            <p class="text-muted mb-0">Ingresa la información del nuevo edificio.</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <form action="{{ route('admin.edificios.store') }}" method="POST">
                    @csrf

                    <!-- Nombre del edificio -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">
                            Nombre del edificio
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="nombre"
                            name="nombre"
                            placeholder="Ej. Edificio A"
                            value="{{ old('nombre') }}"
                            maxlength="100"
                            required>

                        @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- División -->
                    <div class="mb-4">
                        <label for="division" class="form-label fw-semibold">
                            División
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="division"
                            name="division"
                            placeholder="Ej. Sistemas"
                            value="{{ old('division') }}"
                            maxlength="100"
                            required>

                        @error('division')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Registrar edificio
                        </button>

                        <a href="{{ route('admin.edificios.index') }}" class="btn btn-outline-secondary">
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
