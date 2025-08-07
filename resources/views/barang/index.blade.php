@extends('layouts.app')

@php
    use App\Models\Barang;
    use App\Models\Lokasi;

    // Parameter filter dari query string
    $q          = request()->input('q');
    $lokasiParam = request()->input('lokasi');

    // Data lokasi untuk dropdown
    $lokasiList = Lokasi::all();

    // Siapkan parameter untuk canonical URL dan meta title/description
    $params = [];
    $parts  = [];

    if ($q) {
        $parts[]     = 'Pencarian "' . $q . '"';
        $params['q'] = strtolower($q);
    }

    if ($lokasiParam) {
        // Cari lokasi berdasarkan ID atau slug untuk meta
        $lokasiObj  = $lokasiList->firstWhere('id', $lokasiParam) ?: $lokasiList->firstWhere('slug', $lokasiParam);
        $lokasiName = $lokasiObj ? $lokasiObj->nama : $lokasiParam;
        $lokasiSlug = $lokasiObj ? $lokasiObj->slug : \Illuminate\Support\Str::slug($lokasiName);
        $parts[] = 'Lokasi ' . $lokasiName;
        $params['lokasi'] = strtolower($lokasiSlug); // slug disimpan dalam huruf kecil untuk URL konsisten:contentReference[oaicite:0]{index=0}
    }

    // Meta title dan description default
    $metaTitle       = 'Daftar Barang Gratis | BarangGratis.com';
    $metaDescription = 'Temukan berbagai barang bekas gratis di berbagai kategori dan lokasi di Indonesia.';
    if ($parts) {
        $metaTitle       = implode(' - ', $parts) . ' | BarangGratis.com';
        $metaDescription = 'Hasil ' . strtolower(implode(' dan ', $parts)) . ' di BarangGratis.com. '
            . 'Temukan barang bekas gratis, second, furniture, elektronik, mainan, baju & perlengkapan rumah di berbagai lokasi di Indonesia.';
    }

    // Bangun canonical URL yang selalu huruf kecil
    $metaUrl = url('/barang') . ($params ? '?' . http_build_query($params) : '');
    $metaUrl = strtolower($metaUrl);

    // Susun judul halaman (H1) berdasarkan filter
    // Default judul adalah 'Daftar Barang', lalu ditambahkan kata kunci dan lokasi jika ada
    $heading = 'Daftar Barang';
    if ($q) {
        $heading .= ' "' . $q . '"';
    }
    if ($lokasiParam) {
        // Cari nama lokasi lagi untuk judul (agar tidak bergantung pada $lokasiObj di atas)
        $headingLok  = $lokasiList->firstWhere('id', $lokasiParam) ?: $lokasiList->firstWhere('slug', $lokasiParam);
        $lokasiNamaHeading = $headingLok ? $headingLok->nama : $lokasiParam;
        $heading .= ' di ' . $lokasiNamaHeading;
    }

    // Query barang dengan filter (tanpa mengubah controller)
    $barangQuery = Barang::with(['kategori', 'lokasi']);
    if ($q) {
        $search = strtolower($q);
        $barangQuery->where(function ($query) use ($search) {
            $query->whereRaw('LOWER(judul) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(deskripsi) LIKE ?', ['%' . $search . '%']);
        });
    }
    if ($lokasiParam) {
        $lokasiFiltered = $lokasiList->firstWhere('id', $lokasiParam) ?: $lokasiList->firstWhere('slug', $lokasiParam);
        if ($lokasiFiltered) {
            $barangQuery->where('lokasi_id', $lokasiFiltered->id);
        }
    }
    // withQueryString agar link paginasi tetap membawa parameter filter:contentReference[oaicite:1]{index=1}
    $barangs = $barangQuery->latest()->paginate(10)->withQueryString();
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)
@section('meta_url', $metaUrl)

@section('content')
<div class="container py-4 bg-dark text-light min-vh-100">
    {{-- Judul halaman dinamis --}}
    <h2 class="mb-4 text-light">{{ $heading }}</h2>

    {{-- Form filter pencarian dan lokasi --}}
    <div class="mb-4 p-3 bg-dark text-light rounded">
        <form method="GET" action="{{ url('/barang') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" placeholder="Cari nama barang..." value="{{ request('q') }}">
            </div>
            <div class="col-md-4">
                <select name="lokasi" class="form-select">
                    <option value="">Semua Lokasi</option>
                    @foreach ($lokasiList as $lokasi)
                        <option value="{{ strtolower($lokasi->slug) }}"
                            {{ (request('lokasi') == strtolower($lokasi->slug) || request('lokasi') == $lokasi->id) ? 'selected' : '' }}>
                            {{ $lokasi->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </form>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success text-dark">
            {{ session('success') }}
        </div>
    @endif

    {{-- Link update-status sekali saja --}}
{{-- resources/views/barang/index.blade.php –– bagian Link konfirmasi --}}
@if(session('status_token'))
    @php
        $barangBaru = \App\Models\Barang::where('status_token', session('status_token'))
                                        ->latest()
                                        ->first();
    @endphp
    <div class="alert alert-info text-dark">
        <label><strong>
            Klik tombol Simpan di WhatsApp Anda untuk menyimpan link.<br>
            Buka link ini apabila
            <span class="text-primary fw-bold">
                {{ $barangBaru ? strtolower($barangBaru->judul) : 'barang' }}
            </span>
            sudah diambil orang.
        </strong></label>

        <input
            type="text"
            class="form-control mb-2"
            value="{{ route('barang.confirm', session('status_token')) }}"
            readonly
            onclick="this.select()"
        />

        <a
            href="https://wa.me/{{ session('no_wa') }}?text={{ urlencode(
                'Klik link konfirmasi pengambilan: ' 
                . $barangBaru->judul 
                . ' sudah diambil: ' 
                . route('barang.confirm', session('status_token'))
            ) }}"
            target="_blank"
            class="btn btn-success btn-sm"
        >
            Simpan di WhatsApp Anda
        </a>
    </div>
@endif

<!-- Tampilkan cuplikan 6 barang terbaru -->
    @if($barangs->count())
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-4">
        @foreach($barangs as $barang)
            <div class="col">
                <div class="card h-100 bg-dark text-light border-0 shadow-sm text-center">
                    @if($barang->gambar)
                        <img src="{{ asset('storage/' . $barang->gambar) }}"
                             fetchpriority="high"
			     alt="Foto {{ $barang->judul }}"  {{-- deskripsi singkat --}}
                             class="mx-auto"
                             style="object-fit: cover; width: 200px; height: 150px;">
                    @else
                        <img src="{{ asset('no-image.jpg') }}"
                             fetchpriority="high"
			     alt="Tidak Ada Foto"
                             class="mx-auto"
                             style="object-fit: cover; width: 200px; height: 150px;">
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

