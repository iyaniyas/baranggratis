<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BarangController;

Route::get('/', function (Request $request) {
    $query = \App\Models\Barang::with(['kategori', 'lokasi']);

    if ($request->filled('q')) {
        $query->where(function($q2) use ($request) {
            $q2->where('judul', 'like', '%' . $request->q . '%')
               ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
        });
    }
    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }
    if ($request->filled('lokasi')) {
        $query->where('lokasi_id', $request->lokasi);
    }

    $barangs = $query->latest()->paginate(10);
    $kategoris = \App\Models\Kategori::all();
    $lokasis = \App\Models\Lokasi::all();

    return view('beranda', [
        'barangs'      => $barangs,
        'kategoriList' => $kategoris,
        'lokasiList'   => $lokasis,
    ]);
})->name('beranda');

Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::post('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::post('/barang/{id}/status', [BarangController::class, 'updateStatus'])->name('barang.updateStatus');
Route::post('/barang/{id}/delete', [BarangController::class, 'destroy'])->name('barang.destroy');

Route::get('/dashboard', function () {
    return view('dashboard');
});
