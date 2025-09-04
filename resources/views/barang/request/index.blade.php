@extends('layouts.app')

@section('title', 'Semua Permintaan Barang - BarangGratis.com')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-light">Semua Permintaan Barang</h1>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ url('/permintaan') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Cari permintaan barang...">
        </div>
        <div class="col-md-3">
            <select name="kategori" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="lokasi" class="form-select">
                <option value="">Semua Lokasi</option>
                @foreach($lokasiList as $lokasi)
                    <option value="{{ $lokasi->slug }}" {{ request('lokasi') == $lokasi->slug ? 'selected' : '' }}>
                        {{ $lokasi->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-warning">Filter</button>
        </div>
    </form>

    {{-- Grid daftar permintaan --}}
    <div class="row g-3">
        @forelse($requests as $item)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm bg-dark text-light">
                    <a href="{{ route('barang.show', $item->slug) }}">
                        <img src="{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                             class="card-img-top rounded-top" alt="{{ $item->judul }}"
                             style="height: 160px; object-fit: cover;">
                    </a>
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge {{ $item->status === 'sudah didapatkan' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $item->status === 'sudah didapatkan' ? 'Sudah Didapatkan' : 'Permintaan' }}
                            </span>
                            <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                        </div>
                        <h6 class="card-title mb-1">
                            <a href="{{ route('barang.show', $item->slug) }}" class="text-light text-decoration-none">
                                {{ Str::limit($item->judul, 40) }}
                            </a>
                        </h6>
                        <small class="text-muted">
                            {{ $item->lokasi->nama ?? 'Lokasi tidak tersedia' }}
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                Belum ada permintaan barang.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $requests->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

