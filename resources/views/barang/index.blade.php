@extends('layouts.app')

@section('meta_title', 'Daftar Barang - BarangGratis.com')
@section('meta_description', 'Lihat semua barang gratis dan permintaan barang terbaru di BarangGratis.com.')
@section('content')
<div class="container my-4">

    <h1 class="text-center text-light mb-4">Daftar Barang</h1>

    <!-- Tampilkan daftar barang -->
    @if($barangs->count())
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-4">
        @foreach($barangs as $barang)
            <div class="col">
                <div class="card h-100 bg-dark text-light border-0 shadow-sm text-center position-relative">

                    {{-- Gambar barang --}}
                    @if($barang->gambar)
                        <a href="{{ route('barang.show', $barang->slug) }}">
                            <img src="{{ asset('storage/' . $barang->gambar) }}"
                                 fetchpriority="high"
                                 alt="Foto {{ $barang->judul }}"
                                 class="mx-auto"
                                 style="object-fit: cover; width: 200px; height: 150px;">
                        </a>
                    @else
                        <a href="{{ route('barang.show', $barang->slug) }}">
                            <img src="{{ asset('no-image.jpg') }}"
                                 fetchpriority="high"
                                 alt="Tidak Ada Foto"
                                 class="mx-auto"
                                 style="object-fit: cover; width: 200px; height: 150px;">
                        </a>
                    @endif

                    {{-- Badge Permintaan --}}
                    @if($barang->is_request)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                            Permintaan
                        </span>
                    @endif

                    {{-- Badge Status --}}
                    <span class="badge 
                        @if($barang->status === 'tersedia') bg-success
                        @elseif($barang->status === 'sudah diambil') bg-secondary
                        @elseif($barang->status === 'sudah didapatkan') bg-warning text-dark
                        @else bg-light text-dark
                        @endif
                        position-absolute top-0 end-0 m-2">
                        {{ ucfirst($barang->status) }}
                    </span>

                    <div class="card-body d-flex flex-column justify-content-center">
                        <h7 class="card-title h5 mb-2">
                            <a href="{{ route('barang.show', $barang->slug) }}"
                               class="link-light text-decoration-none">
                                {{ $barang->judul }}
                            </a>
                        </h7>
                        <p class="text-light small mb-0">
                            Lokasi: {{ $barang->lokasi->nama }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $barangs->links('pagination::bootstrap-5') }}
    </div>
    @else
        <div class="alert alert-light text-dark">
            Belum ada barang tersedia.
        </div>
    @endif

</div>
@endsection

