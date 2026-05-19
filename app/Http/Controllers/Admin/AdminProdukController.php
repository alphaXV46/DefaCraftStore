<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

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
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.'
        ]);
        
        $data = $request->all();
        
        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            
            // Konversi dan Resize menggunakan Intervention Image
            $manager = new ImageManager(new Driver());
            $image = $manager->decode($file);
            $image->scaleDown(width: 1000);
            $image->encodeUsingFormat(Format::WEBP, quality: 80)->save(public_path('images/produk/' . $filename));
            
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
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.'
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
            $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            
            // Konversi dan Resize menggunakan Intervention Image
            $manager = new ImageManager(new Driver());
            $image = $manager->decode($file);
            $image->scaleDown(width: 1000);
            $image->encodeUsingFormat(Format::WEBP, quality: 80)->save(public_path('images/produk/' . $filename));
            
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