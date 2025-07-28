<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;

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
        $lokasis = Lokasi::all();
        return view('barang.create', compact('kategoris', 'lokasis'));
    }

    // Proses simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if($request->hasFile('gambar')){
            $data['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        // Generate status_token (unik untuk update status tanpa login)
        $data['status_token'] = \Str::random(32);

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Tampilkan detail barang
    public function show($slug)
{
    $barang = Barang::with(['kategori', 'lokasi'])->where('slug', $slug)->firstOrFail();
    return view('barang.show', compact('barang'));
}



    // Form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all();
        return view('barang.edit', compact('barang', 'kategoris', 'lokasis'));
    }

    // Proses update barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $barang = Barang::findOrFail($id);
        $data = $request->all();

        if($request->hasFile('gambar')){
            $data['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate!');
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        if($barang->gambar){
            \Storage::disk('public')->delete($barang->gambar);
        }
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }

    // Update status by token (link khusus tanpa login)
    public function updateStatusByToken($token)
    {
        $barang = Barang::where('status_token', $token)->firstOrFail();
        $barang->status = 'diambil';
        $barang->save();

        return redirect()->route('beranda')->with('success', 'Status barang berhasil diupdate!');
    }

    // -------- Tambahan: Detail Kategori dan Lokasi by Slug --------

    // Detail barang berdasarkan kategori (slug)
    public function kategori($slug)
    {
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        $barangs = Barang::where('kategori_id', $kategori->id)->latest()->paginate(10);

        return view('barang.kategori', compact('kategori', 'barangs'));
    }

    // Detail barang berdasarkan lokasi (slug)
    public function lokasi($slug)
    {
        $lokasi = Lokasi::where('slug', $slug)->firstOrFail();
        $barangs = Barang::where('lokasi_id', $lokasi->id)->latest()->paginate(10);

        return view('barang.lokasi', compact('lokasi', 'barangs'));
    }
}

