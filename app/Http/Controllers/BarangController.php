<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    // List semua barang (halaman index)
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
        $validator = Validator::make($request->all(), [
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'required',
            'kategori_id'  => 'required|exists:kategoris,id',
            'lokasi_id'    => 'required|exists:lokasis,id',
            'gambar'       => 'nullable|image|max:2048',
            'no_wa'        => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['judul', 'deskripsi', 'kategori_id', 'lokasi_id', 'no_wa']);

        // Handle upload gambar (optional)
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('barangs', 'public');
        }

        // Simpan barang
        $barang = Barang::create($data);

        return redirect()->route('barang.show', $barang->slug)
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    // Tampilkan detail barang by SLUG
    public function show($slug)
    {
        $barang = Barang::with(['kategori', 'lokasi'])->where('slug', $slug)->firstOrFail();
        return view('barang.show', compact('barang'));
    }

    // Form edit barang
    public function edit($slug)
    {
        $barang = Barang::where('slug', $slug)->firstOrFail();
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all();
        return view('barang.edit', compact('barang', 'kategoris', 'lokasis'));
    }

    // Update barang
    public function update(Request $request, $slug)
    {
        $barang = Barang::where('slug', $slug)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'required',
            'kategori_id'  => 'required|exists:kategoris,id',
            'lokasi_id'    => 'required|exists:lokasis,id',
            'gambar'       => 'nullable|image|max:2048',
            'no_wa'        => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['judul', 'deskripsi', 'kategori_id', 'lokasi_id', 'no_wa']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('barangs', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.show', $barang->slug)
            ->with('success', 'Barang berhasil diupdate!');
    }

    // Update status barang
    public function updateStatus(Request $request, $slug)
    {
        $barang = Barang::where('slug', $slug)->firstOrFail();
        $barang->status = $request->input('status', 'diambil');
        $barang->save();

        return redirect()->route('barang.show', $barang->slug)
            ->with('success', 'Status barang berhasil diupdate.');
    }

    // Hapus barang
    public function destroy(Request $request, $slug)
    {
        $barang = Barang::where('slug', $slug)->firstOrFail();
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    // Update status by token (link khusus tanpa login)
    public function updateStatusByToken($token)
    {
        $barang = Barang::where('status_token', $token)->firstOrFail();
        $barang->status = 'diambil';
        $barang->save();

        return redirect()->route('beranda')->with('success', 'Status barang berhasil diupdate!');
    }
}

