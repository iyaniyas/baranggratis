@extends('layouts.app')

@section('meta_title', 'Barang Gratis: Berbagi & Menerima Cepat Aman')
@section('meta_description', 'Platform terbesar untuk cari & berbagi barang bekas, gratis, second, furniture, elektronik, mainan, baju & perlengkapan rumah lainnya. Semua gratis di seluruh Indonesia!')

@section('content')
  <h1 class="mb-4 text-center">Cari Barang Gratis</h1>

  <!-- FORM FILTER -->
  <form method="GET" action="{{ route('beranda') }}" class="row g-3 mb-4 justify-content-center align-items-end">
    <div class="col-md-3">
      <label for="q" class="visually-hidden">Cari nama barang</label>
      <input type="text" id="q" name="q" class="form-control" placeholder="Cari nama barang..." value="{{ request('q') }}">
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
      <button type="submit" class="btn btn-primary w-100">🔍 Cari</button>
    </div>
  </form>

  <!-- DAFTAR BARANG -->
  @if($barangs->count())
    <div class="row row-cols-1 row-cols-md-3 g-4">
      @foreach($barangs as $barang)
        <div class="col">
          <div class="card h-100" style="background-color:#222;">
            <!-- Thumbnail Gambar -->
            @if($barang->gambar)
              <img
                src="{{ asset('storage/' . $barang->gambar) }}"
                alt="{{ $barang->judul }}"
                class="card-img-top img-fluid img-thumbnail" fetchpriority="high"
                style="object-fit: cover; height: 200px;"
              >
            @else
              <img
                src="{{ asset('no-image.jpg') }}"
                alt="No Image"
                class="card-img-top img-fluid img-thumbnail" fetchpriority="high"
                style="object-fit: cover; height: 200px;"
              >
            @endif

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

              <p class="{{ $barang->status === 'tersedia' ? 'text-success' : 'text-danger' }}">
                {{ $barang->status === 'tersedia' ? 'Tersedia' : 'Sudah Diambil' }}
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
    <div class="mt-4 text-center">
      {{ $barangs->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
  @else
    <div class="alert alert-info">Tidak ada barang ditemukan sesuai filter/pencarian.</div>
  @endif
@endsection

