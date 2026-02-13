@extends('layouts.app')

@section('title', 'Riwayat Pesanan - DefaCraftStore')

@push('styles')
<style>
    .order-card {
        transition: all 0.3s ease;
    }
    
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .status-timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding: 20px 0;
        margin: 20px 0;
    }
    
    .status-timeline::before {
        content: '';
        position: absolute;
        top: 30px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e2e8f0;
        z-index: 0;
    }
    
    .status-step {
        position: relative;
        z-index: 1;
        text-align: center;
        flex: 1;
    }
    
    .status-step .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .status-step.active .step-icon {
        background: var(--primary);
        color: white;
    }
    
    .status-step.completed .step-icon {
        background: var(--success);
        color: white;
    }
    
    .status-step .step-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
    }
    
    .status-step.active .step-label,
    .status-step.completed .step-label {
        color: var(--dark);
    }
    
    .order-filter {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        background: white;
        color: #64748b;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .filter-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .filter-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h1 class="fw-bold mb-0">📋 Riwayat Pesanan</h1>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('produk.index') }}" class="btn btn-primary">
                🛍️ Belanja Lagi
            </a>
        </div>
    </div>
    
    @if($transaksi->isEmpty())
        <!-- Empty State -->
        <div class="card text-center py-5 shadow-sm">
            <div class="card-body">
                <span class="display-1">📦</span>
                <h3 class="mt-3">Belum Ada Pesanan</h3>
                <p class="text-muted mb-4">Yuk mulai belanja produk lucu kami!</p>
                <a href="{{ route('produk.index') }}" class="btn btn-primary btn-lg">
                    Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <!-- Filter Status -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Filter Status:</h6>
                <div class="order-filter">
                    <button class="filter-btn active" onclick="filterOrders('all')">
                        Semua ({{ $transaksi->count() }})
                    </button>
                    <button class="filter-btn" onclick="filterOrders('pending')">
                        ⏳ Menunggu Pembayaran ({{ $transaksi->where('status', 'pending')->count() }})
                    </button>
                    <button class="filter-btn" onclick="filterOrders('paid')">
                        💳 Dibayar ({{ $transaksi->where('status', 'paid')->count() }})
                    </button>
                    <button class="filter-btn" onclick="filterOrders('processing')">
                        📦 Diproses ({{ $transaksi->where('status', 'processing')->count() }})
                    </button>
                    <button class="filter-btn" onclick="filterOrders('shipped')">
                        🚚 Dikirim ({{ $transaksi->where('status', 'shipped')->count() }})
                    </button>
                    <button class="filter-btn" onclick="filterOrders('completed')">
                        ✅ Selesai ({{ $transaksi->where('status', 'completed')->count() }})
                    </button>
                    <button class="filter-btn" onclick="filterOrders('cancelled')">
                        ❌ Dibatalkan ({{ $transaksi->where('status', 'cancelled')->count() }})
                    </button>
                </div>
            </div>
        </div>
        
        <!-- List Pesanan -->
        <div class="row g-4">
            @foreach($transaksi as $order)
                <div class="col-12 order-item" data-status="{{ $order->status }}">
                    <div class="card order-card shadow-sm">
                        <!-- Card Header -->
                        <div class="card-header bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h6 class="mb-1">
                                        <strong>Order #{{ $order->id }}</strong>
                                    </h6>
                                    <small class="text-muted">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                        <span class="text-muted">({{ $order->created_at->diffForHumans() }})</span>
                                    </small>
                                </div>
                                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                                    {!! $order->getStatusBadge() !!}
                                </div>
                                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                    <strong class="text-primary fs-5">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Timeline Status -->
                        <div class="card-body">
                            <div class="status-timeline">
                                <div class="status-step {{ in_array($order->status, ['pending', 'paid', 'processing', 'shipped', 'completed']) ? 'completed' : '' }}">
                                    <div class="step-icon">📝</div>
                                    <div class="step-label">Pesanan Dibuat</div>
                                </div>
                                <div class="status-step {{ in_array($order->status, ['paid', 'processing', 'shipped', 'completed']) ? 'completed' : ($order->status == 'pending' ? 'active' : '') }}">
                                    <div class="step-icon">💳</div>
                                    <div class="step-label">Menunggu Pembayaran</div>
                                </div>
                                <div class="status-step {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'completed' : ($order->status == 'paid' ? 'active' : '') }}">
                                    <div class="step-icon">📦</div>
                                    <div class="step-label">Diproses</div>
                                </div>
                                <div class="status-step {{ in_array($order->status, ['shipped', 'completed']) ? 'completed' : ($order->status == 'processing' ? 'active' : '') }}">
                                    <div class="step-icon">🚚</div>
                                    <div class="step-label">Dikirim</div>
                                </div>
                                <div class="status-step {{ $order->status == 'completed' ? 'completed' : ($order->status == 'shipped' ? 'active' : '') }}">
                                    <div class="step-icon">✅</div>
                                    <div class="step-label">Selesai</div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <!-- Detail Produk -->
                            <div class="mb-3">
                                <strong class="d-block mb-3">📦 Produk yang dibeli:</strong>
                                <div class="row g-3">
                                    @foreach($order->details as $detail)
                                        <div class="col-12">
                                            <div class="d-flex align-items-center gap-3 p-2 rounded hover-bg">
                                                <!-- Gambar -->
                                                @if($detail->produk && $detail->produk->gambar && file_exists(public_path('images/produk/' . $detail->produk->gambar)))
                                                    <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}" 
                                                         width="80" height="80" class="rounded shadow-sm" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center shadow-sm" 
                                                         style="width: 80px; height: 80px;">
                                                        <span class="fs-3">📦</span>
                                                    </div>
                                                @endif
                                                
                                                <!-- Info -->
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1"><strong>{{ $detail->nama_produk }}</strong></h6>
                                                    <p class="mb-1 text-muted small">
                                                        {{ $detail->jumlah }}x @ Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                                    </p>
                                                    <div class="fw-bold text-primary">
                                                        Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                                
                                                <!-- Action -->
                                                @if($order->status == 'completed' && $detail->produk)
                                                    <div>
                                                        <a href="{{ route('produk.show', $detail->produk_id) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            Beli Lagi
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <hr>
                            
                            <!-- Info Pengiriman & Pembayaran -->
                            <div class="row">
                                <div class="col-md-6">
                                    <strong class="d-block mb-2">📍 Alamat Pengiriman:</strong>
                                    <p class="mb-1"><strong>{{ $order->nama_pembeli }}</strong></p>
                                    <p class="mb-1 text-muted">{{ $order->alamat }}</p>
                                    <p class="mb-0">
                                        <a href="https://wa.me/{{ $order->nomor_wa }}" target="_blank" class="text-decoration-none">
                                            📱 {{ $order->nomor_wa }}
                                        </a>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <strong class="d-block mb-2">💰 Info Pembayaran:</strong>
                                    <p class="mb-1">
                                        <strong>Metode:</strong> 
                                        @if($order->metode_pembayaran == 'QRIS')
                                            <span class="badge bg-info">📱 QRIS</span>
                                        @else
                                            <span class="badge bg-success">💵 COD</span>
                                        @endif
                                    </p>
                                    @if($order->resi)
                                        <p class="mb-1">
                                            <strong>No. Resi:</strong> 
                                            <code class="bg-light p-1 rounded">{{ $order->resi }}</code>
                                            <button class="btn btn-sm btn-outline-secondary" onclick="copyResi('{{ $order->resi }}')">
                                                📋 Copy
                                            </button>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Catatan Admin -->
                            @if($order->notes)
                                <div class="alert alert-info mt-3 mb-0">
                                    <strong>📝 Catatan dari Admin:</strong><br>
                                    {{ $order->notes }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Card Footer - Actions -->
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <!-- Upload Bukti (hanya pending & QRIS) -->
                                    @if($order->status == 'pending' && $order->metode_pembayaran == 'QRIS')
                                        @if(!$order->bukti_bayar)
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#uploadModal{{ $order->id }}">
                                                📤 Upload Bukti Bayar
                                            </button>
                                        @else
                                            <span class="badge bg-warning fs-6">
                                                ⏳ Menunggu Konfirmasi Admin
                                            </span>
                                        @endif
                                    @endif
                                    
                                    <!-- Track Paket (kalau shipped) -->
                                    @if($order->status == 'shipped' && $order->resi)
                                        <a href="https://www.google.com/search?q=cek+resi+{{ $order->resi }}" 
                                           target="_blank" 
                                           class="btn btn-info btn-sm">
                                            🔍 Lacak Paket
                                        </a>
                                    @endif
                                    
                                    <!-- Pesanan Diterima (kalau shipped) -->
                                    @if($order->status == 'shipped')
                                        <button class="btn btn-success btn-sm" 
                                                onclick="confirmReceived({{ $order->id }})">
                                            ✅ Pesanan Diterima
                                        </button>
                                    @endif
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <!-- View Bukti Bayar -->
                                    @if($order->bukti_bayar)
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewBuktiModal{{ $order->id }}">
                                            👁️ Lihat Bukti Bayar
                                        </button>
                                    @endif
                                    
                                    <!-- Hubungi Penjual -->
                                    <a href="https://wa.me/6281234567890?text=Halo, saya ingin bertanya tentang pesanan %23{{ $order->id }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-success">
                                        💬 Hubungi Penjual
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Upload Bukti Bayar -->
                <div class="modal fade" id="uploadModal{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('transaksi.upload.bukti', $order->id) }}" 
                                  method="POST" 
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="alert alert-info">
                                        <strong>💰 Total yang harus dibayar:</strong><br>
                                        <span class="fs-4 fw-bold text-primary">
                                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Screenshot Bukti Transfer</label>
                                        <input type="file" name="bukti_bayar" 
                                               class="form-control @error('bukti_bayar') is-invalid @enderror" 
                                               accept="image/*" required 
                                               onchange="previewBukti(event, {{ $order->id }})">
                                        @error('bukti_bayar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Format: JPG, PNG. Max 2MB</small>
                                    </div>
                                    
                                    <!-- Preview -->
                                    <div id="preview{{ $order->id }}" class="mt-3" style="display: none;">
                                        <p class="fw-bold">Preview:</p>
                                        <img id="previewImg{{ $order->id }}" src="" class="img-fluid rounded">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        📤 Upload
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Modal View Bukti Bayar -->
                @if($order->bukti_bayar)
                <div class="modal fade" id="viewBuktiModal{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Bukti Pembayaran - Order #{{ $order->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('images/bukti_bayar/' . $order->bukti_bayar) }}" 
                                     class="img-fluid rounded shadow" alt="Bukti Bayar">
                            </div>
                            <div class="modal-footer">
                                <a href="{{ asset('images/bukti_bayar/' . $order->bukti_bayar) }}" 
                                   download 
                                   class="btn btn-primary">
                                    💾 Download
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
// Filter Orders
function filterOrders(status) {
    const orders = document.querySelectorAll('.order-item');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Update active button
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Show/hide orders
    orders.forEach(order => {
        if (status === 'all' || order.dataset.status === status) {
            order.style.display = 'block';
        } else {
            order.style.display = 'none';
        }
    });
}

// Preview Bukti Bayar
function previewBukti(event, orderId) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById(`preview${orderId}`);
        const img = document.getElementById(`previewImg${orderId}`);
        img.src = reader.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Copy Resi
function copyResi(resi) {
    navigator.clipboard.writeText(resi).then(() => {
        showToast('Nomor resi berhasil dicopy!', 'success');
    });
}

// Confirm Received (placeholder - nanti bisa tambah endpoint)
function confirmReceived(orderId) {
    if (confirm('Konfirmasi bahwa Anda sudah menerima pesanan ini?')) {
        // TODO: Kirim request ke server untuk update status jadi completed
        alert('Fitur ini akan segera tersedia. Silakan hubungi penjual untuk konfirmasi.');
    }
}
</script>
@endpush
@endsection