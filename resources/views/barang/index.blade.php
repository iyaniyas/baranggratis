@extends('layouts.app')

@php
    // Judul dan deskripsi SEO untuk halaman daftar barang.
    $metaTitle = 'Daftar Barang Gratis - BarangGratis.com';
    $metaDescription = 'Jelajahi daftar barang bekas gratis di berbagai kategori dan lokasi di Indonesia. '
        .'Temukan furnitur, elektronik, pakaian, mainan, dan perlengkapan rumah tangga tanpa biaya.';
@endphp

@php
    // Ambil nama kategori/lokasi jika tersedia. Anda bisa menggunakan koleksi
    // yang sudah dikirim controller atau mengambil dari model langsung.
    $titleParts = [];

    if(request()->filled('kategori')) {
        // Misalnya controller sudah mengirim $kategoriList, cari nama kategori.
        $kategoriNama = $kategoriList->firstWhere('id', request('kategori'))->nama ?? request('kategori');
        $titleParts[] = "Kategori {$kategoriNama}";
    }

    if(request()->filled('lokasi')) {
        $lokasiNama = $lokasiList->firstWhere('id', request('lokasi'))->nama ?? request('lokasi');
        $titleParts[] = "Lokasi {$lokasiNama}";
    }

    if(request()->filled('q')) {
        $titleParts[] = 'Pencarian "' . request('q') . '"';
    }

    // Susun judul. Jika tidak ada filter, gunakan judul umum.
    $metaTitle = $titleParts
        ? implode(' - ', $titleParts) . ' | BarangGratis.com'
        : 'Daftar Barang Gratis | BarangGratis.com';
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')
<div class="container py-4 bg-dark text-light min-vh-100">
    <h2 class="mb-4 text-light">Daftar Barang</h2>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success text-dark">
            {{ session('success') }}
        </div>
    @endif

    {{-- Link update-status sekali saja --}}
    @if(session('status_token'))
        <div class="alert alert-info text-dark">
            <label><strong>Klik tombol Simpan di WhatsApp Anda untuk menyimpan link. Buka link ini apabila barang sudah diambil orang.</strong></label>
            <input
                type="text"
                class="form-control mb-2"
                value="{{ url('barang/update-status/' . session('status_token')) }}"
                readonly
                onclick="this.select()"
            >
            @if(session('no_wa'))
                <a
                    href="https://wa.me/{{ session('no_wa') }}?text={{ urlencode('Klik link apabila barang sudah diambil orang: ' . url('barang/update-status/' . session('status_token'))) }}"
                    target="_blank"
                    class="btn btn-success btn-sm"
                >
                    Simpan di WhatsApp Anda
                </a>
            @endif
        </div>
    @endif

    @if($barangs->count())
        <div class="row">
            @foreach($barangs as $barang)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 bg-dark text-light border-secondary">
                        @if($barang->gambar)
                            <img
                                src="{{ asset('storage/' . $barang->gambar) }}"
                                class="card-img-top"
                                style="object-fit:cover; max-height:200px;"
                                alt="Gambar {{ $barang->judul }}"
                            >
                        @endif

                        <div class="card-body">
                            <h5 class="card-title mb-2 text-light">
                                <a
                                    href="{{ url('/barang/' . $barang->slug) }}"
                                    class="text-light text-decoration-underline"
                                >
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

                        <div class="card-footer bg-dark border-secondary d-flex justify-content-end">
                            <a
                                href="{{ url('/barang/' . $barang->slug) }}"
                                class="btn btn-outline-info btn-sm"
                            >
                                Detail
                            </a>
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

