@extends('layouts.app')

@section('meta_title', 'Minta Barang - BarangGratis.com')
@section('meta_description', 'Ajukan permintaan barang yang Anda butuhkan secara gratis di BarangGratis.com')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center mb-0" style="font-weight: 700;">Form Permintaan Barang</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Terjadi kesalahan input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('barang.requests.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Permintaan *</label>
                            <input type="text" class="form-control" id="judul" name="judul" 
                                   value="{{ old('judul') }}" required placeholder="Contoh: Butuh Kursi Kantor Bekas">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Kebutuhan *</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" 
                                      rows="4" required placeholder="Jelaskan detail barang yang Anda butuhkan">{{ old('deskripsi') }}</textarea>
                            <div class="form-text">Deskripsikan dengan jelas agar orang lain dapat membantu.</div>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_diminta" class="form-label">Jumlah yang Diminta *</label>
                            <input type="number" class="form-control" id="jumlah_diminta" 
                                   name="jumlah_diminta" min="1" value="{{ old('jumlah_diminta', 1) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori *</label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_id" class="form-label">Lokasi *</label>
                            <select class="form-select" id="lokasi_id" name="lokasi_id" required>
                                <option value="">Pilih Lokasi</option>
                                @foreach($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ old('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                                        {{ $lokasi->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="no_wa" class="form-label">Nomor WhatsApp *</label>
                            <input type="text" class="form-control" id="no_wa" name="no_wa" 
                                   value="{{ old('no_wa') }}" required placeholder="Contoh: 081234567890">
                            <div class="form-text">Nomor WhatsApp Anda untuk dihubungi oleh pemberi barang.</div>
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="form-label">Foto Referensi (Opsional)</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Unggah foto referensi barang (maks 10MB).</div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Permintaan Anda akan langsung dipublikasikan tanpa perlu menunggu persetujuan admin.
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('barang.requests.list') }}" class="btn btn-secondary me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Ajukan Permintaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Format nomor WhatsApp
    document.getElementById('no_wa').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush
