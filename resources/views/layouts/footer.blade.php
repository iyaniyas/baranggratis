<footer class="bg-dark text-center text-light py-3">
  <div class="container">
    <!-- Link Navigasi Utama -->
    <nav class="mb-2">
      <a href="{{ url('/') }}" class="text-light mx-2"><i class="bi bi-house"></i> Halaman Utama</a>
      <a href="{{ route('barang.create') }}" class="text-warning mx-2 fw-bold">+ Berbagi</a>
      <a href="{{ url('/barang') }}" class="text-light mx-2">Semua Barang</a>
      <a href="{{ url('/dukungan') }}" class="text-light mx-2">Donasi</a>
    </nav>
    <!-- Link Halaman Statis -->
    <nav class="mt-2">
      <a href="{{ url('/tentang-kami') }}" class="text-light mx-2">Tentang Kami</a>
      <a href="{{ url('/pedoman') }}" class="text-light mx-2">Pedoman Komunitas</a>
      <a href="{{ url('/keanekaragaman') }}" class="text-light mx-2">Keanekaragaman</a>
      <a href="{{ url('/keamanan') }}" class="text-light mx-2">Keamanan</a>
      <a href="{{ url('/tos') }}" class="text-light mx-2">Syarat & Ketentuan</a>
    </nav>
  </div>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GESVND1RPV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GESVND1RPV');
</script>

</footer>

