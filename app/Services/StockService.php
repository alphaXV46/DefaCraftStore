<?php

namespace App\Services;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Cek apakah semua item di keranjang masih cukup stoknya
     */
    public function validateStock($keranjang): ?string
    {
        foreach ($keranjang as $item) {
            if (!$item->produk->hasStock($item->jumlah)) {
                return 'Stok ' . $item->produk->nama . ' tidak mencukupi!';
            }
        }
        return null;
    }

    /**
     * Kurangi stok — dipanggil HANYA setelah pembayaran settlement
     */
    public function decreaseStock(Transaksi $transaksi): void
    {
        DB::transaction(function () use ($transaksi) {
            foreach ($transaksi->details as $detail) {
                $produk = $detail->produk()->lockForUpdate()->first();
                if ($produk) {
                    $produk->decreaseStock($detail->jumlah);
                }
            }
        });
    }

    /**
     * Kembalikan stok — dipanggil kalau transaksi expire/cancel
     * Hanya kalau stok sudah pernah dikurangi
     */
    public function restoreStock(Transaksi $transaksi): void
    {
        if (!$transaksi->stock_reduced) return;

        DB::transaction(function () use ($transaksi) {
            foreach ($transaksi->details as $detail) {
                $produk = $detail->produk()->lockForUpdate()->first();
                if ($produk) {
                    $produk->increaseStock($detail->jumlah);
                }
            }
        });
    }
}