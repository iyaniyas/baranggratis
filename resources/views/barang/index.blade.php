@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-light">Daftar Barang Gratis</h2>
        <a href="{{ route('barang.create') }}" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    {{-- Optional: search & filter, copy dari homepage --}}
    <form method="GET" action="{{ url('/barang') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari barang...">
        </div>
        <div class="col-md-3">
            <select name="kategori_id" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris ?? [] as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="lokasi_id" class="form-select">
                <option value="">Semua Lokasi</option>
                @foreach ($lokasis ?? [] as $lokasi)
                    <option value="{{ $lokasi->id }}" {{ request('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                        {{ $lokasi->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">🔍 Cari</button>
        </div>
    </form>

    @if ($barangs->count())
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($barangs as $barang)
                <div class="col">
                    <div class="card h-100 bg-dark text-light shadow">
                        <div class="card-body">
                            <h5 class="card-title">{{ $barang->judul }}</h5>
                            <p class="mb-1">📁 Kategori: {{ $barang->kategori->nama ?? '-' }}</p>
                            <p class="mb-1">📍 Lokasi: {{ $barang->lokasi->nama ?? '-' }}</p>
                            <p class="{{ $barang->diambil ? 'text-danger' : 'text-success' }}">
                                Status: {{ $barang->diambil ? 'Sudah Diambil' : 'Tersedia' }}
                            </p>
                            <div class="mb-2">
                                {{ \Illuminate\Support\Str::limit($barang->deskripsi, 80) }}
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-secondary">
                            <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-sm btn-light">Detail</a>
                            @if (auth()->check() && $barang->user_id === auth()->id())
                                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $barangs->withQueryString()->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center">Belum ada barang yang tersedia.</div>
    @endif
</div>
@endsection

