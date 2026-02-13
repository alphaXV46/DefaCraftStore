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
        
        return view('admin.dashboard', compact(
            'totalProduk',
            'totalTransaksi',
            'totalUser',
            'totalPendapatan',
            'totalWishlist', // TAMBAH INI
            'transaksi'
        ));
    }
}