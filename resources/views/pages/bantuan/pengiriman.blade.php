@extends('layouts.app')

@section('title', 'Informasi Pengiriman - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold mb-4" style="color: #4A3F5C;">Informasi Pengiriman</h2>
                    
                    <p>Kami memastikan Blind Box dan Action Figure pesanan Anda sampai di rumah dengan aman. DefaCraftStore terintegrasi langsung dengan API RajaOngkir untuk memberikan biaya ongkos kirim yang akurat dan *real-time*.</p>
                    
                    <h5 class="fw-bold mt-4">Jasa Ekspedisi Tersedia</h5>
                    <div class="row mt-3 mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded text-center bg-light">
                                <h6 class="fw-bold text-primary mb-0">JNE</h6>
                                <small class="text-muted">REG, OKE, YES</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded text-center bg-light">
                                <h6 class="fw-bold text-warning mb-0">POS Indonesia</h6>
                                <small class="text-muted">Kilat Khusus, Express</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded text-center bg-light">
                                <h6 class="fw-bold text-info mb-0">TIKI</h6>
                                <small class="text-muted">ECO, REG, ONS</small>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-4">Estimasi Waktu Pengemasan</h5>
                    <ul>
                        <li><strong>Produk Ready Stock:</strong> Membutuhkan waktu 1-2 hari kerja untuk pengemasan sebelum diserahkan ke kurir.</li>
                        <li><strong>Produk Pre-Order / Edisi Terbatas:</strong> Estimasi pengemasan adalah 3-7 hari kerja tergantung ketersediaan stok import atau perilisan resmi.</li>
                    </ul>

                    <h5 class="fw-bold mt-4">Lacak Pesanan</h5>
                    <p class="text-muted">Nomor Resi akan otomatis diperbarui di sistem kami setelah paket diserahkan ke kurir. Anda dapat memantau status perjalanan paket secara langsung melalui halaman <strong>Detail Transaksi</strong> pada menu akun Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
