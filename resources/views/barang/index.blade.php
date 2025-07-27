@extends('layouts.app')

@section('content')
<div class="container py-4 bg-dark text-light min-vh-100">
    <h2 class="mb-4 text-light">Daftar Barang</h2>

    @if(session('success'))
        <div class="alert alert-success text-dark">{{ session('success') }}</div>
    @endif

    @if($barangs->count())
        <div class="row">
            @foreach($barangs as $barang)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 bg-dark text-light border-secondary">
                        @if($barang->gambar)
                            <img src="{{ asset('storage/' . $barang->gambar) }}" class="card-img-top" style="object-fit:cover; max-height:200px;" alt="Gambar {{ $barang->judul }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title mb-2 text-light">
                                <a href="{{ url('/barang/' . $barang->slug) }}" class="text-light text-decoration-underline">
                                    {{ $barang->judul }}
                                </a>
                            </h5>
                            <div class="mb-1 small text-light">
                                Kategori: {{ optional($barang->kategori)->nama ?? '-' }} |
                                Lokasi: {{ optional($barang->lokasi)->nama ?? '-' }}
                            </div>
                            <p class="card-text text-light">
                                {{ \Illuminate\Support\Str::limit($barang->deskripsi, 100) }}
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center bg-dark border-secondary">
                            <a href="{{ url('/barang/' . $barang->slug . '/edit') }}" class="btn btn-outline-warning btn-sm">Edit</a>
                            <form action="{{ url('/barang/' . $barang->slug . '/delete') }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                            </form>
                            <a href="{{ url('/barang/' . $barang->slug) }}" class="btn btn-outline-info btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            {{ $barangs->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-light text-dark">Belum ada barang tersedia.</div>
    @endif
</div>
@endsection

