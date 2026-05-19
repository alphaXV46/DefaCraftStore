<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|unique:kategori,nama']);
        
        Kategori::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambah!');
    }

  public function destroy($id)
{
    $kategori = \App\Models\Kategori::findOrFail($id);
    
    // Cek apakah ada produk yang masih pakai kategori ini
    $produkTerkait = \App\Models\Produk::where('kategori_id', $id)->count();
    
    if ($produkTerkait > 0) {
        return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh ' . $produkTerkait . ' produk.');
    }

    $kategori->delete();
    return back()->with('success', 'Kategori berhasil dihapus!');
}
}