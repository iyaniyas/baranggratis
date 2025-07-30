<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    // Tampilkan semua barang
    public function index()
    {
        $barangs = Barang::with(['kategori', 'lokasi'])->latest()->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    // Form tambah barang
    public function create()
    {
        $kategoris = Kategori::all();
        $lokasis   = Lokasi::all();
        return view('barang.create', compact('kategoris', 'lokasis'));
    }

    // Proses simpan barang baru
    public function store(Request $request)
{
    $request->validate([
        'judul'               => 'required|string|max:255',
        'deskripsi'           => 'required',
        'kategori_id'         => 'required|exists:kategoris,id',
        'lokasi_id'           => 'required|exists:lokasis,id',
        'gambar'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'alamat_pengambilan'  => 'nullable|string|max:255',
        'no_wa'               => 'required|digits_between:10,15',
    ]);

    // Ambil input dasar
    $data = $request->only([
        'judul',
        'deskripsi',
        'kategori_id',
        'lokasi_id',
        'alamat_pengambilan',
        'no_wa',
    ]);

    // Tambahkan status dan token
    $data['status']       = 'tersedia';
    $data['status_token'] = Str::random(32);

    // Proses upload & konversi gambar ke WebP
    if ($request->hasFile('gambar')) {
        $imgFile  = $request->file('gambar');
        $filename = Str::random(16) . '.webp';

        // Baca dan skala proporsional (lebar max 1024px)
        $image = Image::read($imgFile)
            ->scaleDown(width: 1024);

        // Encode ke WebP (kualitas 90)
        $encoded = $image->encodeByExtension('webp', quality: 90);

        // Pastikan folder 'public/barang/webp' ada
        if (! Storage::exists('public/barang/webp')) {
            Storage::makeDirectory('public/barang/webp');
        }

        // Simpan file WebP
	Storage::disk('public')->put('barang/webp/'.$filename, $encoded);

        // Simpan path relatif untuk database
        $data['gambar'] = 'barang/webp/' . $filename;
    }

    // Buat record baru
    $barang = Barang::create($data);

    return redirect()->route('barang.index')
                     ->with('success', 'Barang berhasil ditambahkan!')
                     ->with('status_token', $barang->status_token)
                     ->with('no_wa', $barang->no_wa);
}


    // Tampilkan detail barang
    public function show($slug)
    {
        $barang = Barang::with(['kategori', 'lokasi'])
                        ->where('slug', $slug)
                        ->firstOrFail();
        return view('barang.show', compact('barang'));
    }

    // Form edit barang
    public function edit($id)
    {
        $barang    = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        $lokasis   = Lokasi::all();
        return view('barang.edit', compact('barang', 'kategoris', 'lokasis'));
    }

    // Proses update barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'              => 'required|string|max:255',
            'deskripsi'          => 'required',
            'kategori_id'        => 'required|exists:kategoris,id',
            'lokasi_id'          => 'required|exists:lokasis,id',
            'gambar'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alamat_pengambilan' => 'nullable|string|max:255',
        ]);

        $barang = Barang::findOrFail($id);

        $data = $request->only([
            'judul', 'deskripsi', 'kategori_id', 'lokasi_id', 'alamat_pengambilan'
        ]);

        if ($request->hasFile('gambar')) {
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil diupdate!');
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }
        $barang->delete();
        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil dihapus!');
    }

    // Update status by token (link khusus tanpa login)
    public function updateStatusByToken($token)
    {
        $barang = Barang::where('status_token', $token)->firstOrFail();
        $barang->status = 'sudah diambil';
        $barang->save();

        return redirect()
               ->route('barang.show', $barang->slug)
               ->with('success', 'Status barang berhasil di‐update!');
    }

    // Detail barang berdasarkan kategori (slug)
    public function kategori($slug)
    {
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        $barangs  = Barang::where('kategori_id', $kategori->id)->latest()->paginate(10);
        return view('barang.kategori', compact('kategori', 'barangs'));
    }

    // Detail barang berdasarkan lokasi (slug)
    public function lokasi($slug)
    {
        $lokasi  = Lokasi::where('slug', $slug)->firstOrFail();
        $barangs = Barang::where('lokasi_id', $lokasi->id)->latest()->paginate(10);
        return view('barang.lokasi', compact('lokasi', 'barangs'));
    }
}

