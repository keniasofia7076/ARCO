<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Visitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    @if (session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif
    @yield('content')
</body>
</html>