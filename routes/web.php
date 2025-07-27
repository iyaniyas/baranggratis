<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Beranda dengan filter, search, dan paginasi
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

// Barang - pakai slug
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');

// Detail, edit, update, status, delete pakai {slug}
Route::get('/barang/{slug}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/barang/{slug}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::post('/barang/{slug}', [BarangController::class, 'update'])->name('barang.update');
Route::post('/barang/{slug}/status', [BarangController::class, 'updateStatus'])->name('barang.updateStatus');
Route::post('/barang/{slug}/delete', [BarangController::class, 'destroy'])->name('barang.destroy');

// Update status by token (khusus)
Route::get('/barang/update-status/{token}', [BarangController::class, 'updateStatusByToken'])->name('barang.updateStatusByToken');

// Dashboard (static)
Route::get('/dashboard', function () {
    return view('dashboard');
});

// Robots.txt dinamis
Route::get('/robots.txt', function () {
    return response()->view('robots')
        ->header('Content-Type', 'text/plain');
});

// Sitemap.xml dinamis
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

