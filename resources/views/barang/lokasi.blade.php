{{-- resources/views/barang/lokasi.blade.php --}}
@extends('layouts.app')

@section('meta_title', 'Barang Gratis di ' . $lokasi->nama . ' | BarangGratis.com')

@section('meta_description')
    Barang gratis di {{ $lokasi->nama }} – Temukan berbagai barang bekas layak pakai secara cuma-cuma di wilayah {{ $lokasi->nama }} dan sekitarnya. Update setiap hari, tanpa biaya, tanpa syarat!
@endsection

@section('content')
<div class="container my-4">
    <h2 class="mb-4 text-light">Barang di Lokasi: {{ $lokasi->nama }}</h2>
    @if ($barangs->count())
        <div class="row">
            @foreach($barangs as $barang)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow" style="background:#23272b; color:#fff;">
                        <div class="card-body">
                            <h5 class="card-title text-light">{{ $barang->judul }}</h5>
                            <p class="card-text text-light">
                                {{ \Illuminate\Support\Str::limit($barang->deskripsi, 100) }}
                            </p>
                            <span class="badge bg-secondary mb-2">{{ $barang->kategori->nama ?? '-' }}</span><br>
                            <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-primary btn-sm mt-2">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $barangs->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center text-dark bg-light" role="alert">
            Belum ada barang di lokasi <b>{{ $lokasi->nama }}</b>.
        </div>
    @endif
</div>
@endsection
