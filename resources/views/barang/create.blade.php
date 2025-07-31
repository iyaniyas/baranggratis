@extends('layouts.app')

@section('meta_title', 'Berbagi Barang Gratis | BarangGratis.com')
@section('meta_description', 'Tambahkan barang gratis yang tidak terpakai dan bantu orang lain yang membutuhkan. Mudah, cepat, dan tanpa biaya di BarangGratis.com. Isi data barang, upload gambar, dan bagikan lokasi pengambilan.')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light">
                <div class="card-header">
                    <h2>Berbagi Barang Gratis</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Barang</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                        </div>
			
			<div class="mb-3">
			  <label for="no_wa" class="form-label">No. WhatsApp (pemilik)</label>
			  <input type="text"
			         name="no_wa"
			         class="form-control"
			         placeholder="6281234567890"
			         value="{{ old('no_wa') }}"
			         required>
				  <small class="form-text text-light">
				  Masukkan nomor WA tanpa “+” atau “0” di depan (contoh: 6281234567890).
				  </small>
			</div>
	
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        @if(old('kategori_id') == $kategori->id) selected @endif>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_id" class="form-label">Lokasi</label>
                            <select name="lokasi_id" class="form-select" required>
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}"
                                        @if(old('lokasi_id') == $lokasi->id) selected @endif>
                                        {{ $lokasi->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
<small class="form-text text-danger" id="file-size-warning" style="display:none">
    Ukuran file terlalu besar (maksimal 10MB)
</small>
<script>
document.getElementById('gambar').addEventListener('change', function(e) {
    var file = e.target.files[0];
    var warning = document.getElementById('file-size-warning');
    if (file && file.size > 10 * 1024 * 1024) {
        warning.style.display = 'block';
        e.target.value = '';
    } else {
        warning.style.display = 'none';
    }
});
</script>

                        </div>

                        <div class="mb-3">
                            <label for="alamat_pengambilan" class="form-label">Alamat Pengambilan</label>
                            <input type="text" name="alamat_pengambilan" class="form-control"
                                   value="{{ old('alamat_pengambilan') }}">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

