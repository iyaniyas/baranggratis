<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BarangAdminController;

//admin
Route::prefix('admin')->group(function () {
    Route::get('/barang', function(Request $request) {
        if ($request->input('token') !== '9)mJ.7Ye3ZDgSri') abort(403, 'Unauthorized');
        return app(BarangAdminController::class)->index();
    })->name('admin.barang.index');

    Route::get('/barang/{id}/edit', function(Request $request, $id) {
        if ($request->input('token') !== '9)mJ.7Ye3ZDgSri') abort(403, 'Unauthorized');
        return app(BarangAdminController::class)->edit($id);
    })->name('admin.barang.edit');

    Route::put('/barang/{id}', function(Request $request, $id) {
        if ($request->input('token') !== '9)mJ.7Ye3ZDgSri') abort(403, 'Unauthorized');
        return app(BarangAdminController::class)->update($request, $id);
    })->name('admin.barang.update');

    Route::delete('/barang/{id}', function(Request $request, $id) {
        if ($request->input('token') !== '9)mJ.7Ye3ZDgSri') abort(403, 'Unauthorized');
        return app(BarangAdminController::class)->destroy($id);
    })->name('admin.barang.destroy');
});

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
    // cari id berdasarkan slug sebelum memfilter
    $lokasi = \App\Models\Lokasi::where('slug', $request->lokasi)->first();
    if ($lokasi) {
        $query->where('lokasi_id', $lokasi->id);
    }
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

Route::get('/test-image', function() {
    return \Intervention\Image\Facades\Image::canvas(100, 100, '#ff0000')->response('png');
});

//dukungan
Route::view('/dukungan', 'static.dukungan')->name('dukungan');
// Barang - pakai slug
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');

//kategori pakai slug
Route::get('/kategori/{slug}', [BarangController::class, 'kategori'])->name('kategori.show');
//lokasi pakai slug
Route::get('/lokasi/{slug}', [BarangController::class, 'lokasi'])->name('lokasi.show');

// Detail, edit, update, status, delete pakai {slug}
Route::get('/barang/{slug}', [BarangController::class, 'show'])->name('barang.show');
//Route::get('/barang/{slug}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::post('/barang/{slug}', [BarangController::class, 'update'])->name('barang.update');
Route::post('/barang/{slug}/status', [BarangController::class, 'updateStatus'])->name('barang.updateStatus');
//Route::post('/barang/{slug}/delete', [BarangController::class, 'destroy'])->name('barang.destroy');

// Update status by token (khusus)
//Route::get('/barang/update-status/{token}', [BarangController::class, 'updateStatusByToken'])->name('barang.updateStatusByToken');

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

//routes confirmasi
Route::get('/claim/{token}', [BarangController::class, 'confirmClaim'])
     ->name('barang.confirm');
Route::post('/claim/{token}', [BarangController::class, 'claim'])
     ->name('barang.claim');
//routes static page
Route::view('/tentang-kami', 'static.tentang');
Route::view('/pedoman', 'static.pedoman');
Route::view('/keanekaragaman', 'static.keanekaragaman');
Route::view('/keamanan', 'static.keamanan');
Route::view('/tos', 'static.tos');

