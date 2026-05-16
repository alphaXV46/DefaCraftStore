<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // Update method index untuk hitung total hanya yang checked
    public function index()
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
                            ->with('produk')
                            ->get();
        
        // Hitung total hanya yang checked
        $total = $keranjang->where('checked', true)->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });
        
        $checkedCount = $keranjang->where('checked', true)->count();
        
        return view('keranjang.index', compact('keranjang', 'total', 'checkedCount'));
    }
    
   public function store(Request $request)
{
    $produk = Produk::findOrFail($request->produk_id);

    // LOGIKA KRUSIAL: Pilih harga yang benar
    // Jika harga_diskon ada dan tidak nol, gunakan itu. Jika tidak, gunakan harga asli.
    $hargaYangDigunakan = $produk->harga_diskon > 0 ? $produk->harga_diskon : $produk->harga;

    // Cek apakah produk sudah ada di keranjang user
    $keranjang = Keranjang::where('user_id', auth()->id())
                          ->where('produk_id', $produk->id)
                          ->first();

    if ($keranjang) {
        // Jika sudah ada, update jumlahnya
        $keranjang->update([
            'jumlah' => $keranjang->jumlah + $request->jumlah,
            'harga'  => $hargaYangDigunakan // Pastikan harga terupdate ke harga diskon
        ]);
    } else {
        // Jika belum ada, buat baru
        Keranjang::create([
            'user_id'   => auth()->id(),
            'produk_id' => $produk->id,
            'jumlah'    => $request->jumlah,
            'harga'     => $hargaYangDigunakan, // Simpan harga diskon ke table keranjang
        ]);
    }

    return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambah ke keranjang!');
}
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $keranjang = Keranjang::where('user_id', Auth::id())
                             ->where('id', $id)
                             ->firstOrFail();
        
        // CEK STOK
        if (!$keranjang->produk->hasStock($request->jumlah)) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $keranjang->produk->stok);
        }
        
        $keranjang->jumlah = $request->jumlah;
        $keranjang->save();
        
        return redirect()->back()->with('success', 'Jumlah produk berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
                             ->where('id', $id)
                             ->firstOrFail();
        
        $keranjang->delete();
        
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
    // Toggle checked status
    public function toggleCheck(Request $request, $id)
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
                            ->where('id', $id)
                            ->firstOrFail();
        
        $keranjang->checked = !$keranjang->checked;
        $keranjang->save();
        
        return response()->json([
            'success' => true,
            'checked' => $keranjang->checked
        ]);
    }
}