@extends('layouts.app')

@section('meta_title', 'BarangGratis.com - Berbagi Barang Tak Terpakai, Jadi Berkah')
@section('meta_description', 'BarangGratis.com adalah platform komunitas berbagi barang tak terpakai. Bagikan barangmu, bantu sesama, dan jadikan hidup lebih bermanfaat.')

@section('content')
<style>
  /* Custom teks abu muda (lebih terang daripada secondary) */
  .text-light-50 { color: rgba(255, 255, 255, 0.75) !important; }
</style>

<!-- Hero Section -->
<section class="py-5 bg-dark text-light text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Ubah Barang Tak Terpakai Jadi Berkah</h1>
        <p class="lead text-light-50 mb-4">
            Di BarangGratis.com, kami percaya barang yang tak lagi terpakai bisa memberi kehidupan baru bagi orang lain.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ url('/barang/create') }}" class="btn btn-light btn-lg fw-bold text-dark">
                🎁 Mulai Berbagi
            </a>
            <a href="{{ url('/permintaan/tambah') }}" class="btn btn-outline-light btn-lg fw-bold">
                🙏 Butuh Barang?
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-black text-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">Kenapa Memilih BarangGratis.com?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-dark rounded shadow-sm h-100">
                    <h3 class="h5 fw-bold mb-3">1. Mudah & Cepat</h3>
                    <p class="text-light-50">
                        Posting barang hanya butuh beberapa menit. Langsung terhubung dengan orang yang membutuhkan.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-dark rounded shadow-sm h-100">
                    <h3 class="h5 fw-bold mb-3">2. Bermanfaat</h3>
                    <p class="text-light-50">
                        Barangmu yang tak lagi terpakai bisa jadi berkah besar bagi orang lain. Bantu kurangi limbah & berbagi kebaikan.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-dark rounded shadow-sm h-100">
                    <h3 class="h5 fw-bold mb-3">3. Komunitas Peduli</h3>
                    <p class="text-light-50">
                        Bergabunglah dengan ribuan orang baik hati yang percaya bahwa berbagi adalah cara terbaik untuk hidup bermakna.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-dark text-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Cerita dari Mereka</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-black rounded shadow-sm h-100">
                    <p class="text-light-50">
                        “Saya punya kursi lama yang tidak terpakai. Setelah saya bagikan di BarangGratis.com, kursi itu dipakai kembali di rumah baru seseorang. Rasanya luar biasa!”
                    </p>
                    <p class="fw-bold mt-3 mb-0">– Rina, Jakarta</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-black rounded shadow-sm h-100">
                    <p class="text-light-50">
                        “BarangGratis.com membantu saya mendapatkan meja belajar untuk anak saya. Terima kasih untuk semua yang mau berbagi.”
                    </p>
                    <p class="fw-bold mt-3 mb-0">– Andi, Surabaya</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-black rounded shadow-sm h-100">
                    <p class="text-light-50">
                        “Bukan cuma soal barang, tapi juga rasa kebersamaan. Kita bisa bantu orang lain tanpa mengeluarkan biaya.”
                    </p>
                    <p class="fw-bold mt-3 mb-0">– Siti, Bandung</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Closing -->
<section class="py-5 bg-black text-light text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">Mari Jadi Bagian dari Perubahan</h2>
        <p class="text-light-50 mb-4">
            Setiap barang yang kamu bagikan bisa memberi kehidupan baru. Saatnya berbagi, saatnya peduli.
        </p>
        <a href="{{ url('/barang/create') }}" class="btn btn-light btn-lg fw-bold text-dark">
            🚀 Mulai Sekarang
        </a>
    </div>
</section>
@endsection

