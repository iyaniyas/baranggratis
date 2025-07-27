@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Barang</h2>
    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Judul Barang</label>
            <input type="text" name="judul" value="{{ $barang->judul }}" required>
        </div>
        <div>
            <label>Deskripsi</label>
            <textarea name="deskripsi" required>{{ $barang->deskripsi }}</textarea>
        </div>
        <div>
           <label>Kategori</label>
           <select name="kategori_id" required>
            <option value="">Pilih Kategori</option>
            @foreach($kategoris as $kategori)
             <option value="{{ $kategori->id }}" @if($barang->kategori_id == $kategori->id) selected @endif>
                {{ $kategori->nama }}
             </option>
            @endforeach
           </select>
       </div>
       <div>
          <label>Lokasi</label>
          <select name="lokasi_id" required>
            <option value="">Pilih Lokasi</option>
            @foreach($lokasis as $lokasi)
             <option value="{{ $lokasi->id }}" @if($barang->lokasi_id == $lokasi->id) selected @endif>
                 {{ $lokasi->nama }}
             </option>
            @endforeach
         </select>
       </div>
       <div>
            <label>Gambar</label>
            @if($barang->gambar)
                <img src="{{ asset('storage/'.$barang->gambar) }}" width="100"><br>
            @endif
            <input type="file" name="gambar">
        </div>
        <button type="submit">Update Barang</button>
    </form>
</div>
@endsection

