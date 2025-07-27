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
        'status',
        'user_id',
        'status_token',
        'no_wa',
        'slug', // pastikan slug juga ada
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    // LOGIKA SLUG UNIK (dalam class Barang)
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
        $slug = $baseSlug;
        $n = 1;

        while (
            static::where('slug', $slug)
                ->when($id, function ($query) use ($id) {
                    $query->where('id', '!=', $id);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $n++;
        }

        return $slug;
    }
}

