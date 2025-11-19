@extends('layouts.app')

@section('title', 'Checkout - DefaCraftStore')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">📦 Checkout</h1>
    
    <div class="row">
        <!-- Form Data Pembeli -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Data Pembeli</h5>
                    
                    <form action="{{ route('transaksi.store') }}" method="POST" id="checkoutForm">
                        @csrf
                        
                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pembeli" 
                                   class="form-control @error('nama_pembeli') is-invalid @enderror" 
                                   value="{{ old('nama_pembeli', auth()->user()->name) }}" required>
                            @error('nama_pembeli')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Alamat -->
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" rows="3" 
                                      class="form-control @error('alamat') is-invalid @enderror" 
                                      required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Nomor WhatsApp -->
                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_wa" 
                                   class="form-control @error('nomor_wa') is-invalid @enderror" 
                                   value="{{ old('nomor_wa') }}" 
                                   placeholder="08xxxxxxxxxx" required>
                            @error('nomor_wa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Metode Pembayaran -->
                        <div class="mb-4">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check card p-3 h-100">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran" 
                                               id="qris" value="QRIS" required
                                               {{ old('metode_pembayaran') == 'QRIS' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="qris">
                                            <div class="fw-bold">📱 QRIS</div>
                                            <small class="text-muted">Bayar pakai scan QR</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check card p-3 h-100">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran" 
                                               id="cod" value="COD" required
                                               {{ old('metode_pembayaran') == 'COD' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cod">
                                            <div class="fw-bold">💵 COD</div>
                                            <small class="text-muted">Bayar di tempat</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('metode_pembayaran')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                ✅ Konfirmasi Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Ringkasan Pesanan -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>
                    
                    <!-- Daftar Produk -->
                    <div class="mb-3">
                        @foreach($keranjang as $item)
                            <div class="d-flex justify-content-between mb-2 small">
                                <span>{{ $item->produk->nama }} ({{ $item->jumlah }}x)</span>
                                <span>Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <hr>
                    
                    <!-- Subtotal -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Ongkir -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir</span>
                        <span>
                            @if($total >= 200000)
                                <span class="badge bg-success">GRATIS</span>
                            @else
                                Rp 15.000
                            @endif
                        </span>
                    </div>
                    
                    <hr>
                    
                    <!-- Total -->
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total Bayar</span>
                        <span class="fw-bold price-tag">
                            Rp {{ number_format($total >= 200000 ? $total : $total + 15000, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">📝 Catatan</h6>
                    <ul class="small mb-0">
                        <li>Pesanan akan diproses setelah pembayaran dikonfirmasi</li>
                        <li>Gratis ongkir untuk pembelian di atas Rp 200.000</li>
                        <li>Estimasi pengiriman 2-3 hari kerja</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection