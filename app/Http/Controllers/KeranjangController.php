<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // Tampilkan keranjang
    public function index()
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
                              ->with('produk')
                              ->get();
        
        $total = $keranjang->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });
        
        return view('keranjang.index', compact('keranjang', 'total'));
    }
    
    // Tambah ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1'
        ]);
        
        // Cek apakah produk sudah ada di keranjang
        $existing = Keranjang::where('user_id', Auth::id())
                            ->where('produk_id', $request->produk_id)
                            ->first();
        
        if ($existing) {
            // Jika sudah ada, tambah jumlahnya
            $existing->jumlah += $request->jumlah;
            $existing->save();
        } else {
            // Jika belum ada, buat baru
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah
            ]);
        }
        
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    
    // Update jumlah
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $keranjang = Keranjang::where('user_id', Auth::id())
                             ->where('id', $id)
                             ->firstOrFail();
        
        $keranjang->jumlah = $request->jumlah;
        $keranjang->save();
        
        return redirect()->back()->with('success', 'Jumlah produk berhasil diupdate!');
    }
    
    // Hapus dari keranjang
    public function destroy($id)
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
                             ->where('id', $id)
                             ->firstOrFail();
        
        $keranjang->delete();
        
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}