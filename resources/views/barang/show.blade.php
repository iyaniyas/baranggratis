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

@section('meta')
    <meta name="description" content="{{ $deskripsiRingkas }}">
    <meta property="og:type"        content="article">
    <meta property="og:title"       content="{{ $judulLengkap }}">
    <meta property="og:description" content="{{ $deskripsiRingkas }}">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:image"       content="{{ $gambarUrl }}">
@endsection

@section('content')
<div class="container py-4">
    <!--
        Gunakan grid Bootstrap untuk membuat tampilan detail barang lebih menarik
        dan responsif. Baris ini akan menempatkan kartu di tengah layar dan
        membatasi lebarnya pada layar besar. Kartu dibuat tanpa border dengan
        bayangan halus untuk kesan modern. Overflow tersembunyi memastikan
        gambar dan konten tidak melampaui tepi kartu.
    -->
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 overflow-hidden mb-4">
                <div class="row g-0">
                    @if($gambarUrl)
                        <!--
                            Gambar ditempatkan dalam kolom tersendiri agar terlihat seperti
                            thumbnail. Gambar akan mengisi kolom sepenuhnya dengan tetap
                            mempertahankan rasio dan memotong bagian yang berlebih berkat
                            properti object-fit: cover. Ini menghasilkan tampilan ringkas
                            untuk gambar beresolusi besar.
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
                                    Tampilkan tombol klaim via WhatsApp dan tombol untuk pemilik
                                    menandai barang sudah diambil bila status barang masih
                                    tersedia. Pesan WA dibuat otomatis dengan menyisipkan judul
                                    barang agar memudahkan pemilik mengidentifikasi permintaan.
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
@endsection


