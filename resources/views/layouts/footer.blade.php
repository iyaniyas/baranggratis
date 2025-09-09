<footer class="bg-dark text-center text-light py-3 mt-auto">
  <div class="container">

    <!-- Link Navigasi Utama -->
    <nav class="mb-3 d-flex flex-wrap justify-content-center gap-3">
      <a href="{{ url('/') }}" class="text-white d-inline-block px-3 py-2">
        <i class="bi bi-house"></i> Halaman Utama
      </a>
      <a href="{{ route('barang.create') }}" class="text-white fw-bold d-inline-block px-3 py-2">
        + Kirim Barang
      </a>
      <a href="https://www.baranggratis.com/permintaan/tambah" class="text-white fw-bold d-inline-block px-3 py-2">
        + Kirim Permintaan
      </a>
      <a href="{{ url('/barang') }}" class="text-white d-inline-block px-3 py-2">
        Semua Barang
      </a>
      <a href="https://www.baranggratis.com/permintaan" class="text-white d-inline-block px-3 py-2">
        Permintaan Barang
      </a>
    </nav>

    <!-- Link Halaman Statis -->
    <nav class="mb-3 d-flex flex-wrap justify-content-center gap-3">
      <a href="{{ url('/tentang-kami') }}" class="text-white d-inline-block px-3 py-2">Tentang Kami</a>
      <a href="{{ url('/pedoman') }}" class="text-white d-inline-block px-3 py-2">Pedoman Komunitas</a>
      <a href="{{ url('/keanekaragaman') }}" class="text-white d-inline-block px-3 py-2">Keanekaragaman</a>
      <a href="{{ url('/keamanan') }}" class="text-white d-inline-block px-3 py-2">Keamanan</a>
      <a href="{{ url('/tos') }}" class="text-white d-inline-block px-3 py-2">Syarat & Ketentuan</a>
    </nav>

    <!-- Link Donasi (paling bawah) -->
    <div class="mt-4">
      <a href="{{ url('/dukungan') }}" class="text-white text-decoration-underline d-inline-block px-3 py-2">
        ❤️ Dukung dengan Donasi
      </a>
    </div>

  </div>
</footer>

