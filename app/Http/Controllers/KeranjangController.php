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
            // Gunakan harga diskon jika ada, jika tidak harga asli (mengakomodasi fitur olif)
            $harga = $item->produk->harga_diskon > 0 ? $item->produk->harga_diskon : $item->produk->harga;
            return $harga * $item->jumlah;
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

        // LOGIKA KRUSIAL: Pilih harga yang benar
        // Jika harga_diskon ada dan tidak nol, gunakan itu. Jika tidak, gunakan harga asli.
        $hargaYangDigunakan = $produk->harga_diskon > 0 ? $produk->harga_diskon : $produk->harga;
        
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
            
            $existing->update([
                'jumlah' => $jumlahBaru,
                'harga' => $hargaYangDigunakan // Update ke harga terbaru (mungkin diskon)
            ]);
        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah,
                'harga' => $hargaYangDigunakan
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

    // Beli Langsung (Bypass Cart)
    public function beliLangsung(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $user_id = Auth::id();
        $produk = Produk::findOrFail($request->produk_id);

        // CEK STOK
        if (!$produk->hasStock($request->jumlah)) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $produk->stok);
        }

        $hargaYangDigunakan = $produk->harga_diskon > 0 ? $produk->harga_diskon : $produk->harga;

        // 1. Uncheck semua item di keranjang user
        Keranjang::where('user_id', $user_id)->update(['checked' => false]);

        // 2. Cek apakah produk sudah ada di keranjang
        $keranjang = Keranjang::where('user_id', $user_id)
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($keranjang) {
            $keranjang->update([
                'jumlah' => $request->jumlah,
                'checked' => true,
                'harga' => $hargaYangDigunakan
            ]);
        } else {
            Keranjang::create([
                'user_id' => $user_id,
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah,
                'checked' => true,
                'harga' => $hargaYangDigunakan
            ]);
        }

        // 3. Arahkan langsung ke halaman checkout
        return redirect()->route('transaksi.checkout');
    }
}