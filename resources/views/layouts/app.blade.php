<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Cari & bagikan barang bekas, gratis, second, furniture, elektronik, mainan, baju, perlengkapan rumah & lainnya. Semua gratis')">
    <title>@yield('title', 'BarangGratis.com')</title>

    <!-- Bootswatch Darkly Theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/darkly/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Overrides (jika diperlukan) -->
    <style>
        /* Contoh: override warna background atau komponen lebih spesifik di sini */
    </style>
</head>
<body>
    @include('layouts.navigation')

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="bg-dark text-center text-light py-3">
        <small>© {{ date('Y') }} BarangGratis.com</small>
    </footer>

    <!-- Bootstrap JavaScript Bundle (Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

