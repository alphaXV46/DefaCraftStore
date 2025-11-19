@extends('layouts.app')

@section('title', 'Admin Dashboard - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">🔧 Admin Dashboard</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            ← Kembali ke Home
        </a>
    </div>
    
    <!-- Statistik Cards -->
    <div class="row g-4 mb-5">
        <!-- Total Produk -->
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Produk</h6>
                            <h2 class="fw-bold mb-0">{{ $totalProduk }}</h2>
                        </div>
                        <span class="display-4">📦</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Transaksi -->
        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Transaksi</h6>
                            <h2 class="fw-bold mb-0">{{ $totalTransaksi }}</h2>
                        </div>
                        <span class="display-4">🛒</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total User -->
        <div class="col-md-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total User</h6>
                            <h2 class="fw-bold mb-0">{{ $totalUser }}</h2>
                        </div>
                        <span class="display-4">👥</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Pendapatan -->
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Pendapatan</h6>
                            <h5 class="fw-bold mb-0">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </h5>
                        </div>
                        <span class="display-4">💰</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Menu Admin -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <a href="{{ route('admin.produk.index') }}" class="text-decoration-none">
                <div class="card shadow hover-card">
                    <div class="card-body text-center py-5">
                        <span class="display-3 mb-3">📦</span>
                        <h4 class="fw-bold">Kelola Produk</h4>
                        <p class="text-muted mb-0">CRUD Produk (Tambah, Edit, Hapus)</p>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <span class="display-3 mb-3">📊</span>
                    <h4 class="fw-bold">Laporan Transaksi</h4>
                    <p class="text-muted mb-0">Coming Soon</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Transaksi Terbaru -->
    <div class="card shadow">
        <div class="card-body">
            <h5 class="fw-bold mb-4">📋 Transaksi Terbaru</h5>
            
            @if($transaksi->isEmpty())
                <p class="text-muted text-center">Belum ada transaksi.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama Pembeli</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $item)
                                <tr>
                                    <td>#{{ $item->id }}</td>
                                    <td>{{ $item->nama_pembeli }}</td>
                                    <td class="fw-bold text-primary">
                                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $item->metode_pembayaran == 'QRIS' ? 'bg-info' : 'bg-success' }}">
                                            {{ $item->metode_pembayaran }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-10px);
}
</style>
@endsection