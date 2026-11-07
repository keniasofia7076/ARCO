<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo_arco.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="login-container">

        <div class="login-logo">
            <img src="{{ asset('img/logo_arco.png') }}" alt="Logo ARCO">
        </div>

        <h2 class="login-title">¡Bienvenido!</h2>
        <p class="login-subtitle">Inicia sesión en tu cuenta</p>

        <form id="loginForm" action="{{ route('login.validar') }}" method="POST">
            @csrf

            <!-- Matrícula -->
            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula</label>
                <input
                    type="text"
                    class="form-control"
                    id="matricula"
                    name="matricula"
                    value="{{ old('matricula') }}"
                    placeholder="Ingresa tu matrícula"
                    required>

                @error('matricula')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>

                <div class="input-group">
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Ingresa tu contraseña"
                        required>

                    <button class="btn btn-outline-secondary"
                        type="button" id="mostrarPassword">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Botón -->
            <button type="submit" class="btn btn-login w-100">
                <span>Iniciar sesión</span>
                <i class="bi bi-arrow-right-circle-fill"></i>
            </button>

        </form>

        <div class="register-link">
            ¿No tienes una cuenta?
            <a href="{{ route('personas.create') }}">Regístrate</a>
        </div>

    </div>

    <script>
        // Mostrar u ocultar contraseña
        document.getElementById("mostrarPassword").addEventListener("click", function() {

            const password = document.getElementById("password");
            const icon = this.querySelector("i");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                password.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        });
    </script>

</body>
</html>