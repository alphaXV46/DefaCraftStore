<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProdukController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        $produk = Produk::latest()->get();
        return view('admin.produk.index', compact('produk'));
    }
    
    // Form tambah produk
    public function create()
    {
        return view('admin.produk.create');
    }
    
    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $data = $request->all();
        
        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk'), $filename);
            $data['gambar'] = $filename;
        }
        
        Produk::create($data);
        
        return redirect()->route('admin.produk.index')
                       ->with('success', 'Produk berhasil ditambahkan!');
    }
    
    // Form edit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }
    
    // Update produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $produk = Produk::findOrFail($id);
        $data = $request->all();
        
        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($produk->gambar && file_exists(public_path('images/produk/' . $produk->gambar))) {
                unlink(public_path('images/produk/' . $produk->gambar));
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk'), $filename);
            $data['gambar'] = $filename;
        }
        
        $produk->update($data);
        
        return redirect()->route('admin.produk.index')
                       ->with('success', 'Produk berhasil diupdate!');
    }
    
    // Hapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Hapus gambar
        if ($produk->gambar && file_exists(public_path('images/produk/' . $produk->gambar))) {
            unlink(public_path('images/produk/' . $produk->gambar));
        }
        
        $produk->delete();
        
        return redirect()->route('admin.produk.index')
                       ->with('success', 'Produk berhasil dihapus!');
    }
}