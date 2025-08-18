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
    <h2 class="mb-3 text-center fs-4">
        Temukan &amp; Bagikan Barang Gratis
    </h2>

    <!-- Bagian kenapa BarangGratis -->
    <div id="kenapaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-pause="hover">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#kenapaCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#kenapaCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#kenapaCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner text-center text-light bg-dark p-5 rounded">
            <div class="carousel-item active">
                <h3 class="h4">Kurangi Sampah</h3>
                <p>Berikan apa yang tidak lagi Anda butuhkan.</p>
            </div>
            <div class="carousel-item">
                <h3 class="h4">Hemat Uang</h3>
                <p>Dapatkan apa yang Anda inginkan secara gratis.</p>
            </div>
            <div class="carousel-item">
                <h3 class="h4">Bangun Komunitas</h3>
                <p>Bertemu tetangga, berbagi secara kreatif.</p>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#kenapaCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Sebelumnya</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#kenapaCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Berikutnya</span>
        </button>
    </div>

    <!-- Panduan cara kerja -->
    <div class="mb-5">
        <h4 class="h4 text-center mb-4">Cara Kerja BarangGratis.com</h4>
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="h5 mb-2">1. Pemilik Upload</h5>
                        <p class="mb-0">Pemilik mengunggah detail dan foto barang yang ingin dibagikan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="h5 mb-2">2. Klaim via WA</h5>
                        <p class="mb-0">Pencari barang menghubungi pemilik melalui WhatsApp untuk klaim.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="h5 mb-2">3. Ambil Barang</h5>
                        <p class="mb-0">Pencari datang ke lokasi untuk mengambil barang.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="h5 mb-2">4. Selesai</h5>
                        <p class="mb-0">Barang berpindah tangan, semua senang!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form pencarian: arahkan ke /barang agar filter diproses di halaman daftar -->
    <div class="mb-5 p-4 bg-dark text-light rounded">
        <h6 class="h4 text-center mb-3">Cari Barang Gratis</h6>
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
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-4">
            @foreach($barangs->take(6) as $barang)
                <div class="col">
                    <div class="card h-100 bg-dark text-light border-0 shadow-sm text-center">
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

        <div class="text-center mt-4 p-4 bg-dark rounded">
            <a href="/barang" class="btn btn-lg btn-light text-dark fw-bold">Lihat Semua Barang Gratis</a>
        </div>
    @else
        <div class="alert alert-info">Tidak ada barang ditemukan.</div>
    @endif
@endsection

