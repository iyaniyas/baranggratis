@extends('layouts.app')

@section('title', $barang->judul . ' - ' . ($barang->kategori->nama ?? '') . ' | Barang Gratis ' . ($barang->lokasi->nama ?? '') . ' ' . date('Y') . ' | BarangGratis.com')
@section('meta_description', strip_tags(Str::limit($barang->deskripsi, 150, '...')) . ' Temukan barang gratis kategori ' . ($barang->kategori->nama ?? '-') . ' di lokasi ' . ($barang->lokasi->nama ?? '-') . ' hanya di BarangGratis.com. Ambil atau bagikan barang tanpa biaya di komunitas kami.')

@section('content')
<div class="container">
    <h2>{{ $barang->judul }}</h2>
    <p><b>Kategori:</b> {{ $barang->kategori->nama ?? '-' }}</p>
    <p><b>Lokasi:</b> {{ $barang->lokasi->nama ?? '-' }}</p>
    <p><b>Status:</b> {{ $barang->status }}</p>
    <p><b>Deskripsi:</b><br>{{ $barang->deskripsi }}</p>
    @if($barang->gambar)
        <img src="{{ asset('storage/'.$barang->gambar) }}" width="300" style="margin-top:10px;">
    @endif
    @if($barang->status === 'tersedia')
    <form action="{{ route('barang.updateStatus', $barang->id) }}" method="POST">
        @csrf
        <input type="hidden" name="status" value="sudah diambil">
        <button type="submit" onclick="return confirm('Yakin ingin mengubah status jadi sudah diambil?')">Tandai Sudah Diambil</button>
    </form>
    @else
        <span style="color:red;font-weight:bold;">Barang Sudah Diambil</span>
    @endif

    <br><br>
    <a href="{{ route('barang.index') }}">← Kembali ke Daftar Barang</a>
</div>
@endsection

