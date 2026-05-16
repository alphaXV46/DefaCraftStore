<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori; // Sudah benar
use Illuminate\Http\Request;

class AdminProdukController extends Controller
{
    // 1. TAMPILKAN SEMUA PRODUK (FIXED)
   public function index(Request $request)
{
    $kategori = Kategori::all();
    $query = Produk::query();

    // Filter Berdasarkan Nama (Search)
    if ($request->has('search') && $request->search != '') {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // Filter Berdasarkan Kategori
    if ($request->has('kategori') && $request->kategori != '') {
        $query->where('kategori_id', $request->kategori);
    }

    $produk = $query->get();

    return view('admin.produk.index', compact('produk', 'kategori'));
}
    
    // 2. FORM TAMBAH PRODUK
    public function create()
    {
        $kategori = Kategori::all(); 
        return view('admin.produk.create', compact('kategori'));
    }
    
    // 3. SIMPAN PRODUK BARU (FIXED)
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama'         => 'required|max:255',
            'kategori_id'  => 'required|exists:kategoris,id',
            'harga'        => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric|min:0|lt:harga',
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'required',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'kategori_id.required' => 'Silakan pilih kategori produk.',
            'kategori_id.exists'   => 'Kategori tidak valid.',
            'harga_diskon.lt'      => 'Harga diskon harus lebih murah dari harga asli!',
        ]);

        $data = $request->all();

        // Handle Status (Draf/Published)
        $data['status'] = $request->has('status') ? 'published' : 'draft';

        // Handle Gambar (Cropper.js atau Upload Biasa)
        if ($request->filled('cropped_image')) {
            $imgData = $request->cropped_image;

            if (preg_match('/^data:image\/(\w+);base64,/', $imgData, $type)) {
                $imgData = substr($imgData, strpos($imgData, ',') + 1);
                $imgData = base64_decode($imgData);

                $nama_gambar = 'produk_' . time() . '.jpg';
                $path = public_path('uploads/produk/');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                file_put_contents($path . $nama_gambar, $imgData);
                $data['gambar'] = $nama_gambar;
            }
        } elseif ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $nama_gambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $nama_gambar);
            $data['gambar'] = $nama_gambar;
        }

        // Simpan ke Database
        Produk::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil disimpan!');
    }
    
    // 4. HAPUS PRODUK
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Hapus gambar dari folder agar storage tidak penuh
        if ($produk->gambar && file_exists(public_path('uploads/produk/' . $produk->gambar))) {
            unlink(public_path('uploads/produk/' . $produk->gambar));
        }
        
        $produk->delete();
        
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    // 5. TOGGLE STATUS (DRAF/PUBLISHED)
    public function toggleStatus($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->status = ($produk->status == 'published') ? 'draft' : 'published';
        $produk->save();

        return back()->with('success', 'Status produk berhasil diubah!');
    }
}