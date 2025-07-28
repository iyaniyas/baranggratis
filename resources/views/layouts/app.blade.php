<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    <title>@yield('meta_title', 'BarangGratis.com')</title>
    <meta name="description" content="@yield('meta_description', 'Cari & bagikan barang bekas, gratis, second, furniture, elektronik, mainan, baju, perlengkapan rumah & lainnya. Semua gratis')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:title" content="@yield('meta_title', 'BarangGratis.com')" />
    <meta property="og:description" content="@yield('meta_description', 'Cari & bagikan barang bekas, gratis, second, furniture, elektronik, mainan, baju, perlengkapan rumah & lainnya. Semua gratis')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="@yield('meta_image', asset('img/no-image.jpg'))" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('meta_title', 'BarangGratis.com')" />
    <meta name="twitter:description" content="@yield('meta_description', 'Cari & bagikan barang bekas, gratis, second, furniture, elektronik, mainan, baju, perlengkapan rumah & lainnya. Semua gratis')" />
    <meta name="twitter:image" content="@yield('meta_image', asset('img/no-image.jpg'))" />

    <!-- Local Darkly Theme CSS -->
    <link href="{{ asset('css/darkly.min.css') }}" rel="stylesheet">

    <!-- Custom Overrides (jika diperlukan) -->
    <style>
        /* Contoh: override gaya komponen spesifik di sini */
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

