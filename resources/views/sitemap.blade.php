<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Homepage --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
    </url>

    {{-- Daftar Barang --}}
    @foreach($barangs as $barang)
        <url>
            <loc>{{ url('/barang/' . ($barang->slug ?? $barang->id)) }}</loc>
            <lastmod>{{ $barang->updated_at ? $barang->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
            <priority>0.9</priority>
        </url>
    @endforeach

    {{-- Kategori --}}
    @foreach($kategoris as $kategori)
        <url>
            <loc>{{ url('/kategori/'.$kategori->slug) }}</loc>
            <priority>0.7</priority>
        </url>
    @endforeach

    {{-- Lokasi --}}
    @foreach($lokasis as $lokasi)
        <url>
            <loc>{{ url('/lokasi/'.$lokasi->slug) }}</loc>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>

