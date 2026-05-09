<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 10 produk untuk ditampilkan di home, pilih kolom yang diperlukan saja
        $produk = Produk::select('id', 'nama', 'harga', 'gambar', 'kategori')
            ->limit(10)
            ->get();
        
        return view('home', compact('produk'));
    }
}