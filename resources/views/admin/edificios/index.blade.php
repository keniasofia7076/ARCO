
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo_arco.png') }}">

    <title>Edificios | ARCO</title>

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

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-dark">Gestión de edificios</h2>
                <p class="text-muted mb-0">Administra los edificios y divisiones registrados en ARCO.</p>
            </div>

            <a href="{{ route('admin.edificios.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Registrar edificio
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

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Edificio</th>
                                <th>División</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($edificios as $edificio)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $edificio->nombre }}
                                </td>

                                <td>
                                    {{ $edificio->division }}
                                </td>

                                <td class="text-center">

                                    <a href="{{ route('admin.edificios.edit', $edificio->id_edificio) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square me-1"></i>Editar
                                    </a>

                                    <form
                                        action="{{ route('admin.edificios.destroy', $edificio->id_edificio) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este edificio?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash me-1"></i>Eliminar
                                        </button>
                                    </form>

                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="bi bi-buildings fs-1 d-block mb-2"></i>
                                    No hay edificios registrados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <div class="mt-3">
                    {{ $edificios->links() }}
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>