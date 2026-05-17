<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Tampilkan wishlist
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                            ->with('produk')
                            ->latest()
                            ->get();
        
        return view('wishlist.index', compact('wishlist'));
    }
    
    // Toggle wishlist (tambah/hapus)
    public function toggle(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id'
        ]);
        
        $existing = Wishlist::where('user_id', Auth::id())
                           ->where('produk_id', $request->produk_id)
                           ->first();
        
        if ($existing) {
            // Hapus dari wishlist
            $existing->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Dihapus dari wishlist'
            ]);
        } else {
            // Tambah ke wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Ditambahkan ke wishlist'
            ]);
        }
    }
    
    // Hapus dari wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                           ->where('id', $id)
                           ->firstOrFail();
        
        $wishlist->delete();
        
        return redirect()->back()->with('success', 'Produk dihapus dari wishlist');
    }
    
    // Pindah dari wishlist ke keranjang
    public function moveToCart($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                           ->where('id', $id)
                           ->with('produk')
                           ->firstOrFail();
        
        // Cek stok
        if (!$wishlist->produk->hasStock(1)) {
            return redirect()->back()->with('error', 'Stok produk tidak tersedia');
        }
        
        // Tambah ke keranjang
        $keranjang = \App\Models\Keranjang::where('user_id', Auth::id())
                                          ->where('produk_id', $wishlist->produk_id)
                                          ->first();
        
        if ($keranjang) {
            $keranjang->jumlah += 1;
            $keranjang->save();
        } else {
            \App\Models\Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $wishlist->produk_id,
                'jumlah' => 1,
                'checked' => true
            ]);
        }
        
        // Hapus dari wishlist
        $wishlist->delete();
        
        return redirect()->route('keranjang.index')->with('success', 'Produk dipindahkan ke keranjang');
    }
}