<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">BarangGratis.com</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Menu lainnya, contoh: -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('barang.index') }}">Daftar Barang</a>
                </li>
            </ul>
            <a href="{{ route('barang.create') }}" class="btn btn-success ms-2">
                + Tambah Barang
            </a>
        </div>
    </div>
</nav>

