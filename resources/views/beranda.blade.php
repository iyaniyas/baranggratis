@extends('layouts.app')

@section('meta_title', 'BarangGratis.com - Platform Barang Bekas & Gratis Seluruh Indonesia')
@section('meta_description', 'Platform terbesar untuk cari & berbagi barang bekas, barang gratis, second, furniture, elektronik, mainan, baju & lainnya. Semua gratis di seluruh Indonesia!')

@section('content')
  <h1 class="mb-4">Cari Barang Gratis</h1>

  <!-- FORM FILTER -->
  <form method="GET" action="{{ route('beranda') }}" class="row g-3 mb-4">
    <div class="col-md-3">
      <input type="text" name="q" class="form-control" placeholder="Cari nama barang..." value="{{ request('q') }}">
    </div>

    <div class="col-md-3">
      <select name="kategori" class="form-select">
        <option value="">Semua Kategori</option>
        @foreach ($kategoriList as $kategori)
          <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
            {{ $kategori->nama }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-3">
      <select name="lokasi" class="form-select">
        <option value="">Semua Lokasi</option>
        @foreach ($lokasiList as $lokasi)
          <option value="{{ $lokasi->id }}" {{ request('lokasi') == $lokasi->id ? 'selected' : '' }}>
            {{ $lokasi->nama }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-3">
      <select name="status" class="form-select">
        <option value="">Semua Status</option>
        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="diambil" {{ request('status') == 'diambil' ? 'selected' : '' }}>Sudah Diambil</option>
      </select>
    </div>

    <div class="col-12">
      <button type="submit" class="btn btn-primary w-100">🔍 Cari Barang</button>
    </div>
  </form>

  <!-- DAFTAR BARANG -->
  @if ($barangs->count())
    <div class="row row-cols-1 row-cols-md-3 g-4">
      @foreach ($barangs as $barang)
        <div class="col">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">{{ $barang->nama }}</h5>

              <p class="text-light mb-1">📁 Kategori: {{ $barang->kategori->nama ?? '-' }}</p>
              <p class="text-light mb-1">📍 Lokasi: {{ $barang->lokasi->nama ?? '-' }}</p>

              <p class="{{ $barang->diambil ? 'text-danger' : 'text-success' }}">
                {{ $barang->diambil ? 'Sudah Diambil' : 'Tersedia' }}
              </p>

              @if ($barang->deskripsi)
                <p>{{ \Illuminate\Support\Str::limit($barang->deskripsi, 100) }}</p>
              @endif
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
</div>
@endsection

