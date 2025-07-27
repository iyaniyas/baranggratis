<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('meta_title', 'BarangGratis.com - Platform Barang Bekas & Gratis Seluruh Indonesia')</title>
    <meta name="description" content="@yield('meta_description', 'Cari & bagikan barang bekas, gratis, second, furniture, elektronik, mainan, baju, perlengkapan rumah & lainnya. Semua gratis, tanpa bayar!')">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #191b1f;
            color: #f1f1f1;
        }
        .navbar, .card, .dropdown-menu {
            background-color: #23262b !important;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
        }
        a, a:visited, .text-primary {
            color: #5cb3ff !important;
        }
        .form-label, .form-control, .form-select, input, textarea, select {
            background-color: #23262b !important;
            color: #f1f1f1 !important;
            border-color: #3a3b3c;
        }
        .btn-primary {
            background-color: #5cb3ff;
            border-color: #4ca1e8;
            color: #191b1f;
        }
        .btn-primary:hover {
            background-color: #388fd6;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
            letter-spacing: 1px;
        }
    </style>
    @stack('head')
</head>
<body>
    @include('layouts.navigation')

    <div class="container mb-5">
        @yield('content')
    </div>
    <footer class="text-center text-muted pb-2 pt-3" style="font-size:0.95em;">
        &copy; {{ date('Y') }} baranggratis.com. Free stuff for everyone!
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

