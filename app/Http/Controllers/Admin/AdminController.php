<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $totalTransaksi = Transaksi::count();
        $totalUser = User::where('role', 'user')->count();
        $totalPendapatan = Transaksi::sum('total_harga');
        $totalWishlist = \App\Models\Wishlist::count(); // TAMBAH INI
        
        $transaksi = Transaksi::with('user')
                            ->latest()
                            ->limit(10)
                            ->get();
                            
        // Hitung status keseluruhan
        $pendingCount = Transaksi::where('status', 'pending')->count();
        $shippedCount = Transaksi::where('status', 'shipped')->count();
        $completedCount = Transaksi::where('status', 'completed')->count();
        $cancelledCount = Transaksi::where('status', 'cancelled')->count();
        
        $totalAll = max($totalTransaksi, 1);
        $statusData = [
            ['label' => 'Menunggu', 'count' => $pendingCount, 'color' => '#F59E0B'],
            ['label' => 'Dikirim', 'count' => $shippedCount, 'color' => '#3B82F6'],
            ['label' => 'Selesai', 'count' => $completedCount, 'color' => '#10B981'],
            ['label' => 'Batal', 'count' => $cancelledCount, 'color' => '#EF4444'],
        ];

        // Hitung metode pembayaran dari transaksi yang ditampilkan
        $metodeMap = [];
        $metodeRevenue = [];
        foreach($transaksi as $trx) {
            $m = $trx->metode_pembayaran ?: 'Lainnya';
            $metodeMap[$m] = ($metodeMap[$m] ?? 0) + 1;
            $metodeRevenue[$m] = ($metodeRevenue[$m] ?? 0) + $trx->total_harga;
        }

        $barColors = ['linear-gradient(90deg,#667EEA,#764BA2)','linear-gradient(90deg,#10B981,#34D399)','linear-gradient(90deg,#3B82F6,#60A5FA)','linear-gradient(90deg,#F59E0B,#FBBF24)','linear-gradient(90deg,#F472B6,#FB7185)'];
        $barTextColors = ['#fff','#fff','#fff','#333','#fff'];
        $maxMetode = count($metodeMap) > 0 ? max($metodeMap) : 1;
        $metodeIdx = 0;
        
        return view('admin.dashboard', compact(
            'totalProduk',
            'totalTransaksi',
            'totalUser',
            'totalPendapatan',
            'totalWishlist',
            'transaksi',
            'pendingCount',
            'shippedCount',
            'completedCount',
            'cancelledCount',
            'statusData',
            'metodeMap',
            'metodeRevenue',
            'barColors',
            'barTextColors',
            'maxMetode',
            'metodeIdx',
            'totalAll'
        ));
    }
}