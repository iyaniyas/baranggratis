@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Edit Barang</h3>
    <form action="{{ route('admin.barang.update', ['id' => $barang->id, 'token' => request('token')]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $barang->judul) }}" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $barang->deskripsi) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="no_wa" class="form-label">No WhatsApp</label>
            <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ old('no_wa', $barang->no_wa) }}" required>
        </div>
        <div class="mb-3">
            <label for="lokasi_id" class="form-label">Lokasi</label>
            <input type="number" class="form-control" id="lokasi_id" name="lokasi_id" value="{{ old('lokasi_id', $barang->lokasi_id) }}" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Ganti Gambar (opsional)</label>
            <input class="form-control" type="file" id="gambar" name="gambar">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.barang.index', ['token' => request('token')]) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

