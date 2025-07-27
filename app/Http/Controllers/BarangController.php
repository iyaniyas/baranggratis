<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Tampilkan daftar barang
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
            // 'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        Barang::create([
            'judul'      => $request->judul,
            'deskripsi'  => $request->deskripsi,
            'kategori_id'=> $request->kategori_id,
            'lokasi_id'  => $request->lokasi_id,
            'diambil'    => 0,
            // 'gambar'  => (nanti kalau pakai upload gambar)
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Tampilkan detail barang
    public function show($id)
    {
        $barang = Barang::with(['kategori', 'lokasi'])->findOrFail($id);
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
        $barang = Barang::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
        ]);

        $barang->update([
            'judul'      => $request->judul,
            'deskripsi'  => $request->deskripsi,
            'kategori_id'=> $request->kategori_id,
            'lokasi_id'  => $request->lokasi_id,
        ]);

        return redirect()->route('barang.show', $barang->id)->with('success', 'Barang berhasil diupdate!');
    }

    // Proses hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }

    // Update status barang (misal: sudah diambil)
    public function updateStatus($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->diambil = 1; // Misal: 1 = sudah diambil
        $barang->save();

        return redirect()->route('barang.index')->with('success', 'Status barang sudah diperbarui!');
    }
}

