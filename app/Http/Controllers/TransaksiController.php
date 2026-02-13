<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function checkout()
{
    // Ambil hanya yang checked
    $keranjang = Keranjang::where('user_id', Auth::id())
                          ->where('checked', true)
                          ->with('produk')
                          ->get();
    
    if ($keranjang->isEmpty()) {
        return redirect()->route('keranjang.index')
                       ->with('error', 'Pilih minimal 1 produk untuk checkout!');
    }
    
    // CEK STOK SEMUA PRODUK yang checked
    foreach ($keranjang as $item) {
        if (!$item->produk->hasStock($item->jumlah)) {
            return redirect()->route('keranjang.index')
                           ->with('error', 'Stok ' . $item->produk->nama . ' tidak mencukupi! Stok tersedia: ' . $item->produk->stok);
        }
    }
    
    $total = $keranjang->sum(function($item) {
        return $item->produk->harga * $item->jumlah;
    });
    
    return view('transaksi.checkout', compact('keranjang', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:100',
            'alamat' => 'required|string',
            'nomor_wa' => 'required|string|max:20',
            'metode_pembayaran' => 'required|in:QRIS,COD'
        ]);
        
        // Ambil hanya yang checked
        $keranjang = Keranjang::where('user_id', Auth::id())
                            ->where('checked', true)
                            ->with('produk')
                            ->get();
        
        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.index')
                        ->with('error', 'Pilih minimal 1 produk untuk checkout!');
        }
        
        // CEK STOK LAGI (double check)
        foreach ($keranjang as $item) {
            if (!$item->produk->hasStock($item->jumlah)) {
                return redirect()->route('keranjang.index')
                            ->with('error', 'Stok ' . $item->produk->nama . ' tidak mencukupi!');
            }
        }
        
        $total = $keranjang->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });
        
        // Tambah ongkir kalau < 200rb
        if ($total < 200000) {
            $total += 15000;
        }
        
        // Simpan transaksi menggunakan DB transaction
        DB::transaction(function() use ($request, $total, $keranjang) {
            // 1. Buat transaksi
            $transaksi = Transaksi::create([
                'user_id' => Auth::id(),
                'total_harga' => $total,
                'metode_pembayaran' => $request->metode_pembayaran,
                'nama_pembeli' => $request->nama_pembeli,
                'alamat' => $request->alamat,
                'nomor_wa' => $request->nomor_wa,
                'status' => 'pending'
            ]);
            
            // 2. Simpan detail transaksi & kurangi stok (hanya yang checked)
            foreach ($keranjang as $item) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item->produk_id,
                    'nama_produk' => $item->produk->nama,
                    'harga' => $item->produk->harga,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->produk->harga * $item->jumlah
                ]);
                
                // KURANGI STOK
                $item->produk->decreaseStock($item->jumlah);
            }
            
            // 3. Hapus hanya item yang checked dari keranjang
            Keranjang::where('user_id', Auth::id())
                    ->where('checked', true)
                    ->delete();
        });
        
        return redirect()->route('transaksi.success');
    }
    
    public function success()
    {
        return view('transaksi.success');
    }
    
    // HALAMAN RIWAYAT PESANAN USER
    public function riwayat()
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
                              ->with('details.produk')
                              ->latest()
                              ->get();
        
        return view('transaksi.riwayat', compact('transaksi'));
    }
    
    // UPLOAD BUKTI BAYAR
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $transaksi = Transaksi::where('user_id', Auth::id())
                              ->where('id', $id)
                              ->firstOrFail();
        
        // Cek status
        if ($transaksi->status != 'pending') {
            return redirect()->back()->with('error', 'Transaksi ini tidak dapat diupload bukti bayar!');
        }
        
        // Upload file
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = 'bukti_' . $transaksi->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/bukti_bayar'), $filename);
            
            // Hapus file lama jika ada
            if ($transaksi->bukti_bayar && file_exists(public_path('images/bukti_bayar/' . $transaksi->bukti_bayar))) {
                unlink(public_path('images/bukti_bayar/' . $transaksi->bukti_bayar));
            }
            
            $transaksi->bukti_bayar = $filename;
            $transaksi->save();
        }
        
        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi admin.');
    }
}