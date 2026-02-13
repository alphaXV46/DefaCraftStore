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
                                               {{ old('metode_pembayaran') == 'QRIS' ? 'checked' : '' }}
                                               onchange="toggleQRIS(true)">
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
                                               {{ old('metode_pembayaran') == 'COD' ? 'checked' : '' }}
                                               onchange="toggleQRIS(false)">
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
                        
                        <!-- QRIS SECTION 👇 TAMBAH INI -->
                        <div id="qrisSection" style="display: none;" class="mb-4">
                            <div class="alert alert-info">
                                <h6 class="fw-bold mb-3">Cara Pembayaran QRIS:</h6>
                                <ol class="mb-0">
                                    <li>Scan QR Code di bawah dengan aplikasi e-wallet atau mobile banking</li>
                                    <li>Bayar sesuai total yang tertera</li>
                                    <li>Screenshot bukti pembayaran</li>
                                    <li>Setelah checkout, upload bukti di halaman "Pesanan Saya"</li>
                                </ol>
                            </div>
                            
                            <div class="card text-center p-4">
                                <h6 class="fw-bold mb-3">Scan QR Code Ini:</h6>
                                <img src="{{ asset('images/qris.png') }}" 
                                     alt="QR Code QRIS" 
                                     class="img-fluid mx-auto" 
                                     style="max-width: 300px;"
                                     onerror="this.src='data:image/svg+xml,%3Csvg width=\'300\' height=\'300\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'300\' fill=\'%23e2e8f0\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' fill=\'%2394a3b8\' font-size=\'20\' dy=\'.3em\'%3EQR Code QRIS%3C/text%3E%3C/svg%3E'">
                                <p class="text-muted mt-3 mb-0">
                                    <strong>Total Pembayaran:</strong><br>
                                    <span class="fs-3 fw-bold text-primary">
                                        Rp {{ number_format($total >= 200000 ? $total : $total + 15000, 0, ',', '.') }}
                                    </span>
                                </p>
                                <small class="text-danger mt-2">
                                    ⚠️ Pastikan nominal yang dibayar SAMA PERSIS dengan total di atas
                                </small>
                            </div>
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
        
        <!-- Ringkasan Pesanan (tidak berubah) -->
        <div class="col-md-4">
            <!-- ... kode ringkasan yang sudah ada ... -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle tampilan QR Code
    function toggleQRIS(show) {
        document.getElementById('qrisSection').style.display = show ? 'block' : 'none';
    }
    
    // Check on page load
    document.addEventListener('DOMContentLoaded', function() {
        const qrisRadio = document.getElementById('qris');
        if (qrisRadio && qrisRadio.checked) {
            toggleQRIS(true);
        }
    });
</script>
@endpush
@endsection