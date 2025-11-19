<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // Halaman checkout
    public function checkout()
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
                              ->with('produk')
                              ->get();
        
        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.index')
                           ->with('error', 'Keranjang Anda kosong!');
        }
        
        $total = $keranjang->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });
        
        return view('transaksi.checkout', compact('keranjang', 'total'));
    }
    
    // Proses checkout
    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:100',
            'alamat' => 'required|string',
            'nomor_wa' => 'required|string|max:20',
            'metode_pembayaran' => 'required|in:QRIS,COD'
        ]);
        
        $keranjang = Keranjang::where('user_id', Auth::id())
                              ->with('produk')
                              ->get();
        
        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.index')
                           ->with('error', 'Keranjang Anda kosong!');
        }
        
        $total = $keranjang->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });
        
        // Simpan transaksi menggunakan transaction DB
        DB::transaction(function() use ($request, $total) {
            // Buat transaksi
            Transaksi::create([
                'user_id' => Auth::id(),
                'total_harga' => $total,
                'metode_pembayaran' => $request->metode_pembayaran,
                'nama_pembeli' => $request->nama_pembeli,
                'alamat' => $request->alamat,
                'nomor_wa' => $request->nomor_wa
            ]);
            
            // Kosongkan keranjang
            Keranjang::where('user_id', Auth::id())->delete();
        });
        
        return redirect()->route('transaksi.success');
    }
    
    // Halaman sukses
    public function success()
    {
        return view('transaksi.success');
    }
}