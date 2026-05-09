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
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $produk = Produk::findOrFail($request->produk_id);
        
        // CEK STOK TERSEDIA
        if (!$produk->hasStock($request->jumlah)) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $produk->stok);
        }
        
        // Cek apakah produk sudah ada di keranjang
        $existing = Keranjang::where('user_id', Auth::id())
                            ->where('produk_id', $request->produk_id)
                            ->first();
        
        if ($existing) {
            // Cek stok untuk jumlah baru
            $jumlahBaru = $existing->jumlah + $request->jumlah;
            if (!$produk->hasStock($jumlahBaru)) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $produk->stok);
            }
            
            $existing->jumlah = $jumlahBaru;
            $existing->save();
        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah
            ]);
        }
        
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
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