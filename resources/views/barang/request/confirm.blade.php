@extends('layouts.app')

@section('meta_title', 'Konfirmasi Permintaan Barang - BarangGratis.com')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center mb-0" style="font-weight: 700;">Konfirmasi Permintaan Barang</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($barang->gambar)
                            <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->judul }}" 
                                 class="img-fluid rounded" style="max-height: 200px;">
                        @endif
                        <h4 class="mt-3">{{ $barang->judul }}</h4>
                        <p class="text-muted">Jumlah diminta: {{ $barang->jumlah_diminta }}</p>
                    </div>

                    <p class="text-center">Apakah Anda sudah mendapatkan barang ini?</p>
                    
                    <form action="{{ route('barang.requests.claim', $barang->status_token) }}" method="POST">
                        @csrf
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Ya, Sudah Didapatkan</button>
                            <a href="{{ route('barang.requests.list') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
