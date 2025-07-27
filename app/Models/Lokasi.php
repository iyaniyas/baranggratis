<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- ini WAJIB ADA!
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];
}

