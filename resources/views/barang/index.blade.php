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
		    href="https://wa.me/{{ session('no_wa') }}?text={{ urlencode('Klik link apabila ' . $barang->judul . ' sudah diambil: ' . url('barang/update-status/' . session('status_token'))) }}"
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

