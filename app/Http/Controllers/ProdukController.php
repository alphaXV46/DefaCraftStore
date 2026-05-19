<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Halaman semua produk
    public function index(Request $request)
    {
        $query = Produk::query();
        
        // Filter kategori jika ada
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }
        
        // Search jika ada
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        }
        
        $produk = $query->get();
        
        return view('produk.index', compact('produk'));
    }
    
    // Halaman detail produk
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        
        $produkTerkait = Produk::where('kategori', $produk->kategori)
                            ->where('id', '!=', $produk->id)
                            ->limit(4)
                            ->get();
        
        return view('produk.show', compact('produk', 'produkTerkait'));
    }
}