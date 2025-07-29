@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $timestamp      = Carbon::parse($barang->created_at)->format('Y-m-d');
    $judulLengkap   = $barang->judul . ' - ' . $timestamp;
    $deskripsiRingkas = $barang->judul . ' - ' . $timestamp . ' - ' . Str::limit(strip_tags($barang->deskripsi), 150);
    $gambarUrl      = $barang->gambar
                        ? asset('storage/'.$barang->gambar)
                        : asset('no-image.jpg');
@endphp

@section('meta_title', $judulLengkap)
@section('meta_description', $deskripsiRingkas)
@section('meta_image', $gambarUrl)
@section('og_type', 'product')

{{--
    Bagian meta khusus seperti og:type dan meta image diatur melalui section
    'og_type' dan 'meta_image'. Schema JSON-LD akan disisipkan di bagian
    konten supaya tetap terdeteksi oleh mesin pencari meski layout tidak
    menyediakan slot meta khusus.
--}}

@section('content')
<div class="container py-4">
    <!--
        Gunakan grid Bootstrap untuk menempatkan kartu di tengah halaman dan
        menyesuaikan lebarnya secara responsif. Kartu memiliki bayangan dan
        tanpa border untuk tampilan yang lebih bersih. Overflow disembunyikan
        agar gambar dan konten tidak keluar dari area kartu.
    -->
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 overflow-hidden mb-4">
                <div class="row g-0">
                    @if($gambarUrl)
                        <!--
                            Gambar ditempatkan di kolom tersendiri agar tampil sebagai
                            thumbnail. Dengan class img-fluid serta penambahan style
                            object-fit: cover, gambar akan memenuhi kolom dan tetap
                            terpotong rapi.
                        -->
                        <div class="col-md-5">
                            <img src="{{ $gambarUrl }}" alt="{{ $barang->judul }}"
                                 class="img-fluid h-100 w-100"
                                 style="object-fit: cover;">
                        </div>
                    @endif
                    <div class="col-md-7">
                        <div class="card-body">
                            <h2 class="card-title mb-3">{{ $barang->judul }}</h2>
                            <p><strong>Kategori:</strong> {{ $barang->kategori->nama ?? '-' }}</p>
                            <p><strong>Lokasi:</strong> {{ $barang->lokasi->nama ?? '-' }}</p>
                            <p><strong>Alamat Pengambilan:</strong> {{ $barang->alamat_pengambilan ?? '-' }}</p>
                            <p><strong>Deskripsi:</strong><br>{!! nl2br(e($barang->deskripsi)) !!}</p>
                            <p><strong>Status:</strong> {{ ucfirst($barang->status) }}</p>

                            @if($barang->status === 'tersedia')
                                <!--
                                    Saat barang masih tersedia, tampilkan tombol klaim via
                                    WhatsApp untuk calon penerima dan tombol "Tandai Sudah
                                    Diambil" untuk pemilik. Pesan WA diisi otomatis dengan
                                    judul barang untuk memudahkan komunikasi.
                                -->
                                <div class="mt-4 d-flex flex-wrap align-items-center gap-2">
                                    <a href="https://wa.me/{{ $barang->no_wa }}?text={{ urlencode('Halo, saya tertarik dengan barang ' . $barang->judul) }}"
                                       target="_blank" class="btn btn-success">
                                        Klaim Barang via WhatsApp
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @php
        // Data Schema.org Product ditambahkan di dalam konten agar mudah
        // dideteksi oleh mesin pencari. Nilai price selalu 0 karena semua
        // barang bersifat gratis. Availability mengikuti status barang.
        $productAvailability = $barang->status === 'tersedia'
            ? 'https://schema.org/InStock'
            : 'https://schema.org/OutOfStock';
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type'    => 'Product',
            'name'     => $barang->judul,
            'description' => strip_tags($barang->deskripsi),
            'image'    => $gambarUrl,
            'sku'      => $barang->slug,
            'brand'    => [
                '@type' => 'Brand',
                'name'  => 'Barang Gratis',
            ],
            'offers'   => [
                '@type'         => 'Offer',
                'priceCurrency' => 'IDR',
                'price'         => 0,
                'availability'  => $productAvailability,
                'url'           => url()->current(),
                'itemCondition' => 'https://schema.org/UsedCondition',
            ],
        ];
    @endphp
    <script type="application/ld+json">
        {!! json_encode($schemaData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
    </script>
@endsection


