@extends('layouts.app')

@section('title', 'Pesanan Berhasil - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center shadow-lg">
                <div class="card-body py-5">
                    <!-- Icon Success -->
                    <div class="mb-4">
                        <span class="display-1">✅</span>
                    </div>
                    
                    <h2 class="fw-bold mb-3">Pesanan Berhasil Dibuat!</h2>
                    
                    <p class="text-muted mb-4">
                        Terima kasih telah berbelanja di DefaCraftStore. 
                        Pesanan Anda akan segera kami proses.
                    </p>
                    
                    <div class="alert alert-info mb-4">
                        <strong>📱 Info Pembayaran</strong><br>
                        Kami akan menghubungi Anda melalui WhatsApp untuk konfirmasi pembayaran.
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                            🏠 Kembali ke Beranda
                        </a>
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
                            🛍️ Belanja Lagi
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Kontak WhatsApp -->
            <div class="text-center mt-4">
                <a href="https://wa.me/6281234567890" target="_blank" 
                   class="btn btn-success btn-lg">
                    💬 Hubungi Kami via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection