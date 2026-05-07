@extends('layouts.app')

@section('title', 'Pesanan Berhasil - DefaCraftStore')

@push('styles')
<style>
    .success-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        padding: 3rem 0;
        background: linear-gradient(135deg, #f0f4ff 0%, #fdf2ff 100%);
    }
    .success-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        overflow: hidden;
        max-width: 600px;
        margin: 0 auto;
    }
    .success-header {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        padding: 3rem 2rem;
        text-align: center;
        color: white;
    }
    .checkmark-circle {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        border: 3px solid rgba(255,255,255,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
        animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    @keyframes popIn {
        0%   { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .success-title {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    .success-subtitle {
        font-size: 1rem;
        opacity: 0.85;
    }
    .order-info {
        background: white;
        padding: 2rem;
    }
    .order-id-box {
        background: #f8fafc;
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .order-id-label {
        font-size: 0.8rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.25rem;
    }
    .order-id-value {
        font-size: 1rem;
        font-weight: 700;
        color: #4f46e5;
        font-family: monospace;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        color: #64748b;
        font-weight: 500;
    }
    .detail-value {
        font-weight: 600;
        color: #1e293b;
        text-align: right;
        max-width: 60%;
    }
    .total-row {
        background: #f0f0ff;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 1rem 0;
    }
    .total-label {
        font-weight: 700;
        font-size: 1rem;
        color: #374151;
    }
    .total-value {
        font-weight: 800;
        font-size: 1.3rem;
        color: #4f46e5;
    }
    .action-buttons {
        padding: 1.5rem 2rem 2rem;
        background: white;
        display: flex;
        gap: 1rem;
        flex-direction: column;
    }
    .btn-primary-custom {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.875rem;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s ease;
        display: block;
    }
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79,70,229,0.3);
        color: white;
    }
    .btn-outline-custom {
        border: 2px solid #e2e8f0;
        color: #64748b;
        border-radius: 12px;
        padding: 0.875rem;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s ease;
        display: block;
        background: white;
    }
    .btn-outline-custom:hover {
        border-color: #4f46e5;
        color: #4f46e5;
        background: #f0f0ff;
    }
    .step-info {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin: 0 2rem 1.5rem;
    }
    .step-info-title {
        font-weight: 700;
        color: #92400e;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    .step-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #78350f;
        margin-bottom: 0.25rem;
    }
    .confetti {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 9999;
        overflow: hidden;
    }
    .confetti-piece {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 2px;
        animation: confettiFall linear forwards;
    }
    @keyframes confettiFall {
        0%   { transform: translateY(-20px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
    }
</style>
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