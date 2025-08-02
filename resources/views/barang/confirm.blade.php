{{-- resources/views/barang/confirm.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2>Konfirmasi Klaim Pengambilan Barang</h2>
    <p>Apakah Anda yakin ingin mengubah status barang menjadi sudah diambil?: <strong>{{ $barang->judul }}</strong>?</p>

    <form action="{{ route('barang.claim', $barang->status_token) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            Ya, Ubah Menjadi Sudah Diambil
        </button>
        <a href="{{ route('barang.show', $barang->slug) }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection
