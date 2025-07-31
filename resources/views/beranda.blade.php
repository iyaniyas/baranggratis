@extends('layouts.app')

@php
    // Meta statis untuk halaman beranda
    $metaTitle       = 'Barang Gratis: Berbagi & Menerima Cepat Aman';
    $metaDescription = 'Platform terbesar untuk cari & berbagi barang bekas, gratis, second, furniture, elektronik, mainan, baju & perlengkapan rumah lainnya. Semua gratis di seluruh Indonesia!';
@endphp

@section('meta_title',       $metaTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords',    'barang gratis, barang bekas gratis, pencarian barang, lokasi barang gratis')
@section('meta_url',         url('/'))

@section('content')
    <!-- Judul utama -->
    <h1 class="mb-3 text-center fs-4">
        Temukan &amp; Bagikan Barang Gratis
    </h1>

    <!-- Bagian kenapa BarangGratis -->
    <div class="p-4 card text-light rounded text-center">
        <h2 class="h4 mb-3">Kenapa BarangGratis?</h2>
        <p class="mb-1"><strong>Kurangi Sampah:</strong> Berikan apa yang tidak lagi Anda butuhkan.</p>
        <p class="mb-1"><strong>Hemat Uang:</strong> Dapatkan apa yang Anda inginkan secara gratis.</p>
        <p class="mb-3"><strong>Bangun Komunitas:</strong> Bertemu tetangga, berbagi secara kreatif.</p>
        <p class="mb-0">Ingin berbagi barang? <a href="{{ route('barang.create') }}" class="link-light text-decoration-underline">Klik di sini</a>.</p>
    </div>

    <!-- Panduan cara kerja -->
    <div class="mb-5">
        <h2 class="h4 text-center mb-4">Cara Kerja BarangGratis.com</h2>
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 mb-2">1. Pemilik Upload</h3>
                        <p class="mb-0">Pemilik mengunggah detail dan foto barang yang ingin dibagikan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 mb-2">2. Klaim via WA</h3>
                        <p class="mb-0">Pencari barang menghubungi pemilik melalui WhatsApp untuk klaim.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 mb-2">3. Ambil Barang</h3>
                        <p class="mb-0">Pencari datang ke lokasi untuk mengambil barang.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 mb-2">4. Selesai</h3>
                        <p class="mb-0">Barang berpindah tangan, semua senang!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form pencarian: arahkan ke /barang agar filter diproses di halaman daftar -->
    <div class="mb-5 p-4 bg-dark text-light rounded">
        <h2 class="h4 text-center mb-3">Cari Barang Gratis</h2>
        <form method="GET" action="{{ url('/barang') }}" class="row g-3 justify-content-center align-items-end">
            <div class="col-md-3">
                <label for="q" class="visually-hidden">Cari nama barang</label>
                <input type="text" id="q" name="q" class="form-control" placeholder="Cari nama barang..." value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <label for="lokasiSelect" class="visually-hidden">Filter lokasi</label>
                <select id="lokasiSelect" name="lokasi" class="form-select" aria-label="Filter lokasi">
                    <option value="">Semua Lokasi</option>
                    @foreach($lokasiList as $lokasi)
                        <!-- gunakan slug sebagai value agar URL tetap konsisten -->
                        <option value="{{ $lokasi->slug }}" {{ request('lokasi') == $lokasi->slug ? 'selected' : '' }}>
                            {{ $lokasi->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </form>
    </div>

    <!-- Tampilkan cuplikan 6 barang terbaru -->
    @if($barangs->count())
        <div class="row row-cols-6 g-4">
            @foreach($barangs->take(6) as $barang)
                <div class="col">
                    <div class="card h-100 bg-dark text-light border-0 shadow-sm">
                        @if($barang->gambar)
                            <img src="{{ asset('storage/' . $barang->gambar) }}" fetchpriority="high" style="object-fit: cover; width: 200px; height: 200px;">
                        @else
                            <img src="{{ asset('no-image.jpg') }}" fetchpriority="high" style="object-fit: cover; width: 200px; height: 200px;">
                        @endif

                        <div class="card-body">
                            <h3 class="card-title h5">
                                <a href="{{ route('barang.show', $barang->slug) }}" class="link-light text-decoration-none">{{ $barang->judul }}</a>
                            </h3>

                            <p class="text-light mb-1">
                                Kategori: {{ $barang->kategori->nama }} | Lokasi: {{ $barang->lokasi->nama }} |
                                {{ $barang->status === 'tersedia' ? 'Tersedia' : 'Sudah Diambil' }}
                            </p>

                            @if($barang->deskripsi)
                                <p class="text-light">{{ \Illuminate\Support\Str::limit($barang->deskripsi, 100) }}</p>
                            @endif

                            <a href="{{ route('barang.show', $barang->slug) }}" class="btn btn-sm btn-outline-light mt-2">Lihat Detail</a>
                        </div>
                        <div class="card-footer text-light small">
                            Diposting: {{ $barang->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4 p-4 bg-dark rounded">
            <a href="/barang" class="btn btn-lg btn-light text-dark fw-bold">Lihat Semua Barang Gratis</a>
        </div>
    @else
        <div class="alert alert-info">Tidak ada barang ditemukan.</div>
    @endif
@endsection


