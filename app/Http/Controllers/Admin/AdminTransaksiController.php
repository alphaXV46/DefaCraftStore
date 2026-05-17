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

        if ($request->filled('status')) {
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
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled,cod_pending',
            'resi'   => 'nullable|string|max:100',
            'notes'  => 'nullable|string|max:500',
        ]);

        $transaksi = Transaksi::with('details.produk')->findOrFail($id);
        $oldStatus = $transaksi->status;
        $newStatus = $request->status;

        // Kembalikan stok hanya kalau:
        // - Status baru = cancelled
        // - Status lama bukan cancelled
        // - Stok sudah pernah dikurangi
        if ($newStatus === 'cancelled'
            && $oldStatus !== 'cancelled'
            && $transaksi->stock_reduced
        ) {
            foreach ($transaksi->details as $detail) {
                if ($detail->produk) {
                    $detail->produk->increaseStock($detail->jumlah);
                }
            }
        }

        // Kurangi stok kalau status berubah ke processing/shipped/completed
        // dan stok belum pernah dikurangi
        if (in_array($newStatus, ['processing', 'shipped', 'completed'])
            && !$transaksi->stock_reduced
            && $oldStatus === 'paid'
        ) {
            foreach ($transaksi->details as $detail) {
                if ($detail->produk) {
                    $detail->produk->decreaseStock($detail->jumlah);
                }
            }
            $transaksi->stock_reduced = true;
        }

        $transaksi->update([
            'status' => $newStatus,
            'resi'   => $request->resi   ?? $transaksi->resi,
            'notes'  => $request->notes  ?? $transaksi->notes,
            'stock_reduced' => $transaksi->stock_reduced,
        ]);

        return redirect()->back()->with('success', 'Status transaksi berhasil diupdate!');
    }
}