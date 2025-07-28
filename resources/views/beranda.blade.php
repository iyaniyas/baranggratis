@extends('layouts.app')

@section('meta_title', 'Berbagi Menerima Barang Gratis – Mudah & Tanpa Ribet')
@section('meta_description', 'Platform terbesar untuk cari & berbagi barang bekas, gratis, second, furniture, elektronik, mainan, baju & perlengkapan rumah lainnya. Semua gratis di seluruh Indonesia!')

@section('content')
  <h1 class="mb-4">Cari Barang Gratis</h1>

  <!-- FORM FILTER -->
  <form method="GET" action="{{ route('beranda') }}" class="row g-3 mb-4">
    <div class="col-md-3">
      <input type="text" name="q" class="form-control" placeholder="Cari nama barang..." value="{{ request('q') }}">
    </div>
    <div class="col-md-3">
      <label for="kategoriSelect" class="visually-hidden">Filter kategori</label>
      <select id="kategoriSelect" name="kategori" class="form-select" aria-label="Filter kategori">
        <option value="">Semua Kategori</option>
        @foreach($kategoriList as $kategori)
          <option value="{{ $kategori->slug }}" {{ request('kategori') == $kategori->slug ? 'selected' : '' }}>{{ $kategori->nama }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <label for="lokasiSelect" class="visually-hidden">Filter lokasi</label>
      <select id="lokasiSelect" name="lokasi" class="form-select" aria-label="Filter lokasi">
        <option value="">Semua Lokasi</option>
        @foreach($lokasiList as $lokasi)
          <option value="{{ $lokasi->slug }}" {{ request('lokasi') == $lokasi->slug ? 'selected' : '' }}>{{ $lokasi->nama }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <label for="statusSelect" class="visually-hidden">Filter status</label>
      <select id="statusSelect" name="status" class="form-select" aria-label="Filter status">
        <option value="">Semua Status</option>
        <option value="tersedia" {{ request('status')=='tersedia'? 'selected':'' }}>Tersedia</option>
        <option value="sudah-diambil" {{ request('status')=='sudah-diambil'? 'selected':'' }}>Sudah Diambil</option>
      </select>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary w-100">🔍 Cari Barang</button>
    </div>
  </form>

  <!-- DAFTAR BARANG -->
  @if($barangs->count())
    <div class="row row-cols-1 row-cols-md-3 g-4">
      @foreach($barangs as $barang)
        <div class="col">
          <div class="card h-100" style="background-color:#222;">
            <div class="card-body">
              <!-- Judul Barang -->
              <h2 class="card-title h5">
                <a href="{{ route('barang.show', $barang->slug) }}" class="link-light text-decoration-none">
                  {{ $barang->judul }}
                </a>
              </h2>

              <p class="text-light mb-1">
                📁 Kategori:
                @if($barang->kategori)
                  <a href="{{ route('kategori.show', $barang->kategori->slug) }}" class="link-light">{{ $barang->kategori->nama }}</a>
                @else
                  -
                @endif
              </p>

              <p class="text-light mb-1">
                📍 Lokasi:
                @if($barang->lokasi)
                  <a href="{{ route('lokasi.show', $barang->lokasi->slug) }}" class="link-light">{{ $barang->lokasi->nama }}</a>
                @else
                  -
                @endif
              </p>

              <p class="{{ $barang->diambil? 'text-danger':'text-success' }}">
                {{ $barang->diambil? 'Sudah Diambil':'Tersedia' }}
              </p>

              @if($barang->deskripsi)
                <p>{{ \Illuminate\Support\Str::limit($barang->deskripsi, 100) }}</p>
              @endif

              <!-- Tombol Detail Barang -->
              <a href="{{ route('barang.show', $barang->slug) }}" class="btn btn-sm btn-outline-light mt-2">Lihat Detail</a>
            </div>
            <div class="card-footer text-muted small">
              Diposting: {{ $barang->created_at->format('d M Y') }}
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
      {{ $barangs->withQueryString()->links() }}
    </div>
  @else
    <div class="alert alert-info">Tidak ada barang ditemukan sesuai filter/pencarian.</div>
  @endif
@endsection

