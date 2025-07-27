<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;

class SitemapController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all();

        $content = view('sitemap', compact('barangs', 'kategoris', 'lokasis'));

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}

