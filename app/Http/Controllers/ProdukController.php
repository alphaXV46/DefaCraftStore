<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Halaman semua produk
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        
        // Hanya ambil produk yang statusnya published
        $query = Produk::where('status', 'published'); 
        
        // Filter kategori jika ada
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }
        
        // Search jika ada
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        }
        
        $produk = $query->get();
        
        return view('produk.index', compact('produk', 'kategori'));
    }
    
    // Halaman detail produk
    public function show($id)
    {
        $produk = Produk::where('status', 'published')->findOrFail($id);
        
        $produkTerkait = Produk::where('kategori_id', $produk->kategori_id)
                            ->where('status', 'published')
                            ->where('id', '!=', $produk->id)
                            ->limit(4)
                            ->get();
        
        return view('produk.show', compact('produk', 'produkTerkait'));
    }
}