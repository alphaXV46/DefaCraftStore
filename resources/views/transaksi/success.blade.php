@extends('layouts.app')

@section('title', 'Pesanan Berhasil - DefaCraftStore')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/transaksi-success.css') }}">
@endpush

@section('content')

{{-- Confetti Container --}}
<div class="confetti" id="confetti"></div>

<div class="success-wrapper">
    <div class="container">
        <div class="success-card card">

            {{-- Header --}}
            <div class="success-header">
                <div class="checkmark-circle">✅</div>
                <div class="success-title">Pesanan Berhasil!</div>
                <div class="success-subtitle">
                    Terima kasih telah berbelanja di DefaCraftStore 🎉
                </div>
            </div>

            {{-- Order Info --}}
            <div class="order-info">
                @if($transaksi)
                    {{-- Order ID --}}
                    <div class="order-id-box">
                        <div class="order-id-label">Nomor Pesanan</div>
                        <div class="order-id-value">{{ $transaksi->order_id ?? '#' . $transaksi->id }}</div>
                    </div>

                    {{-- Detail --}}
                    <div class="detail-row">
                        <span class="detail-label">📅 Tanggal</span>
                        <span class="detail-value">{{ $transaksi->created_at->format('d M Y, H:i') }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">📍 Dikirim ke</span>
                        <span class="detail-value">{{ $transaksi->nama_pembeli }}, {{ $transaksi->city_name ?? $transaksi->alamat }}</span>
                    </div>

                    @if($transaksi->kurir)
                    <div class="detail-row">
                        <span class="detail-label">🚚 Kurir</span>
                        <span class="detail-value">{{ $transaksi->kurir }} {{ $transaksi->layanan_kurir }} ({{ $transaksi->estimasi }})</span>
                    </div>
                    @endif

                    <div class="detail-row">
                        <span class="detail-label">💳 Metode Bayar</span>
                        <span class="detail-value">
                            @switch($transaksi->metode_pembayaran)
                                @case('QRIS') 📱 QRIS / E-Wallet @break
                                @case('VA')   🏦 Virtual Account @break
                                @case('CC')   💳 Kartu Kredit @break
                                @case('COD')  💵 COD @break
                                @default {{ $transaksi->metode_pembayaran }}
                            @endswitch
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">📦 Status</span>
                        <span class="detail-value">{!! $transaksi->getStatusBadge() !!}</span>
                    </div>

                    {{-- Total --}}
                    <div class="total-row">
                        <span class="total-label">Total Pembayaran</span>
                        <span class="total-value">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                @else
                    <div class="text-center py-3">
                        <p class="text-muted">Pesanan kamu sedang diproses.</p>
                    </div>
                @endif
            </div>

            {{-- Info langkah selanjutnya --}}
            @if($transaksi)
            <div class="step-info">
                <div class="step-info-title">📋 Langkah Selanjutnya:</div>
                @if($transaksi->metode_pembayaran === 'COD')
                    <div class="step-item">✅ Pesanan kamu sedang diproses oleh admin</div>
                    <div class="step-item">📦 Barang akan segera dikemas dan dikirim</div>
                    <div class="step-item">💵 Siapkan uang tunai saat kurir tiba</div>
                @elseif($transaksi->status === 'pending')
                    <div class="step-item">⏳ Selesaikan pembayaran secepatnya</div>
                    <div class="step-item">📧 Cek email untuk instruksi pembayaran</div>
                    <div class="step-item">📦 Pesanan akan diproses setelah pembayaran dikonfirmasi</div>
                @else
                    <div class="step-item">✅ Pembayaran berhasil dikonfirmasi</div>
                    <div class="step-item">📦 Pesanan sedang diproses oleh admin</div>
                    <div class="step-item">🚚 Nomor resi akan dikirim via WhatsApp</div>
                @endif
            </div>
            @endif

            {{-- Action Buttons --}}
            <div class="action-buttons">
                <a href="{{ route('transaksi.riwayat') }}" class="btn-primary-custom">
                    📋 Lihat Status Pesanan
                </a>
                <a href="{{ route('produk.index') }}" class="btn-outline-custom">
                    🛍️ Lanjut Belanja
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Confetti simpel
function createConfetti() {
    const colors  = ['#4f46e5', '#7c3aed', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'];
    const confetti = document.getElementById('confetti');
    const count   = 60;

    for (let i = 0; i < count; i++) {
        const piece = document.createElement('div');
        piece.className = 'confetti-piece';

        const color    = colors[Math.floor(Math.random() * colors.length)];
        const left     = Math.random() * 100;
        const duration = 2 + Math.random() * 2;
        const delay    = Math.random() * 1.5;
        const size     = 6 + Math.random() * 8;

        piece.style.cssText = `
            left: ${left}%;
            background: ${color};
            width: ${size}px;
            height: ${size}px;
            animation-duration: ${duration}s;
            animation-delay: ${delay}s;
            border-radius: ${Math.random() > 0.5 ? '50%' : '2px'};
        `;

        confetti.appendChild(piece);
    }

    // Hapus confetti setelah selesai
    setTimeout(() => confetti.innerHTML = '', 5000);
}

document.addEventListener('DOMContentLoaded', createConfetti);
</script>
@endpush