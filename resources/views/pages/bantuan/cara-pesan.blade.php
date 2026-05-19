@extends('layouts.app')

@section('title', 'Cara Pemesanan - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold mb-4" style="color: #4A3F5C;">Panduan Cara Pemesanan</h2>
                    
                    <p class="mb-4">Berbelanja Blind Box & Action Figure favorit Anda di DefaCraftStore sangatlah mudah dan cepat. Ikuti langkah-langkah praktis berikut:</p>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px; font-weight: bold;">1</div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-1">Cari Produk</h5>
                            <p class="text-muted">Jelajahi koleksi Blind Box & Figure impian Anda melalui menu navigasi atau halaman <a href="{{ route('produk.index') }}">Semua Produk</a>.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px; font-weight: bold;">2</div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-1">Masukkan ke Keranjang</h5>
                            <p class="text-muted">Pilih produk yang Anda sukai, lalu klik tombol "Masukkan Keranjang". Anda juga bisa langsung menekan tombol Beli Langsung jika hanya membeli satu item.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px; font-weight: bold;">3</div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-1">Checkout & Pengiriman</h5>
                            <p class="text-muted">Buka Keranjang Anda, centang produk yang akan dibeli, lalu klik "Checkout". Isi alamat pengiriman Anda secara detail dan pilih kurir pengiriman (JNE, POS, atau TIKI).</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px; font-weight: bold;">4</div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-1">Selesaikan Pembayaran</h5>
                            <p class="text-muted">Pilih metode pembayaran melalui platform aman Midtrans (Virtual Account, E-Wallet, atau QRIS). Segera selesaikan pembayaran sebelum batas waktu berakhir.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px; font-weight: bold;">5</div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-1">Pesanan Diproses</h5>
                            <p class="text-muted">Voila! Pesanan Anda sedang kami proses dan segera kami kirim ke alamat Anda. Anda dapat melacak status pesanan di halaman "Riwayat Transaksi".</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
