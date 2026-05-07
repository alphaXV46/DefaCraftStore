@extends('layouts.app')

@section('title', 'Riwayat Pesanan - DefaCraftStore')

@push('styles')
<style>
.op-page {
    font-family: 'Inter', -apple-system, sans-serif;
    color: #333;
    line-height: 1.6;
    background: #FFFFFF;
    min-height: 100vh;
    padding: 0;
    -webkit-font-smoothing: antialiased;
}
.op-page *, .op-page *::before, .op-page *::after { box-sizing: border-box; }

.op-wrap {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 2rem 3rem;
}

/* ===== TOP BAR ===== */
.op-topbar {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding-bottom: 1.5rem;
}
.op-back {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: #fff;
    color: #555;
    font-size: 1rem;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
    border: 1.5px solid #E8E8E8;
    flex-shrink: 0;
}
.op-back:hover { border-color: #EAB308; color: #EAB308; }
.op-topbar h1 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.4rem;
    font-weight: 800;
    color: #333;
    margin: 0;
    position: relative;
    display: inline-block;
    padding-bottom: 0.5rem;
}
.op-topbar h1::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, #FEF9C3, #EAB308, #FACC15);
    border-radius: 4px;
}
.op-shop-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: #fff;
    color: #555;
    font-size: 1.1rem;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
    border: 1.5px solid #E8E8E8;
    flex-shrink: 0;
    margin-left: auto;
}
.op-shop-btn:hover { border-color: #EAB308; color: #EAB308; }

/* ===== STATS ===== */
.op-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}
.op-stat {
    background: #fff;
    border-radius: 16px;
    padding: 1.1rem;
    text-align: center;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    border: 1.5px solid rgba(0,0,0,0.06);
    transition: all 0.25s;
    position: relative;
    overflow: hidden;
}
.op-stat::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
}
.op-stat:nth-child(1)::before { background: linear-gradient(135deg, #EAB308, #FACC15); }
.op-stat:nth-child(2)::before { background: linear-gradient(135deg, #F59E0B, #FCD34D); }
.op-stat:nth-child(3)::before { background: linear-gradient(135deg, #34D399, #6EE7B7); }
.op-stat:nth-child(4)::before { background: linear-gradient(135deg, #F87171, #FCA5A5); }
.op-stat:hover { transform: translateY(-2px); box-shadow: 0 4px 14px rgba(0,0,0,0.06); }
.op-stat-icon { font-size: 1.4rem; margin-bottom: 0.25rem; display: block; }
.op-stat-num {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.35rem;
    font-weight: 800;
    color: #333;
    line-height: 1.1;
}
.op-stat-label {
    font-size: 0.7rem;
    color: #aaa;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-top: 0.15rem;
}

/* ===== TIPS ===== */
.op-tips {
    background: #FFFBEB;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.85rem;
    border: 1.5px solid rgba(234,179,8,0.15);
}
.op-tips-icon { font-size: 1.5rem; flex-shrink: 0; }
.op-tips-text { font-size: 0.85rem; color: #7A6200; line-height: 1.4; }
.op-tips-text strong { color: #5A4700; }

/* ===== FILTERS ===== */
.op-filters {
    display: flex;
    gap: 0.5rem;
    padding: 0 0 1rem;
    overflow-x: auto;
    scrollbar-width: none;
}
.op-filters::-webkit-scrollbar { display: none; }
.op-chip {
    flex-shrink: 0;
    display: inline-block;
    padding: 0.55rem 1.1rem;
    border-radius: 50px;
    border: 1.5px solid rgba(0,0,0,0.08);
    background: #fff;
    color: #888;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
    font-family: 'Inter', sans-serif;
}
.op-chip:hover { border-color: #EAB308; color: #EAB308; }
.op-chip.active {
    background: linear-gradient(135deg, #EAB308, #CA8A04);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 3px 10px rgba(234,179,8,0.2);
}

/* ===== EMPTY ===== */
.op-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: #FAFAFA;
    border-radius: 20px;
    border: 1.5px solid rgba(0,0,0,0.06);
}
.op-empty-icon { font-size: 3.5rem; margin-bottom: 0.75rem; }
.op-empty h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #333; margin-bottom: 0.35rem; font-size: 1.2rem; }
.op-empty p { color: #999; margin-bottom: 1.5rem; font-size: 0.95rem; }

/* ===== ORDER LIST ===== */
.op-list { display: flex; flex-direction: column; gap: 0.75rem; }

/* ===== ORDER CARD ===== */
.op-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    border: 1.5px solid rgba(0,0,0,0.06);
    transition: all 0.25s;
}
.op-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.06); border-color: rgba(234,179,8,0.15); }

.op-card-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 1.1rem 1.25rem 0.5rem;
}
.op-order-id { font-weight: 700; color: #333; font-size: 0.95rem; line-height: 1.3; }
.op-order-date { font-size: 0.8rem; color: #aaa; margin-top: 0.1rem; }
.op-order-inv { font-size: 0.72rem; color: #ccc; margin-top: 0.1rem; font-family: monospace; }

/* Badge */
.op-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.2rem;
    padding: 0.2rem 0.65rem;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
}
.op-badge-pending { background: #FEF3C7; color: #92400E; }
.op-badge-paid { background: #EFF6FF; color: #1E40AF; }
.op-badge-processing { background: #F3E8FF; color: #6B21A8; }
.op-badge-shipped { background: #ECFDF5; color: #065F46; }
.op-badge-completed { background: #ECFDF5; color: #065F46; }
.op-badge-cancelled, .op-badge-expired { background: #FEF2F2; color: #991B1B; }

/* Products */
.op-card-products { padding: 0.25rem 1.25rem 0.5rem; }
.op-product { display: flex; align-items: flex-start; gap: 0.9rem; padding: 0.7rem 0; }
.op-product + .op-product { border-top: 1px solid #F5F5F5; }
.op-product-img {
    width: 68px; height: 68px; border-radius: 12px;
    object-fit: cover; border: 1px solid #f0f0f0; flex-shrink: 0; display: block;
}
.op-product-img-ph {
    width: 68px; height: 68px; border-radius: 12px;
    background: #FFFBEB; display: flex; align-items: center;
    justify-content: center; font-size: 1.4rem; flex-shrink: 0; border: 1px solid #f0f0f0;
}
.op-product-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 0.15rem; }
.op-product-name-row { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
.op-product-name { font-weight: 600; font-size: 0.95rem; color: #333; overflow: hidden; text-overflow: ellipsis; line-height: 1.35; flex: 1; min-width: 0; }
.op-product-meta { font-size: 0.82rem; color: #aaa; line-height: 1.3; }
.op-product-price { font-weight: 700; font-size: 0.95rem; color: #333; line-height: 1.3; }

/* Footer */
.op-card-foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.85rem 1.25rem 1.1rem;
    border-top: 1px solid #F5F5F5;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.op-total { display: flex; align-items: baseline; gap: 0.4rem; }
.op-total-label { font-size: 0.85rem; color: #aaa; }
.op-total-price { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.15rem; font-weight: 800; color: #333; }
.op-actions { display: flex; gap: 0.4rem; flex-wrap: wrap; }

/* ===== BUTTONS ===== */
.op-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
    padding: 0.55rem 1.05rem;
    border-radius: 10px;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
    white-space: nowrap;
}
.op-btn-primary { background: linear-gradient(135deg, #EAB308, #CA8A04); color: #fff; box-shadow: 0 2px 8px rgba(234,179,8,0.2); }
.op-btn-primary:hover { box-shadow: 0 4px 14px rgba(234,179,8,0.3); transform: translateY(-1px); }
.op-btn-green { background: linear-gradient(135deg, #34D399, #10B981); color: #fff; box-shadow: 0 2px 8px rgba(52,211,153,0.2); }
.op-btn-green:hover { box-shadow: 0 4px 14px rgba(52,211,153,0.3); transform: translateY(-1px); }
.op-btn-blue { background: linear-gradient(135deg, #60A5FA, #3B82F6); color: #fff; box-shadow: 0 2px 8px rgba(96,165,250,0.2); }
.op-btn-blue:hover { box-shadow: 0 4px 14px rgba(96,165,250,0.3); transform: translateY(-1px); }
.op-btn-red-outline { background: #fff; color: #E53935; border: 1.5px solid #E53935; }
.op-btn-red-outline:hover { background: #E53935; color: #fff; }
.op-btn-wa-outline { background: #fff; color: #16A34A; border: 1.5px solid #BBF7D0; }
.op-btn-wa-outline:hover { background: #F0FDF4; border-color: #86EFAC; }
.op-btn-gray { background: #F5F5F5; color: #666; border: none; }
.op-btn-gray:hover { background: #EEEEEE; }

/* ===== PAGINATION ===== */
.op-pagination { display: flex; justify-content: center; gap: 0.35rem; padding: 1.75rem 0 0; flex-wrap: wrap; }
.op-pagination .page-link {
    display: flex; align-items: center; justify-content: center;
    min-width: 38px; height: 38px; border-radius: 10px;
    border: 1.5px solid rgba(0,0,0,0.08); background: #fff;
    color: #888; font-size: 0.88rem; font-weight: 600;
    text-decoration: none; transition: all 0.2s; padding: 0 0.5rem;
}
.op-pagination .page-link:hover { border-color: #EAB308; color: #EAB308; transform: translateY(-1px); }
.op-pagination .page-item.active .page-link { background: linear-gradient(135deg, #EAB308, #CA8A04); border-color: transparent; color: #fff; }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .op-stats { grid-template-columns: repeat(2, 1fr); gap: 0.6rem; }
    .op-tips { flex-direction: column; text-align: center; }
    .op-wrap { padding: 0 1rem 2rem; }
}
@media (max-width: 576px) {
    .op-card-foot { flex-direction: column; align-items: stretch; gap: 0.6rem; }
    .op-total { justify-content: space-between; }
    .op-actions { display: flex; gap: 0.35rem; }
    .op-actions .op-btn { flex: 1; justify-content: center; font-size: 0.78rem; padding: 0.55rem 0.4rem; }
    .op-product-img, .op-product-img-ph { width: 56px; height: 56px; }
    .op-product-name { font-size: 0.88rem; }
    .op-total-price { font-size: 1rem; }
    .op-stat { padding: 0.85rem; }
    .op-stat-num { font-size: 1.15rem; }
}
</style>
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

        @php
            $semua = $transaksi->count();
            $menunggu = $transaksi->where('status', 'pending')->count();
            $selesai = $transaksi->where('status', 'completed')->count();
            $batal = $transaksi->where('status', 'cancelled')->count();
        @endphp

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
                                <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}" class="op-product-img" alt="{{ $detail->nama_produk }}">
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
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
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