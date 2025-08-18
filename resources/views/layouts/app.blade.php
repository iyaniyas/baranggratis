<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Critical CSS (inline) -->
    <style>
      /* container & H1 above-the-fold */
      .container { max-width: 960px; margin: 0 auto; padding: 1rem; }
      h1.mb-4 { margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: 200; }
      /* tambahkan rule lain yang dibutuhkan untuk layout hero */
    </style>

    <!-- Preload full Darkly CSS -->
    <link
      rel="preload"
      href="{{ asset('css/darkly.min.css') }}"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
      <link rel="stylesheet" href="{{ asset('css/darkly.min.css') }}">
    </noscript>

    <!-- SEO Meta Tags -->
    <title>@yield('meta_title', 'BarangGratis.com')</title>
    <meta name="description" content="@yield('meta_description', 'Cari & bagikan barang bekas, gratis, second, furniture, elektronik, mainan, baju, perlengkapan rumah & lainnya. Semua gratis')">

    <!-- Open Graph / Facebook -->
<meta property="og:type" content="@yield('og_type','website')">
<meta property="og:title" content="@yield('meta_title','BarangGratis.com')">
<meta property="og:description" content="@yield('meta_description','Cari & bagikan barang bekas, gratis, second, furniture, elektronik, mainan, baju, perlengkapan rumah & lainnya. Semua gratis')">
<meta property="og:url" content="@yield('meta_url', strtolower(url()->full()))">
<meta property="og:image" content="@yield('meta_image', asset('img/no-image.jpg'))">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('meta_title','BarangGratis.com')">
<meta name="twitter:description" content="@yield('meta_description','Cari & bagikan barang bekas, gratis, second, furniture, elektronik, mainan, baju, perlengkapan rumah & lainnya. Semua gratis')">
<meta name="twitter:image" content="@yield('meta_image', asset('img/no-image.jpg'))">

    <!-- Local Darkly Theme CSS -->
    <link href="{{ asset('css/darkly.min.css') }}" rel="stylesheet">

    <!-- Custom Overrides (jika diperlukan) -->
    <style>
        /* Contoh override gaya komponen spesifik di sini */
    </style>
    <link rel="icon" href="{{ asset('favicon.png') }}">
      <style>
    .email { cursor: text; user-select: none; }
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

    <!-- 4. Local Bootstrap JS (defer agar tidak blok render) -->
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>

  @include('layouts.footer')
  @stack('scripts')
</body>
</html>

