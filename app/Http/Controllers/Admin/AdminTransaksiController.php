<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('user', 'details');
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $transaksi = $query->latest()->paginate(20);
        
        return view('admin.transaksi.index', compact('transaksi'));
    }
    
    public function show($id)
    {
        $transaksi = Transaksi::with('user', 'details.produk')->findOrFail($id);
        
        return view('admin.transaksi.show', compact('transaksi'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled',
            'resi' => 'nullable|string|max:100',
            'notes' => 'nullable|string'
        ]);
        
        $transaksi = Transaksi::findOrFail($id);
        
        // Jika cancel, kembalikan stok
        if ($request->status == 'cancelled' && $transaksi->status != 'cancelled') {
            foreach ($transaksi->details as $detail) {
                $detail->produk->increaseStock($detail->jumlah);
            }
        }
        
        $transaksi->update([
            'status' => $request->status,
            'resi' => $request->resi,
            'notes' => $request->notes
        ]);
        
        return redirect()->back()->with('success', 'Status transaksi berhasil diupdate!');
    }
}