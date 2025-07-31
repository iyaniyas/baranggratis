{{-- resources/views/barang/confirm.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2>Konfirmasi Klaim Barang</h2>
    <p>Apakah Anda yakin ingin mengklaim: <strong>{{ $barang->judul }}</strong>?</p>

    <form action="{{ route('barang.claim', $barang->status_token) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            Ya, Klaim Sekarang
        </button>
        <a href="{{ route('barang.show', $barang->slug) }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection

