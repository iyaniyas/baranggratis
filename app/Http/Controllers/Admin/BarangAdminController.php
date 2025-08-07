<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangAdminController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->paginate(20);
        return view('admin.barang.index', compact('barangs'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $barang->update($request->only(['judul', 'deskripsi', 'no_wa', 'lokasi_id']));
        // Logika upload gambar jika perlu
        if ($request->hasFile('gambar')) {
            // ...
        }
        return redirect()->route('admin.barang.index', ['token' => $request->input('token')])
            ->with('success', 'Barang berhasil diupdate!');
    }

    public function destroy(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('admin.barang.index', ['token' => $request->input('token')])
            ->with('success', 'Barang berhasil dihapus!');
    }
}

