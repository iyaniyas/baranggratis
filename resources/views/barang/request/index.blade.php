@extends('layouts.app')

@section('meta_title', 'Daftar Permintaan Barang - BarangGratis.com')
@section('meta_description', 'Lihat daftar permintaan barang dari komunitas BarangGratis.com')

@section('content')
<div class="container py-4 bg-dark text-light min-vh-100">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-light">Daftar Permintaan Barang</h2>
        <a href="{{ route('barang.requests.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Minta Barang
        </a>
    </div>
    <p class="text-muted">Temukan barang yang dibutuhkan oleh komunitas</p>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success text-dark">
            {{ session('success') }}
        </div>
    @endif

    {{-- Link konfirmasi WA --}}
    @if(session('status_token'))
        @php
            $barangBaru = \App\Models\Barang::where('status_token', session('status_token'))
                                            ->where('is_request', true)
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
                sudah didapatkan.
            </strong></label>

            <input
                type="text"
                class="form-control mb-2"
                value="{{ route('barang.requests.confirm', session('status_token')) }}"
                readonly
                onclick="this.select()"
            />

            <a
                href="https://wa.me/{{ session('no_wa') }}?text={{ urlencode(
                    'Klik link konfirmasi permintaan: ' 
                    . ($barangBaru ? $barangBaru->judul : 'barang') 
                    . ' sudah didapatkan: ' 
                    . route('barang.requests.confirm', session('status_token'))
                ) }}"
                target="_blank"
                class="btn btn-light text-dark btn-sm"
            >
                <i class="fab fa-whatsapp me-1"></i> Simpan di WhatsApp Anda
            </a>
        </div>
    @endif

    {{-- Grid permintaan barang --}}
    @if($requests->count())
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-4">
            @foreach($requests as $request)
                <div class="col">
                    <div class="card h-100 bg-dark text-light border-0 shadow-sm text-center">

                        {{-- Gambar dengan link ke detail --}}
                        <a href="{{ route('barang.show', $request->slug) }}">
                            @if($request->gambar)
                                <img src="{{ asset('storage/' . $request->gambar) }}"
                                     alt="Foto {{ $request->judul }}"
                                     class="mx-auto"
                                     style="object-fit: cover; width: 200px; height: 150px;">
                            @else
                                <img src="{{ asset('no-image.jpg') }}"
                                     alt="Tidak Ada Foto"
                                     class="mx-auto"
                                     style="object-fit: cover; width: 200px; height: 150px;">
                            @endif
                        </a>

                        <div class="card-body d-flex flex-column justify-content-center">
                            {{-- Status --}}
                            <span class="badge bg-{{ $request->status === 'sudah didapatkan' ? 'success' : 'primary' }} mb-2">
                                {{ $request->status === 'sudah didapatkan' ? 'Sudah Didapatkan' : 'Permintaan' }}
                            </span>

                            {{-- Judul dengan link --}}
                            <h6 class="card-title mb-2">
                                <a href="{{ route('barang.show', $request->slug) }}" class="text-decoration-none text-light">
                                    {{ $request->judul }}
                                </a>
                            </h6>

                            {{-- Lokasi --}}
                            <p class="small text-muted mb-2">{{ $request->lokasi->nama }}</p>
                        </div>

                        <div class="card-footer bg-transparent border-0 text-muted small">
                            {{ $request->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $requests->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-light text-dark text-center">
            Belum ada permintaan barang.  
            <a href="{{ route('barang.requests.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-1"></i> Ajukan Permintaan
            </a>
        </div>
    @endif
</div>
@endsection

