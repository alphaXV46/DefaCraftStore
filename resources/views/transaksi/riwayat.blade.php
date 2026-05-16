@extends('layouts.app')

@section('title', 'Riwayat Pesanan - DefaCraftStore')

@push('styles')
    @vite(['resources/css/transaksi-riwayat.css'])
@endpush

@section('content')
<div class="op-page">
<div class="op-wrap">

    {{-- Top Bar --}}
    <div class="op-topbar">
        <a href="{{ url()->previous() }}" class="op-back">←</a>
        <h1>Riwayat Pesanan</h1>
        <a href="{{ route('produk.index') }}" class="op-shop-btn">🛍️</a>
    </div>

    @if($transaksi->isEmpty())
        <div class="op-empty">
           
            <h3>Belum Ada Pesanan</h3>
            <p>Yuk mulai belanja produk lucu kami!</p>
            <a href="{{ route('produk.index') }}" class="op-btn op-btn-primary" style="padding: 0.8rem 2rem; font-size: 0.95rem;">Mulai Belanja</a>
        </div>
    @else



        {{-- Stats --}}
        <div class="op-stats">
            <div class="op-stat">
                <span class="op-stat-icon">📋</span>
                <div class="op-stat-num">{{ $semua }}</div>
                <div class="op-stat-label">Semua</div>
            </div>
            <div class="op-stat">
                <span class="op-stat-icon">⏳</span>
                <div class="op-stat-num">{{ $menunggu }}</div>
                <div class="op-stat-label">Menunggu</div>
            </div>
            <div class="op-stat">
                <span class="op-stat-icon">✅</span>
                <div class="op-stat-num">{{ $selesai }}</div>
                <div class="op-stat-label">Selesai</div>
            </div>
            <div class="op-stat">
                <span class="op-stat-icon">❌</span>
                <div class="op-stat-num">{{ $batal }}</div>
                <div class="op-stat-label">Dibatalkan</div>
            </div>
        </div>

        {{-- Tips --}}
        <div class="op-tips">
            <span class="op-tips-icon">💡</span>
            <div class="op-tips-text">
                <strong>Butuh bantuan?</strong> Klik 💬 untuk chat via WhatsApp, atau tekan <strong>Detail</strong> untuk info lengkap pesanan.
            </div>
        </div>

        {{-- Filters --}}
        <div class="op-filters">
            <button class="op-chip active" onclick="opFilter('all', this)">Semua</button>
            <button class="op-chip" onclick="opFilter('pending', this)">Menunggu</button>
            <button class="op-chip" onclick="opFilter('paid', this)">Dibayar</button>
            <button class="op-chip" onclick="opFilter('processing', this)">Diproses</button>
            <button class="op-chip" onclick="opFilter('shipped', this)">Dikirim</button>
            <button class="op-chip" onclick="opFilter('completed', this)">Selesai</button>
            <button class="op-chip" onclick="opFilter('cancelled', this)">Dibatalkan</button>
        </div>

        {{-- Order List --}}
        <div class="op-list" id="opList">
            @foreach($transaksi as $order)
            @php
                $badgeMap = [
                    'pending'    => ['icon' => '⏳', 'text' => 'Menunggu'],
                    'paid'       => ['icon' => '💳', 'text' => 'Dibayar'],
                    'processing' => ['icon' => '📦', 'text' => 'Diproses'],
                    'shipped'    => ['icon' => '🚚', 'text' => 'Dikirim'],
                    'completed'  => ['icon' => '✅', 'text' => 'Selesai'],
                    'cancelled'  => ['icon' => '❌', 'text' => 'Dibatalkan'],
                    'expired'    => ['icon' => '⏰', 'text' => 'Kedaluwarsa'],
                ];
                $b = $badgeMap[$order->status] ?? ['icon' => '❓', 'text' => $order->status];
            @endphp
            <div class="op-item" data-status="{{ $order->status }}">
                <div class="op-card">
                    <div class="op-card-head">
                        <div>
                            <div class="op-order-id">#{{ $order->id }}</div>
                            <div class="op-order-date">{{ $order->created_at->format('d M Y, H:i') }} · {{ $order->created_at->diffForHumans() }}</div>
                            @if($order->order_id)<div class="op-order-inv">{{ $order->order_id }}</div>@endif
                        </div>
                        <span class="op-badge op-badge-{{ $order->status }}">{{ $b['icon'] }} {{ $b['text'] }}</span>
                    </div>
                    <div class="op-card-products">
                        @foreach($order->details as $detail)
                        <div class="op-product">
                            @if($detail->produk && $detail->produk->gambar && file_exists(public_path('images/produk/' . $detail->produk->gambar)))
                                <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}"
                                     class="op-product-img" alt="{{ $detail->nama_produk }}"
                                     width="80" height="80"
                                     loading="lazy" decoding="async">
                            @else
                                <div class="op-product-img-ph">📦</div>
                            @endif
                            <div class="op-product-info">
                                <div class="op-product-name-row">
                                    <span class="op-product-name">{{ $detail->nama_produk }}</span>
                                </div>
                                <div class="op-product-meta">{{ $detail->jumlah }}x · Rp {{ number_format($detail->harga, 0, ',', '.') }}</div>
                                <div class="op-product-price">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="op-card-foot">
                        <div class="op-total">
                            <span class="op-total-label">Total</span>
                            <span class="op-total-price">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="op-actions">
                            @if($order->status === 'pending' && $order->metode_pembayaran !== 'COD' && $order->snap_token)
                                <button class="op-btn op-btn-primary" onclick="bayarSekarang('{{ $order->snap_token }}')">💳 Bayar</button>
                            @endif
                            @if($order->status === 'shipped' && $order->resi)
                                <a href="https://www.google.com/search?q=cek+resi+{{ $order->resi }}" target="_blank" class="op-btn op-btn-blue">🔍 Lacak</a>
                            @endif
                            @if($order->status === 'shipped')
                                <form action="{{ route('transaksi.received', $order->id) }}" method="POST" style="display:contents;" onsubmit="return confirm('Konfirmasi pesanan sudah diterima?')">
                                    @csrf
                                    <button type="submit" class="op-btn op-btn-green">✅ Diterima</button>
                                </form>
                            @endif
                            @if($order->status === 'pending')
                                <form action="{{ route('transaksi.cancel', $order->id) }}" method="POST" style="display:contents;" onsubmit="return confirm('Yakin ingin membatalkan?')">
                                    @csrf
                                    <button type="submit" class="op-btn op-btn-red-outline">Batalkan</button>
                                </form>
                            @endif
                            <a href="https://wa.me/6281234567890?text=Halo, saya ingin bertanya tentang pesanan %23{{ $order->id }}" target="_blank" class="op-btn op-btn-wa-outline">💬</a>
                            <a href="{{ route('transaksi.show', $order->id) }}" class="op-btn op-btn-gray">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="op-pagination">{{ $transaksi->links() }}</div>

    @endif

</div>
</div>
@endsection

@push('scripts')
<script src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
function opFilter(status, btn) {
    document.querySelectorAll('.op-chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.op-item').forEach(item => {
        if (status === 'all' || item.dataset.status === status) {
            item.style.display = 'block';
            item.style.opacity = '0';
            item.style.transform = 'translateY(8px)';
            requestAnimationFrame(() => {
                item.style.transition = 'all 0.3s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            });
        } else {
            item.style.display = 'none';
        }
    });
}
function bayarSekarang(snapToken) {
    snap.pay(snapToken, {
        onSuccess: function(result) { showToast('Pembayaran berhasil!', 'success'); setTimeout(() => window.location.reload(), 2000); },
        onPending: function(result) { showToast('Menunggu pembayaran...', 'warning'); },
        onError: function(result) { showToast('Pembayaran gagal.', 'danger'); },
        onClose: function() { showToast('Pembayaran dibatalkan.', 'info'); }
    });
}
</script>
@endpush