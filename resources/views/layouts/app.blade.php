<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BarangGratis.com')</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #181a1b; color: #fff; }
        .navbar, .card { background: #222; }
        .form-control, .form-select { background: #242526; color: #fff; border-color: #444; }
        .form-control:focus, .form-select:focus { background: #2c2c2c; color: #fff; border-color: #007bff; }
        .btn-primary, .btn-success { border-radius: 0.5rem; }
    </style>
</head>
<body>
    @include('layouts.navigation')

    <main>
        @yield('content')
    </main>

    <footer class="text-center py-4 text-secondary small" style="opacity:.7">
        &copy; 2025 BarangGratis.com
    </footer>
    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

