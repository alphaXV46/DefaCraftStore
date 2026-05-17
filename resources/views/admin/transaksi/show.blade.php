@extends('layouts.admin')

@section('title', 'Detail Transaksi #' . $transaksi->id . ' - Admin')

@push('styles')
    @vite(['resources/css/admin-transaksi-show.css'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #adminMap { height: 250px; width: 100%; border-radius: 8px; margin-top: 15px; }
    </style>
@endpush

@section('content')
<div class="container py-5" style="padding-bottom: 400px !important;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-2">Detail Transaksi #{{ $transaksi->id }}</h1>
            <p class="text-muted mb-0">
                {{ $transaksi->created_at->format('d M Y H:i') }}
            </p>
        </div>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary">
            ← Kembali
        </a>
    </div>
    
    <div class="row g-4">
        <!-- Informasi Transaksi -->
        <div class="col-md-8">
            <!-- Status & Action -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Status & Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Status Saat Ini:</h6>
                            {!! $transaksi->getStatusBadge() !!}
                        </div>
                        <div class="col-md-6 text-md-end">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                                🔄 Update Status
                            </button>
                        </div>
                    </div>
                    
                    <!-- Timeline Status -->
                    <div class="timeline">
                        <div class="timeline-item {{ in_array($transaksi->status, ['pending', 'paid', 'processing', 'shipped', 'completed']) ? 'active' : '' }}">
                            <strong>Menunggu Pembayaran</strong>
                            <div class="text-muted small">Order dibuat</div>
                        </div>
                        <div class="timeline-item {{ in_array($transaksi->status, ['paid', 'processing', 'shipped', 'completed']) ? 'active' : '' }}">
                            <strong>Dibayar</strong>
                            <div class="text-muted small">Pembayaran diterima</div>
                        </div>
                        <div class="timeline-item {{ in_array($transaksi->status, ['processing', 'shipped', 'completed']) ? 'active' : '' }}">
                            <strong>Diproses</strong>
                            <div class="text-muted small">Pesanan sedang dikemas</div>
                        </div>
                        <div class="timeline-item {{ in_array($transaksi->status, ['shipped', 'completed']) ? 'active' : '' }}">
                            <strong>Dikirim</strong>
                            <div class="text-muted small">
                                @if($transaksi->resi)
                                    Resi: <code>{{ $transaksi->resi }}</code>
                                @else
                                    Menunggu pengiriman
                                @endif
                            </div>
                        </div>
                        <div class="timeline-item {{ $transaksi->status == 'completed' ? 'active' : '' }}">
                            <strong>Selesai</strong>
                            <div class="text-muted small">Pesanan selesai</div>
                        </div>
                    </div>
                    
                    @if($transaksi->notes)
                        <div class="alert alert-info mt-3 mb-0">
                            <strong>Catatan:</strong><br>
                            {{ $transaksi->notes }}
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Detail Produk -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">📦 Produk yang Dibeli</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi->details as $detail)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if($detail->produk && $detail->produk->gambar && file_exists(public_path('images/produk/' . $detail->produk->gambar)))
                                                    <img src="{{ asset('images/produk/' . $detail->produk->gambar) }}" 
                                                         width="60" height="60" class="rounded" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 60px; height: 60px;">
                                                        <span>📦</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong>{{ $detail->nama_produk }}</strong><br>
                                                    <small class="text-muted">SKU: {{ $detail->produk_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                        <td>{{ $detail->jumlah }}x</td>
                                        <td class="fw-bold text-primary">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td class="fw-bold text-primary fs-5">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Bukti Pembayaran -->
            @if($transaksi->bukti_bayar)
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">💳 Bukti Pembayaran</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('images/bukti_bayar/' . $transaksi->bukti_bayar) }}" 
                         class="img-fluid rounded shadow" 
                         style="max-height: 500px;"
                         alt="Bukti Bayar">
                    <div class="mt-3">
                        <a href="{{ asset('images/bukti_bayar/' . $transaksi->bukti_bayar) }}" 
                           target="_blank" 
                           class="btn btn-primary">
                            🔍 Lihat Full Size
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar Info -->
        <div class="col-md-4">
            <!-- Info Customer -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">👤 Informasi Customer</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Nama:</strong><br>
                        {{ $transaksi->nama_pembeli }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong><br>
                        {{ $transaksi->user->email }}
                    </div>
                    <div class="mb-3">
                        <strong>WhatsApp:</strong><br>
                        <a href="https://wa.me/{{ $transaksi->nomor_wa }}" target="_blank" class="btn btn-success btn-sm">
                            📱 {{ $transaksi->nomor_wa }}
                        </a>
                    </div>
                    <div class="mb-0">
                        <strong>Alamat Pengiriman:</strong><br>
                        {{ $transaksi->alamat }}
                    </div>

                    @if($transaksi->latitude && $transaksi->longitude)
                        <div id="adminMap"></div>
                        <div class="mt-2 text-center">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $transaksi->latitude }},{{ $transaksi->longitude }}" 
                               target="_blank" class="btn btn-sm btn-outline-primary">
                                🗺️ Buka di Google Maps
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Info Pembayaran -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">💰 Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Metode:</strong><br>
                        @if($transaksi->metode_pembayaran == 'QRIS')
                            <span class="badge bg-info">📱 QRIS</span>
                        @else
                            <span class="badge bg-success">💵 COD</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Total Pembayaran:</strong><br>
                        <span class="fs-4 fw-bold text-primary">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                    @if($transaksi->resi)
                        <div class="mb-0">
                            <strong>Nomor Resi:</strong><br>
                            <code>{{ $transaksi->resi }}</code>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.transaksi.update.status', $transaksi->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>
                                Menunggu Pembayaran
                            </option>
                            <option value="paid" {{ $transaksi->status == 'paid' ? 'selected' : '' }}>
                                Dibayar
                            </option>
                            <option value="processing" {{ $transaksi->status == 'processing' ? 'selected' : '' }}>
                                Diproses
                            </option>
                            <option value="shipped" {{ $transaksi->status == 'shipped' ? 'selected' : '' }}>
                                Dikirim
                            </option>
                            <option value="completed" {{ $transaksi->status == 'completed' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="cancelled" {{ $transaksi->status == 'cancelled' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor Resi (Opsional)</label>
                        <input type="text" name="resi" class="form-control" 
                               value="{{ old('resi', $transaksi->resi) }}"
                               placeholder="Contoh: JNE1234567890">
                        <small class="text-muted">Isi saat status "Dikirim"</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="3" 
                                  placeholder="Catatan untuk customer...">{{ old('notes', $transaksi->notes) }}</textarea>
                    </div>
                    
                    <div class="alert alert-warning mb-0">
                        <strong>⚠️ Perhatian:</strong><br>
                        - Jika status diubah ke "Dibatalkan", stok produk akan dikembalikan<br>
                        - Pastikan cek bukti pembayaran sebelum approve
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        💾 Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($transaksi->latitude && $transaksi->longitude)
            const lat = {{ $transaksi->latitude }};
            const lng = {{ $transaksi->longitude }};
            
            const map = L.map('adminMap').setView([lat, lng], 19);
            
            const esriSatellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 22,
                maxNativeZoom: 19,
                attribution: 'Tiles &copy; Esri'
            });

            const cartoLabels = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}{r}.png', {
                maxZoom: 22,
                maxNativeZoom: 19,
                attribution: '&copy; OpenStreetMap'
            });

            const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 22,
                maxNativeZoom: 19,
                minZoom: 5,
                attribution: '© OpenStreetMap contributors'
            });

            esriSatellite.addTo(map);
            cartoLabels.addTo(map);

            L.control.layers({
                "Satelit + Label (Hybrid)": L.layerGroup([esriSatellite, cartoLabels]),
                "OpenStreetMap (Jalan)": osmLayer,
                "Satelit Murni": esriSatellite
            }).addTo(map);

            const marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup("<strong>Lokasi Pengiriman</strong><br>{{ $transaksi->nama_pembeli }}").openPopup();
            
            // Fix Leaflet tile loading issue in hidden container/tab
            setTimeout(() => {
                map.invalidateSize();
            }, 500);
        @endif
    });
</script>
@endpush
@endsection