@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $transaksi->id . ' - DefaCraftStore')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/transaksi-show.css') }}">
@endpush

@section('content')
<div class="container py-5">

    
    

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            ❌ {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="fw-bold mb-0">📋 Detail Pesanan</h1>
            <p class="text-muted mb-0">
                Order #{{ $transaksi->id }}
                @if($transaksi->order_id)
                    · <span class="text-secondary">{{ $transaksi->order_id }}</span>
                @endif
            </p>
        </div>
        <div class="col-auto">
            <a href="{{ route('transaksi.riwayat') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── Kolom Kiri (utama) ── --}}
        <div class="col-lg-8">

            {{-- Status & Timeline --}}
            <div class="card detail-card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                    <strong>📊 Status Pesanan</strong>
                    {!! $transaksi->getStatusBadge() !!}
                </div>
                <div class="card-body">

                    @if(!in_array($transaksi->status, ['cancelled', 'expired']))
                    <div class="status-timeline">
                        @php
                            $steps = [
                                ['icon' => '📝', 'label' => 'Pesanan Dibuat',
                                 'statuses' => ['pending','paid','processing','shipped','completed']],
                                ['icon' => '💳', 'label' => 'Pembayaran',
                                 'statuses' => ['paid','processing','shipped','completed'],
                                 'active'   => ['pending']],
                                ['icon' => '📦', 'label' => 'Diproses',
                                 'statuses' => ['processing','shipped','completed'],
                                 'active'   => ['paid']],
                                ['icon' => '🚚', 'label' => 'Dikirim',
                                 'statuses' => ['shipped','completed'],
                                 'active'   => ['processing']],
                                ['icon' => '✅', 'label' => 'Selesai',
                                 'statuses' => ['completed'],
                                 'active'   => ['shipped']],
                            ];
                        @endphp
                        @foreach($steps as $step)
                            @php
                                $isCompleted = in_array($transaksi->status, $step['statuses']);
                                $isActive    = isset($step['active']) && in_array($transaksi->status, $step['active']);
                                $class = $isCompleted ? 'completed' : ($isActive ? 'active' : '');
                            @endphp
                            <div class="status-step {{ $class }}">
                                <div class="step-icon">{{ $step['icon'] }}</div>
                                <div class="step-label">{{ $step['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-danger mb-0">
                        ❌ Pesanan ini
                        {{ $transaksi->status === 'cancelled' ? 'dibatalkan' : 'kedaluwarsa (tidak dibayar)' }}
                    </div>
                    @endif

                    {{-- Nomor Resi (highlight jika ada) --}}
                    @if($transaksi->resi)
                    <div class="resi-box mt-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <div class="text-muted small fw-semibold mb-1">🚚 Nomor Resi Pengiriman</div>
                                <div class="resi-code">{{ $transaksi->resi }}</div>
                                <div class="text-muted small mt-1">
                                    {{ strtoupper($transaksi->kurir ?? '') }}
                                    {{ $transaksi->layanan_kurir ?? '' }}
                                </div>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-sm btn-outline-primary"
                                        onclick="copyResi('{{ $transaksi->resi }}')">
                                    📋 Salin Resi
                                </button>
                                <a href="https://www.google.com/search?q=cek+resi+{{ $transaksi->resi }}"
                                   target="_blank" class="btn btn-sm btn-info text-white">
                                    🔍 Lacak Paket
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Konfirmasi Diterima --}}
                    @if($transaksi->status === 'shipped')
                    <div class="confirm-alert mt-3">
                        <div class="d-flex align-items-start gap-3 flex-wrap">
                            <div class="flex-grow-1">
                                <div class="fw-bold text-success mb-1">📦 Paket Sudah Sampai?</div>
                                <div class="text-muted small">
                                    Konfirmasi bahwa barang sudah kamu terima dengan baik.
                                    Setelah konfirmasi, status pesanan akan berubah menjadi <strong>Selesai</strong>.
                                </div>
                            </div>
                            <form action="{{ route('transaksi.received', $transaksi->id) }}"
                                  method="POST" id="formDiterima">
                                @csrf
                                <button type="button" class="btn btn-success"
                                        onclick="konfirmasiDiterima()">
                                    ✅ Pesanan Sudah Diterima
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- Completed info --}}
                    @if($transaksi->status === 'completed')
                    <div class="alert alert-success mt-3 mb-0">
                        ✅ Pesanan telah selesai. Terima kasih sudah belanja di DefaCraftStore! 🎉
                    </div>
                    @endif

                </div>
            </div>

            {{-- Produk --}}
            <div class="card detail-card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <strong>📦 Produk yang Dibeli</strong>
                </div>
                <div class="card-body">
                    @foreach($transaksi->details as $detail)
                    <div class="d-flex align-items-center gap-3 p-3 rounded mb-3"
                         style="background:#f8fafc; border:1px solid #e2e8f0;">
                        @if($detail->produk && $detail->produk->gambar && file_exists(public_path('images/produk/' . $detail->produk->gambar)))
                            <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}"
                                 class="product-img shadow-sm" alt="{{ $detail->nama_produk }}">
                        @else
                            <div class="product-img-placeholder">📦</div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $detail->nama_produk }}</div>
                            <div class="text-muted small">
                                {{ $detail->jumlah }}× @ Rp {{ number_format($detail->harga, 0, ',', '.') }}
                            </div>
                            <div class="text-primary fw-bold small">
                                Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                        @if($transaksi->status === 'completed' && $detail->produk)
                        <a href="{{ route('produk.show', $detail->produk_id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Beli Lagi
                        </a>
                        @endif
                    </div>
                    @endforeach

                    {{-- Subtotal & Ongkir --}}
                    <hr>
                    <div class="d-flex justify-content-between text-muted small mb-1">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($transaksi->total_harga - $transaksi->ongkir, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span class="text-primary">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Catatan --}}
            @if($transaksi->catatan || $transaksi->notes)
            <div class="card detail-card shadow-sm mb-4">
                <div class="card-body">
                    <strong>📝 Catatan:</strong>
                    <p class="mb-0 mt-1 text-muted">{{ $transaksi->catatan ?? $transaksi->notes }}</p>
                </div>
            </div>
            @endif

        </div>

        {{-- ── Kolom Kanan (info) ── --}}
        <div class="col-lg-4">

            {{-- Info Pesanan --}}
            <div class="card detail-card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <strong>🗒️ Info Pesanan</strong>
                </div>
                <div class="card-body d-flex flex-column gap-3">

                    <div class="info-section">
                        <div class="text-muted small fw-semibold mb-2">📅 Tanggal Pesan</div>
                        <div>{{ $transaksi->created_at->format('d M Y, H:i') }}</div>
                        <div class="text-muted small">{{ $transaksi->created_at->diffForHumans() }}</div>
                    </div>

                    <div class="info-section">
                        <div class="text-muted small fw-semibold mb-2">💰 Pembayaran</div>
                        @switch($transaksi->metode_pembayaran)
                            @case('QRIS')
                                <span class="badge bg-info">📱 QRIS / E-Wallet</span> @break
                            @case('VA')
                                <span class="badge bg-primary">🏦 Virtual Account</span> @break
                            @case('CC')
                                <span class="badge bg-warning text-dark">💳 Kartu Kredit</span> @break
                            @case('COD')
                                <span class="badge bg-success">💵 COD</span> @break
                            @default
                                <span class="badge bg-secondary">{{ $transaksi->metode_pembayaran }}</span>
                        @endswitch
                        @if($transaksi->payment_type)
                            <div class="text-muted small mt-1">{{ $transaksi->payment_type }}</div>
                        @endif
                        @if($transaksi->paid_at)
                            <div class="text-success small mt-1">
                                ✅ Dibayar: {{ $transaksi->paid_at->format('d M Y, H:i') }}
                            </div>
                        @endif
                    </div>

                    <div class="info-section">
                        <div class="text-muted small fw-semibold mb-2">📍 Alamat Pengiriman</div>
                        <div class="fw-bold">{{ $transaksi->nama_pembali ?? $transaksi->nama_pembeli }}</div>
                        <div class="text-muted small">{{ $transaksi->alamat }}</div>
                        @if($transaksi->city_name)
                            <div class="text-muted small">{{ $transaksi->city_name }}</div>
                        @endif
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $transaksi->nomor_wa) }}"
                           target="_blank" class="text-decoration-none small d-block mt-1">
                            📱 {{ $transaksi->nomor_wa }}
                        </a>
                    </div>

                    @if($transaksi->kurir)
                    <div class="info-section">
                        <div class="text-muted small fw-semibold mb-2">🚚 Kurir</div>
                        <div class="fw-bold">
                            {{ strtoupper($transaksi->kurir) }} {{ $transaksi->layanan_kurir }}
                        </div>
                        @if($transaksi->estimasi)
                            <div class="text-muted small">Estimasi: {{ $transaksi->estimasi }}</div>
                        @endif
                        <div class="text-primary small">
                            Ongkir: Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Aksi --}}
            <div class="card detail-card shadow-sm">
                <div class="card-body d-flex flex-column gap-2">

                    {{-- Bayar Sekarang --}}
                    @if($transaksi->status === 'pending' && $transaksi->metode_pembayaran !== 'COD' && $transaksi->snap_token)
                    <button class="btn btn-primary w-100"
                            onclick="bayarSekarang('{{ $transaksi->snap_token }}')">
                        💳 Bayar Sekarang
                    </button>
                    @endif

                    {{-- Batalkan --}}
                    @if($transaksi->status === 'pending')
                    <form action="{{ route('transaksi.cancel', $transaksi->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            ❌ Batalkan Pesanan
                        </button>
                    </form>
                    @endif

                    {{-- Hubungi Penjual --}}
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20bertanya%20tentang%20pesanan%20%23{{ $transaksi->id }}"
                       target="_blank" class="btn btn-outline-success w-100">
                        💬 Hubungi Penjual
                    </a>

                    <a href="{{ route('transaksi.riwayat') }}" class="btn btn-outline-secondary w-100">
                        ← Kembali ke Riwayat
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- SweetAlert-style confirm modal (pure Bootstrap) --}}
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center py-4">
                <div class="display-4 mb-3">📦</div>
                <h5 class="fw-bold mb-2">Konfirmasi Penerimaan</h5>
                <p class="text-muted mb-4">
                    Pastikan kamu sudah menerima barang dalam kondisi baik sebelum mengkonfirmasi.
                    Tindakan ini tidak bisa dibatalkan.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary px-4"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success px-4"
                            onclick="document.getElementById('formDiterima').submit()">
                        ✅ Ya, Sudah Diterima
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Midtrans Snap (hanya load jika dibutuhkan) --}}
@if($transaksi->status === 'pending' && $transaksi->metode_pembayaran !== 'COD' && $transaksi->snap_token)
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
function bayarSekarang(snapToken) {
    snap.pay(snapToken, {
        onSuccess: () => { showToast('Pembayaran berhasil!', 'success'); setTimeout(() => location.reload(), 2000); },
        onPending: () => showToast('Menunggu pembayaran...', 'warning'),
        onError:   () => showToast('Pembayaran gagal.', 'danger'),
        onClose:   () => showToast('Pembayaran dibatalkan.', 'info'),
    });
}
</script>
@endif

<script>
function konfirmasiDiterima() {
    const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
    modal.show();
}

function copyResi(resi) {
    navigator.clipboard.writeText(resi).then(() => {
        showToast('Nomor resi berhasil disalin!', 'success');
    });
}
</script>
@endpush