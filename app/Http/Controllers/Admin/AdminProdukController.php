<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class AdminProdukController extends Controller
{
    // Tampilkan semua produk
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

        $produk = $query->latest()->get();

        return view('admin.produk.index', compact('produk', 'kategori'));
    }
    
    // Form tambah produk
    public function create()
    {
        $kategori = Kategori::all(); 
        return view('admin.produk.create', compact('kategori'));
    }
    
    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:100',
            'kategori_id'  => 'required|exists:kategoris,id',
            'harga'        => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric|min:0|lt:harga',
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'kategori_id.required' => 'Silakan pilih kategori produk.',
            'kategori_id.exists'   => 'Kategori tidak valid.',
            'harga_diskon.lt'      => 'Harga diskon harus lebih murah dari harga asli!',
            'gambar.image'         => 'File harus berupa gambar.',
            'gambar.mimes'         => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar.max'           => 'Ukuran gambar maksimal 2MB.'
        ]);
        
        $data = $request->all();
        
        // Handle Status (Draf/Published)
        $data['status'] = $request->has('status') ? 'published' : 'draft';
        
        // Upload gambar & kompresi WebP terintegrasi dengan Cropper.js & Jurus Bunglon
        if ($request->filled('cropped_image')) {
            $imgData = $request->cropped_image;

            if (preg_match('/^data:image\/(\w+);base64,/', $imgData, $type)) {
                $imgData = substr($imgData, strpos($imgData, ',') + 1);
                $imgData = base64_decode($imgData);

                $filename = 'produk_' . time() . '.webp';
                
                $manager = new ImageManager(new Driver());
                $image = $manager->decode($imgData);
                $image->scaleDown(width: 1000);

                $destinationPath = app()->environment('local') 
                    ? public_path('images/produk/' . $filename)
                    : base_path('../public_html/images/produk/' . $filename);

                if (app()->environment('local') && !file_exists(public_path('images/produk'))) {
                    mkdir(public_path('images/produk'), 0777, true);
                }

                $image->encodeUsingFormat(Format::WEBP, quality: 80)->save($destinationPath);
                $data['gambar'] = $filename;
            }
        } elseif ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            
            $manager = new ImageManager(new Driver());
            $image = $manager->decode($file);
            $image->scaleDown(width: 1000);
            
            $destinationPath = app()->environment('local') 
                ? public_path('images/produk/' . $filename)
                : base_path('../public_html/images/produk/' . $filename);

            if (app()->environment('local') && !file_exists(public_path('images/produk'))) {
                mkdir(public_path('images/produk'), 0777, true);
            }

            $image->encodeUsingFormat(Format::WEBP, quality: 80)->save($destinationPath);
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
        $kategori = Kategori::all();
        return view('admin.produk.edit', compact('produk', 'kategori'));
    }
    
    // Update produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'         => 'required|string|max:100',
            'kategori_id'  => 'required|exists:kategoris,id',
            'harga'        => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric|min:0|lt:harga',
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'kategori_id.required' => 'Silakan pilih kategori produk.',
            'kategori_id.exists'   => 'Kategori tidak valid.',
            'harga_diskon.lt'      => 'Harga diskon harus lebih murah dari harga asli!',
            'gambar.image'         => 'File harus berupa gambar.',
            'gambar.mimes'         => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar.max'           => 'Ukuran gambar maksimal 2MB.'
        ]);
        
        $produk = Produk::findOrFail($id);
        $data = $request->all();
        
        // Handle Status (Draf/Published) - Opsional jika edit form punya toggle, jika tidak ambil dari existing
        if ($request->has('status')) {
            $data['status'] = $request->status == 'on' || $request->status == 'published' ? 'published' : 'draft';
        }
        
        // Upload gambar baru jika ada
        if ($request->filled('cropped_image') || $request->hasFile('gambar')) {
            // Hapus gambar lama
            $oldPath = app()->environment('local') 
                ? public_path('images/produk/' . $produk->gambar)
                : base_path('../public_html/images/produk/' . $produk->gambar);

            if ($produk->gambar && file_exists($oldPath)) {
                unlink($oldPath);
            }
            
            if ($request->filled('cropped_image')) {
                $imgData = $request->cropped_image;
                if (preg_match('/^data:image\/(\w+);base64,/', $imgData, $type)) {
                    $imgData = substr($imgData, strpos($imgData, ',') + 1);
                    $imgData = base64_decode($imgData);

                    $filename = 'produk_' . time() . '.webp';
                    
                    $manager = new ImageManager(new Driver());
                    $image = $manager->decode($imgData);
                    $image->scaleDown(width: 1000);

                    $destinationPath = app()->environment('local') 
                        ? public_path('images/produk/' . $filename)
                        : base_path('../public_html/images/produk/' . $filename);

                    $image->encodeUsingFormat(Format::WEBP, quality: 80)->save($destinationPath);
                    $data['gambar'] = $filename;
                }
            } elseif ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
                
                $manager = new ImageManager(new Driver());
                $image = $manager->decode($file);
                $image->scaleDown(width: 1000);
                
                $destinationPath = app()->environment('local') 
                    ? public_path('images/produk/' . $filename)
                    : base_path('../public_html/images/produk/' . $filename);

                $image->encodeUsingFormat(Format::WEBP, quality: 80)->save($destinationPath);
                $data['gambar'] = $filename;
            }
        }
        
        $produk->update($data);
        
        return redirect()->route('admin.produk.index')
                       ->with('success', 'Produk berhasil diupdate!');
    }
    
    // Hapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Hapus gambar dengan Jurus Bunglon
        $filePath = app()->environment('local') 
            ? public_path('images/produk/' . $produk->gambar)
            : base_path('../public_html/images/produk/' . $produk->gambar);

        if ($produk->gambar && file_exists($filePath)) {
            unlink($filePath);
        }
        
        // Hapus juga untuk path 'uploads/produk/' sebagai fallback jika gambar tersimpan dari versi olif lama
        $fallbackPath = public_path('uploads/produk/' . $produk->gambar);
        if ($produk->gambar && file_exists($fallbackPath)) {
            unlink($fallbackPath);
        }
        
        $produk->delete();
        
        return redirect()->route('admin.produk.index')
                       ->with('success', 'Produk berhasil dihapus!');
    }

    // TOGGLE STATUS (DRAF/PUBLISHED)
    public function toggleStatus($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->status = ($produk->status == 'published') ? 'draft' : 'published';
        $produk->save();

        return back()->with('success', 'Status produk berhasil diubah!');
    }
}