@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light">
                <div class="card-header">
                    <h4>Tambah Barang</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Barang</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                        </div>
			<div class="mb-3">
			    <label for="no_wa" class="form-label">Nomor WhatsApp</label>
			    <input type="text" class="form-control" name="no_wa" required placeholder="Contoh: 62822000000 / 0822000000" value="{{ old('no_wa') }}">
			    <small class="mt-2" style="color: #f8f9fa !important; font-size: 0.92em;"">
			        Masukkan nomor dengan format <b>08xxxxxxxxxx</b> atau <b>628xxxxxxxxxx</b>.<br>
			        Tidak perlu spasi, tanda +, atau tanda strip.<br>
			        Sistem otomatis mengubah ke format internasional <b>628xxxxxxxxxx</b>.
			    </small>
			</div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" @if(old('kategori_id') == $kategori->id) selected @endif>
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
                                    <option value="{{ $lokasi->id }}" @if(old('lokasi_id') == $lokasi->id) selected @endif>
                                        {{ $lokasi->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Tambah Barang</button>
                        <a href="{{ route('beranda') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if(session('status_token'))
    <div class="alert alert-success bg-dark text-light border-light">
        <p class="fw-bold text-light">Barang berhasil ditambahkan!</p>
        <div class="mb-2">
            <b class="text-light">Link untuk update status barang menjadi sudah diambil:</b><br>
            <textarea id="statusTokenLink" class="form-control bg-dark text-light border-light" rows="2" readonly>{{ url('/barang/update-status/' . session('status_token')) }}</textarea>
            <button class="btn btn-outline-light mt-2" onclick="copyStatusTokenLink()">Salin Link</button>
        </div>
        <a class="btn btn-success mt-2"
           href="https://wa.me/{{ session('no_wa') }}?text=Ini%20link%20update%20status%20barang%20Anda:%20{{ urlencode(url('/barang/update-status/' . session('status_token'))) }}"
           target="_blank">
            Kirim link ke WhatsApp saya
        </a>
        <p class="mt-2" style="color: #f8f9fa !important; font-size: 0.92em;">
    Simpan link ini baik-baik. <b style="color: #f8f9fa !important;">Copy & simpan di HP Anda.</b><br>
    Link ini digunakan untuk update status barang bila sudah diambil!
	</p>
    </div>
    <script>
        function copyStatusTokenLink() {
            var copyText = document.getElementById("statusTokenLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");
            alert("Link sudah disalin ke clipboard!");
        }
    </script>
@endif

