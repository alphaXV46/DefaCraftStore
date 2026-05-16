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

    if ($request->has('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    $produk = $query->get();
    return view('produk.index', compact('produk', 'kategori'));
}
    
    // Halaman detail produk
   public function show($id)
{
    $produk = Produk::findOrFail($id);
    
    // Ambil produk lain sebagai 'Produk Terkait'
    $produkTerkait = Produk::where('kategori_id', $produk->kategori_id)
                            ->where('id', '!=', $id)
                            ->limit(4)
                            ->get();

    return view('produk.show', compact('produk', 'produkTerkait'));
}
}