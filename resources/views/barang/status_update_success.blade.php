@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="alert alert-success text-center">
        <h3>Status barang berhasil diupdate!</h3>
        <p>Barang <b>{{ $barang->judul }}</b> sudah ditandai <b>SUDAH DIAMBIL</b>.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Kembali ke Beranda</a>
    </div>
</div>
@endsection

