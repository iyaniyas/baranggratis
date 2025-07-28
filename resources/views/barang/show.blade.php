@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $timestamp = Carbon::parse($barang->created_at)->format('Y-m-d');
    $judulLengkap = $barang->judul . ' - ' . $timestamp;
    $deskripsiRingkas = Str::limit(strip_tags($barang->deskripsi), 150);
    $gambarUrl = $barang->gambar ? asset('storage/'.$barang->gambar) : asset('no-image.jpg');
@endphp

@section('title', $judulLengkap)

@section('meta')
    <meta name="description" content="{{ $deskripsiRingkas }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $judulLengkap }}">
    <meta property="og:description" content="{{ $deskripsiRingkas }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $gambarUrl }}">
@endsection

@section('content')
<div class="container py-4">
    <div class="card text-light" style="background-color:#222;">
        <div class="card-body">
            <h2 class="card-title">{{ $barang->judul }} <small class="text-muted fs-6">({{ $timestamp }})</small></h2>
            
            <p class="mt-3"><strong>Kategori:</strong> {{ $barang->kategori->nama ?? '-' }}</p>
            <p><strong>Lokasi:</strong> {{ $barang->lokasi->nama ?? '-' }}</p>
            <p><strong>Status:</strong> 
                @if($barang->status == 'tersedia')
                    <span class="badge bg-success">Tersedia</span>
                @else
                    <span class="badge bg-secondary">Sudah Diambil</span>
                @endif
            </p>
            <p><strong>Deskripsi:</strong><br>{{ $barang->deskripsi }}</p>

            @if($barang->gambar)
                <img src="{{ asset('storage/'.$barang->gambar) }}" class="img-fluid mt-3 rounded" alt="Gambar Barang">
            @endif

            @if($barang->status === 'tersedia')
                <form action="{{ route('barang.updateStatus', $barang->slug) }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="status" value="sudah diambil">
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Yakin ingin mengubah status jadi sudah diambil?')">
                        Tandai Sudah Diambil
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection

