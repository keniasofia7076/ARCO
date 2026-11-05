<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    <!-- FavIcon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo_arco.png') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
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

        <form id="loginForm">

            <!-- Usuario -->
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario o correo</label>
                <input
                    type="text"
                    class="form-control"
                    id="usuario"
                    placeholder="Ingresa tu usuario"
                    required>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input
                        type="password"
                        class="form-control"
                        id="contrasena"
                        placeholder="Ingresa tu contraseña"
                        required>

                    <button class="btn btn-outline-secondary"
                        type="button" id="mostrarPassword">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Botón -->
            <button type="submit" class="btn btn-login w-100">
                <span>Iniciar sesión</span>
                <i class="bi bi-arrow-right-circle-fill"></i>
            </button>

        </form>

        <div class="register-link">
            ¿No tienes una cuenta?
            <a href="registro.php">Regístrate</a>
        </div>

    </div>

    <script>
        // Mostrar u ocultar contraseña
        document.getElementById("mostrarPassword").addEventListener("click", function() {

            const password = document.getElementById("contrasena");
            const icon = this.querySelector("i");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                password.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        });

        // Validación básica
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault();

            const usuario = document.getElementById("usuario").value;
            const contrasena = document.getElementById("contrasena").value;

            alert("Formulario enviado correctamente. Falta conectar el inicio de sesión con la base de datos.");
        });
    </script>

</body>

</html>