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
    /**
     * Normalisasi nomor WA menjadi 628xxxxxxxxxx (digits only).
     * Menerima variasi input: 0812..., +62812..., 62812..., spasi/tanda baca.
     */
    private function normalizeWa(?string $raw): string
    {
        $raw = $raw ?? '';
        // Ambil digit saja
        $digits = preg_replace('/\D+/', '', $raw);

        // Jika mulai 62 -> buang 62 di depan; jika mulai 0 -> buang nol di depan
        if (Str::startsWith($digits, '62')) {
            $digits = substr($digits, 2);
        } elseif (Str::startsWith($digits, '0')) {
            $digits = ltrim($digits, '0');
        }

        // Pakukan prefiks 62
        return '62' . $digits;
    }

    // =============================
    // LIST & FORM
    // =============================

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

    // =============================
    // CREATE (STORE)
    // =============================

    // Proses simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'judul'               => 'required|string|max:255',
            'deskripsi'           => 'required',
            'kategori_id'         => 'required|exists:kategoris,id',
            'lokasi_id'           => 'required|exists:lokasis,id',
            'gambar'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10480',
            'alamat_pengambilan'  => 'nullable|string|max:255',
            // Terima format fleksibel: 08xxx / 62xxx / +62xxx (min 9 digit efektif)
            'no_wa'               => ['required', 'string', 'min:9', 'max:20'],
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

        // Normalisasi nomor WA -> 628xxxxxxxxxx
        $data['no_wa'] = $this->normalizeWa($data['no_wa']);

        // Validasi tambahan setelah normalisasi (total 62 + 8-13 digit)
        if (!preg_match('/^62\d{8,13}$/', $data['no_wa'])) {
            return back()
                ->withErrors(['no_wa' => 'Nomor WhatsApp tidak valid. Gunakan format 08xxxxxxxx atau 62xxxxxxxx.'])
                ->withInput();
        }

        // Tambahkan status & token
        $data['status']       = 'tersedia';
        $data['status_token'] = Str::random(32);

        // Proses upload & konversi gambar ke WebP (ringan)
        if ($request->hasFile('gambar')) {
            $imgFile  = $request->file('gambar');
            $filename = Str::random(16) . '.webp';

            // Baca dan skala proporsional (lebar maks 300px agar hemat)
            $image = Image::read($imgFile)->scaleDown(width: 300);

            // Encode ke WebP (kualitas 50 = kecil tapi masih layak)
            $encoded = $image->encodeByExtension('webp', quality: 50);

            // Pastikan folder 'public/barang/webp' ada
            if (!Storage::exists('public/barang/webp')) {
                Storage::makeDirectory('public/barang/webp');
            }

            // Simpan file WebP
            Storage::disk('public')->put('barang/webp/' . $filename, $encoded);

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

    // =============================
    // READ (SHOW)
    // =============================

    // Tampilkan detail barang
    public function show($slug)
    {
        $barang = Barang::with(['kategori', 'lokasi'])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Barang::where('lokasi_id', $barang->lokasi_id)
            ->where('id', '<>', $barang->id)
            ->latest()
            ->take(6)
            ->get();

        return view('barang.show', compact('barang', 'related'));
    }

    // =============================
    // UPDATE (EDIT/UPDATE)
    // =============================

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
            'gambar'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'alamat_pengambilan' => 'nullable|string|max:255',
            // Boleh kosong (jika tidak diubah), tapi jika ada harus valid secara dasar
            'no_wa'              => ['nullable', 'string', 'min:9', 'max:20'],
        ]);

        $barang = Barang::findOrFail($id);

        $data = $request->only([
            'judul', 'deskripsi', 'kategori_id', 'lokasi_id', 'alamat_pengambilan', 'no_wa'
        ]);

        // Jika nomor WA dikirim, normalisasi & validasi
        if (!empty($data['no_wa'])) {
            $data['no_wa'] = $this->normalizeWa($data['no_wa']);
            if (!preg_match('/^62\d{8,13}$/', $data['no_wa'])) {
                return back()
                    ->withErrors(['no_wa' => 'Nomor WhatsApp tidak valid.'])
                    ->withInput();
            }
        } else {
            // Jangan menimpa nomor lama jika user tidak mengubah
            unset($data['no_wa']);
        }

        // Gambar baru? Hapus lama & simpan baru sebagai WebP
        if ($request->hasFile('gambar')) {
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $imgFile  = $request->file('gambar');
            $filename = Str::random(16) . '.webp';

            $image = Image::read($imgFile)->scaleDown(width: 300);
            $encoded = $image->encodeByExtension('webp', quality: 50);

            if (!Storage::exists('public/barang/webp')) {
                Storage::makeDirectory('public/barang/webp');
            }

            Storage::disk('public')->put('barang/webp/' . $filename, $encoded);
            $data['gambar'] = 'barang/webp/' . $filename;
        }

        $barang->update($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diupdate!');
    }

    // =============================
    // DELETE
    // =============================

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

    // =============================
    // FILTERING BY KATEGORI/LOKASI
    // =============================

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

    // =============================
    // KLAIM VIA TOKEN (LINK TANPA LOGIN)
    // =============================

    // Halaman konfirmasi klaim
    public function confirmClaim($token)
    {
        $barang = Barang::where('status_token', $token)->firstOrFail();
        return view('barang.confirm', compact('barang'));
    }

    // Eksekusi klaim
    public function claim(Request $request, $token)
    {
        $barang = Barang::where('status_token', $token)->firstOrFail();
        $barang->status = 'sudah diambil';
        $barang->save();

        return redirect()
            ->route('barang.show', $barang->slug)
            ->with('success', 'Barang berhasil diklaim!');
    }
}

