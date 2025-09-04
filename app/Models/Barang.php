<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori_id',
        'lokasi_id',
        'gambar',
        'alamat_pengambilan',
        'status',
        'user_id',
        'status_token',
        'no_wa',
        'slug',
        'is_request',
        'jumlah_diminta',
        'approved_at'
    ];

    protected $casts = [
        'is_request' => 'boolean',
        'approved_at' => 'datetime',
        'jumlah_diminta' => 'integer'
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    // Scope untuk permintaan barang
    public function scopePermintaan($query)
    {
        return $query->where('is_request', true);
    }

    // Scope untuk barang biasa (bukan permintaan)
    public function scopeBarangBiasa($query)
    {
        return $query->where('is_request', false);
    }

    // Scope untuk permintaan yang sudah disetujui
    public function scopeDisetujui($query)
    {
        return $query->whereNotNull('approved_at');
    }

    // LOGIKA SLUG UNIK
    public static function boot()
    {
        parent::boot();

        static::creating(function ($barang) {
            $barang->slug = static::generateUniqueSlug($barang->judul);
        });

        static::updating(function ($barang) {
            if ($barang->isDirty('judul')) {
                $barang->slug = static::generateUniqueSlug($barang->judul, $barang->id);
            }
        });
    }

    public static function generateUniqueSlug($judul, $id = null)
    {
        $baseSlug = Str::slug($judul . '-' . now()->format('Y-m-d'));
        $slug     = $baseSlug;
        $n        = 1;

        while (
            static::where('slug', $slug)
                  ->when($id, fn($q) => $q->where('id', '!=', $id))
                  ->exists()
        ) {
            $slug = $baseSlug . '-' . $n++;
        }

        return $slug;
    }
}

