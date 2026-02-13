@extends('layouts.app')

@section('title', 'Kelola Transaksi - Admin')

@section('content')
<div class="container py-5" style="padding-bottom: 400px !important;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">📊 Kelola Transaksi</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            ← Dashboard
        </a>
    </div>
    
    <!-- Filter Status -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.transaksi.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Filter Status:</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Menunggu Pembayaran
                        </option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>
                            Dibayar (Perlu Konfirmasi)
                        </option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                            Diproses
                        </option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>
                            Dikirim
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Tabel Transaksi -->
    <div class="card shadow">
        <div class="card-body">
            @if($transaksi->isEmpty())
                <div class="text-center py-5">
                    <span class="display-3">📦</span>
                    <h4 class="mt-3">Belum Ada Transaksi</h4>
                    <p class="text-muted">Transaksi akan muncul di sini</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Bukti Bayar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $order)
                                <tr>
                                    <!-- ID -->
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    
                                    <!-- Tanggal -->
                                    <td>
                                        {{ $order->created_at->format('d M Y') }}<br>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                    
                                    <!-- Customer -->
                                    <td>
                                        <strong>{{ $order->nama_pembeli }}</strong><br>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </td>
                                    
                                    <!-- Total -->
                                    <td>
                                        <strong class="text-primary">
                                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                    
                                    <!-- Metode -->
                                    <td>
                                        @if($order->metode_pembayaran == 'QRIS')
                                            <span class="badge bg-info">📱 QRIS</span>
                                        @else
                                            <span class="badge bg-success">💵 COD</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Status -->
                                    <td>
                                        {!! $order->getStatusBadge() !!}
                                    </td>
                                    
                                    <!-- Bukti Bayar -->
                                    <td class="text-center">
                                        @if($order->bukti_bayar)
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#buktiModal{{ $order->id }}">
                                                👁️ Lihat
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Aksi -->
                                    <td class="text-center">
                                        <a href="{{ route('admin.transaksi.show', $order->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                
                                <!-- Modal Bukti Bayar -->
                                @if($order->bukti_bayar)
                                <div class="modal fade" id="buktiModal{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Bukti Pembayaran - Order #{{ $order->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('images/bukti_bayar/' . $order->bukti_bayar) }}" 
                                                     class="img-fluid" alt="Bukti Bayar">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-3">
                    {{ $transaksi->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection