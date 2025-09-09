@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $timestamp = Carbon::parse($barang->created_at)->format('Y-m-d H:i');

    // Ubah judul & deskripsi sesuai jenis barang
    if ($barang->is_request) {
        $judulLengkap   = 'Butuh ' . $barang->judul . ' - ' . $timestamp;
        $deskripsiRingkas = 'Butuh ' . $barang->judul . ' - ' . $timestamp . ' - ' . Str::limit(strip_tags($barang->deskripsi), 150);
    } else {
        $judulLengkap   = $barang->judul . ' Gratis - ' . $timestamp;
        $deskripsiRingkas = $barang->judul . ' Gratis - ' . $timestamp . ' - ' . Str::limit(strip_tags($barang->deskripsi), 150);
    }

    $gambarUrl = $barang->gambar
                    ? asset('storage/' . $barang->gambar)
                    : asset('no-image.jpg');
@endphp

@section('meta_title', $judulLengkap)
@section('meta_description', $deskripsiRingkas)
@section('meta_image', $gambarUrl)
@section('og_type', 'product')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 overflow-hidden mb-4">
                <div class="row g-0">
                    @if($gambarUrl)
                        <div class="col-md-5">
                            <img src="{{ $gambarUrl }}"
                                 alt="{{ $barang->judul }}"
                                 class="img-fluid h-100 w-100"
                                 style="object-fit: cover;"
                                 width="200" height="200" fetchpriority="high">
                        </div>
                    @endif
                    <div class="col-md-7">
                        <div class="card-body">
                            <h2 class="card-title mb-3">
                                {{ $barang->is_request ? 'Butuh ' . $barang->judul : $barang->judul }}
                            </h2>
                            <p><strong>Kategori:</strong> {{ $barang->kategori->nama ?? '-' }}</p>
                            <p><strong>Lokasi:</strong> {{ $barang->lokasi->nama ?? '-' }}</p>
                            <p><strong>Alamat Pengambilan:</strong> {{ $barang->alamat_pengambilan ?? '-' }}</p>
                            <p><strong>Deskripsi:</strong><br>{!! nl2br(e($barang->deskripsi)) !!}</p>
                            <p><strong>Status:</strong> {{ ucfirst($barang->status) }}</p>

                            {{-- Tombol WhatsApp --}}
                            <div class="mt-4 d-flex flex-wrap align-items-center gap-2">
                                @if($barang->is_request == 1)
                                    <a href="https://wa.me/{{ $barang->no_wa }}?text={{ urlencode('Halo, saya ingin menawarkan barang untuk permintaan: ' . $barang->judul) }}"
                                       target="_blank"
                                       class="btn btn-light text-dark">
                                        Tawari Barang via WhatsApp
                                    </a>
                                @elseif($barang->is_request == 0 && $barang->status === 'tersedia')
                                    <a href="https://wa.me/{{ $barang->no_wa }}?text={{ urlencode('Halo, saya tertarik dengan barang ' . $barang->judul) }}"
                                       target="_blank"
                                       class="btn btn-light text-dark">
                                        Klaim Barang via WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			{{-- Related items --}}
			@if(isset($related) && $related->count())
			<div class="mb-4">
				<h3>Barang Lain di sini:</h3>
				<ul class="list-unstyled">
					@foreach($related as $item)
						<li class="mb-1">
							<a href="{{ route('barang.show', $item->slug) }}">
								{{ $item->is_request ? 'Butuh ' . $item->judul : $item->judul }}
							</a>
							<span class="text-muted">— {{ ucfirst($item->status) }}</span>
						</li>
					@endforeach
				</ul>
			</div>
			@endif

        </div>
    </div>
</div>

@php
    $productAvailability = $barang->status === 'tersedia'
        ? 'https://schema.org/InStock'
        : 'https://schema.org/OutOfStock';
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type'    => 'Product',
        'name'     => $barang->is_request ? 'Butuh ' . $barang->judul : $barang->judul,
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

