@extends('layouts.app')

@php
    // Tangkap parameter q dan lokasi (id)
    $q        = request()->input('q');
    $lokasiId = request()->input('lokasi');

    // Siapkan array untuk querystring canonical (semua huruf kecil)
    $params = [];
    $parts  = [];

    // Jika ada pencarian, simpan ke querystring & judul
    if ($q) {
        $parts[]       = 'Pencarian "' . $q . '"';
        $params['q']   = strtolower($q);     // query disimpan huruf kecil
    }

    // Jika ada filter lokasi (id), cari nama lokasinya untuk judul & isi querystring
    if ($lokasiId) {
        $lokasiObj  = $lokasiList->firstWhere('id', $lokasiId);
        $lokasiName = $lokasiObj ? $lokasiObj->nama : $lokasiId;
        $lokasiSlug = $lokasiObj ? $lokasiObj->slug : \Illuminate\Support\Str::slug($lokasiName);

        // Tambahkan nama lokasi ke judul
        $parts[] = 'Lokasi ' . $lokasiName;

        // Gunakan slug (huruf kecil) untuk canonical URL
        $params['lokasi'] = strtolower($lokasiSlug);
    }

    // Nilai default judul & deskripsi
    $metaTitle       = 'Barang Gratis: Berbagi & Menerima Cepat Aman';
    $metaDescription = 'Platform terbesar untuk cari & berbagi barang bekas, gratis, second, furniture, elektronik, mainan, baju & perlengkapan rumah lainnya. Semua gratis di seluruh Indonesia!';

    // Susun judul & deskripsi jika ada filter
    if ($parts) {
        $metaTitle       = implode(' - ', $parts) . ' | BarangGratis.com';
        $metaDescription = 'Hasil ' . strtolower(implode(' dan ', $parts))
            . ' di BarangGratis.com. Temukan barang bekas gratis, second, furniture, elektronik, mainan, baju & perlengkapan rumah di berbagai lokasi di Indonesia.';
    }

    // Bangun URL huruf kecil untuk og:url dan canonical
    $metaUrl = url('/') . ($params ? '?' . http_build_query($params) : '');
    $metaUrl = strtolower($metaUrl);
@endphp

@section('meta_title',       $metaTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords',    'barang gratis, barang bekas gratis, pencarian barang, lokasi barang gratis')
@section('meta_url',         $metaUrl)

@section('content')
    <!-- Judul utama -->
    <h1 class="mb-4 text-center">
        BarangGratis.com: Temukan &amp; Bagikan Barang Bekas Gratis di Indonesia
    </h1>

    <!-- Bagian kenapa BarangGratis -->
    <div class="p-4 mb-5 bg-secondary text-light rounded text-center">
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

    <!-- Form filter -->
    <div class="mb-5 p-4 bg-dark text-light rounded">
        <h2 class="h4 text-center mb-3">Cari Barang Gratis</h2>
        <form method="GET" action="{{ route('beranda') }}" class="row g-3 justify-content-center align-items-end">
            <div class="col-md-3">
                <label for="q" class="visually-hidden">Cari nama barang</label>
                <input type="text" id="q" name="q" class="form-control" placeholder="Cari nama barang..." value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <label for="lokasiSelect" class="visually-hidden">Filter lokasi</label>
                <select id="lokasiSelect" name="lokasi" class="form-select" aria-label="Filter lokasi">
                    <option value="">Semua Lokasi</option>
                    @foreach($lokasiList as $lokasi)
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

    @if($barangs->count())
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($barangs->take(3) as $barang)
                <div class="col">
                    <div class="card h-100 bg-dark text-light border-0 shadow-sm">
                        @if($barang->gambar)
                            <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->judul }}" class="card-img-top img-fluid img-thumbnail" fetchpriority="high" style="object-fit: cover; height: 200px;">
                        @else
                            <img src="{{ asset('no-image.jpg') }}" alt="No Image" class="card-img-top img-fluid img-thumbnail" fetchpriority="high" style="object-fit: cover; height: 200px;">
                        @endif

                        <div class="card-body">
                            <h3 class="card-title h5">
                                <a href="{{ route('barang.show', $barang->slug) }}" class="link-light text-decoration-none">{{ $barang->judul }}</a>
                            </h3>

                            <p class="text-light mb-1">
                                Kategori:
                                @if($barang->kategori)
                                    <a href="{{ route('kategori.show', $barang->kategori->slug) }}" class="link-light text-decoration-none">{{ $barang->kategori->nama }}</a>
                                @else
                                    -
                                @endif
                            </p>

                            <p class="text-light mb-1">
                                Lokasi:
                                @if($barang->lokasi)
                                    <a href="{{ route('lokasi.show', $barang->lokasi->slug) }}" class="link-light text-decoration-none">{{ $barang->lokasi->nama }}</a>
                                @else
                                    -
                                @endif
                            </p>

                            <p class="{{ $barang->status === 'tersedia' ? 'text-success' : 'text-danger' }} fw-bold">
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
        <div class="alert alert-info">Tidak ada barang ditemukan sesuai filter/pencarian.</div>
    @endif
@endsection

