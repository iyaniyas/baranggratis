<nav class="navbar navbar-dark bg-dark" role="navigation">
  <div class="container">
    <h1 class="navbar-brand mb-0">
      <a href="{{ route('beranda') }}" class="text-decoration-none d-flex align-items-baseline">
        <span class="text-warning">BARANG</span>&nbsp;<span class="text-light">GRATIS</span>
      </a>
    </h1>

    <div class="dropdown">
      <button class="btn btn-warning text-dark dropdown-toggle" type="button" id="dropdownBerbagi" data-bs-toggle="dropdown" aria-expanded="false">
        + Berbagi
      </button>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownBerbagi">
        <li>
          <a class="dropdown-item" href="{{ route('barang.create') }}">
            Kirim Barang
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="https://www.baranggratis.com/permintaan/tambah">
            Kirim Permintaan
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

