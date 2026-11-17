
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración | ARCO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f3f6fb;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #101827;
            color: white;
            padding: 25px 15px;
        }

        .sidebar .logo {
            font-size: 23px;
            font-weight: bold;
            padding: 10px;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 13px 15px;
            border-radius: 9px;
            margin-bottom: 8px;
            transition: .2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #174ea6;
            color: white;
        }

        .sidebar i {
            margin-right: 10px;
        }

        .topbar {
            background: white;
            padding: 18px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,.05);
        }

        .welcome-card {
            background: linear-gradient(120deg, #101827, #174ea6);
            color: white;
            border-radius: 15px;
            padding: 30px;
        }

        .dashboard-card {
            background: white;
            border: none;
            border-radius: 13px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
            transition: .2s;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
        }

        .icon-box {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
            background: #e8f0fe;
            color: #174ea6;
            margin-bottom: 18px;
        }

        .dashboard-card a {
            text-decoration: none;
        }

        .section-title {
            font-weight: bold;
            color: #172033;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- Menú lateral -->
        <aside class="col-md-3 col-lg-2 sidebar">

            <div class="logo">
                <i class="bi bi-shield-lock me-2"></i>ARCO
                <div class="small fw-normal text-secondary mt-1">
                    Administración
                </div>
            </div>

            <a href="{{ route('admin.index') }}" class="active">
                <i class="bi bi-grid"></i>Inicio
            </a>

            <a href="{{ route('admin.estudiantes') }}">
                <i class="bi bi-people"></i>Estudiantes
            </a>

            <a href="#" class="text-secondary" aria-disabled="true"
               onclick="return false;">
                <i class="bi bi-laptop"></i>Equipos
                <small class="d-block ms-4">Próximamente</small>
            </a>

            <a href="#" class="text-secondary" aria-disabled="true"
               onclick="return false;">
                <i class="bi bi-person-vcard"></i>Visitas
                <small class="d-block ms-4">Próximamente</small>
            </a>

            <hr class="border-secondary my-4">

            <a href="{{ route('home') }}">
                <i class="bi bi-house"></i>Vista de usuario
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="btn text-start w-100 text-danger mt-2"
                    style="padding: 13px 15px;">
                    <i class="bi bi-box-arrow-left me-2"></i>
                    Cerrar sesión
                </button>
            </form>

        </aside>

        <!-- Contenido principal -->
        <main class="col-md-9 col-lg-10 p-0">

            <!-- Barra superior -->
            <nav class="topbar d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold">Panel de administración</h5>
                    <small class="text-muted">Sistema ARCO</small>
                </div>

                <div class="text-end">
                    <span class="fw-semibold">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ session('persona.nombre') }}
                    </span>
                    <div>
                        <small class="text-primary">Administrador</small>
                    </div>
                </div>
            </nav>

            <div class="container-fluid p-4">

                <!-- Bienvenida -->
                <div class="welcome-card mb-4">
                    <h3 class="fw-bold">
                        ¡Bienvenido, {{ session('persona.nombre') }}!
                    </h3>

                    <p class="mb-0">
                        Desde aquí puedes administrar los estudiantes,
                        equipos y visitas de la institución.
                    </p>
                </div>

                <!-- Módulos -->
                <h5 class="section-title mb-3">Administración del sistema</h5>

                <div class="row g-4">

                    <!-- Estudiantes -->
                    <div class="col-md-6 col-xl-4">
                        <div class="dashboard-card">
                            <div class="icon-box">
                                <i class="bi bi-people"></i>
                            </div>

                            <h5 class="fw-bold">Estudiantes</h5>

                            <p class="text-muted">
                                Registra, consulta, edita y da de baja
                                estudiantes del sistema.
                            </p>

                            <a href="{{ route('admin.estudiantes') }}"
                               class="btn btn-primary w-100 mt-2">
                                Administrar estudiantes
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Equipos -->
                    <div class="col-md-6 col-xl-4">
                        <div class="dashboard-card">
                            <div class="icon-box">
                                <i class="bi bi-laptop"></i>
                            </div>

                            <h5 class="fw-bold">Equipos</h5>

                            <p class="text-muted">
                                Consulta los equipos registrados y
                                administra su estado.
                            </p>

                            <button class="btn btn-outline-secondary w-100 mt-2"
                                disabled>
                                Próximamente
                            </button>
                        </div>
                    </div>

                    <!-- Visitas -->
                    <div class="col-md-6 col-xl-4">
                        <div class="dashboard-card">
                            <div class="icon-box">
                                <i class="bi bi-person-vcard"></i>
                            </div>

                            <h5 class="fw-bold">Visitas</h5>

                            <p class="text-muted">
                                Consulta el historial y gestiona
                                las entradas y salidas de visitantes.
                            </p>

                            <button class="btn btn-outline-secondary w-100 mt-2"
                                disabled>
                                Próximamente
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Información -->
                <div class="mt-5">
                    <h5 class="section-title mb-3">Información</h5>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-shield-check text-primary fs-2 me-3"></i>

                                <div>
                                    <h6 class="fw-bold mb-1">
                                        Acceso administrativo
                                    </h6>

                                    <p class="text-muted mb-0">
                                        Has iniciado sesión con permisos
                                        de administrador en ARCO.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
