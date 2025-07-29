@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $timestamp      = Carbon::parse($barang->created_at)->format('Y-m-d');
    $judulLengkap   = $barang->judul . ' - ' . $timestamp;
    $deskripsiRingkas = $barang->judul . ' - ' . $timestamp . ' - ' . Str::limit(strip_tags($barang->deskripsi), 150);
    $gambarUrl      = $barang->gambar
                        ? asset('storage/'.$barang->gambar)
                        : asset('no-image.jpg');
@endphp

@section('meta_title', $judulLengkap)
@section('meta_description', $deskripsiRingkas)

@section('meta')
    <meta name="description" content="{{ $deskripsiRingkas }}">
    <meta property="og:type"        content="article">
    <meta property="og:title"       content="{{ $judulLengkap }}">
    <meta property="og:description" content="{{ $deskripsiRingkas }}">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:image"       content="{{ $gambarUrl }}">
@endsection

@section('content')
<div class="container py-4">
    <div class="card bg-dark text-light">
        @if($gambarUrl)
            <img src="{{ $gambarUrl }}" class="card-img-top" alt="{{ $barang->judul }}">
        @endif
        <div class="card-body">
            <h2 class="card-title">{{ $barang->judul }}</h2>
            <p><b>Kategori:</b> {{ $barang->kategori->nama ?? '-' }}</p>
            <p><b>Lokasi:</b> {{ $barang->lokasi->nama ?? '-' }}</p>
            <p><b>Alamat Pengambilan:</b> {{ $barang->alamat_pengambilan ?? '-' }}</p>
            <p><b>Deskripsi:</b><br>{!! nl2br(e($barang->deskripsi)) !!}</p>
            <p><b>Status:</b> {{ ucfirst($barang->status) }}</p>

            @if($barang->status === 'tersedia')
                <form action="{{ route('barang.updateStatus', $barang->slug) }}"
                      method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="status" value="sudah diambil">
                    <button type="submit" class="btn btn-warning"
                            onclick="return confirm('Yakin ingin mengubah status jadi sudah diambil?')">
                        Tandai Sudah Diambil
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection

