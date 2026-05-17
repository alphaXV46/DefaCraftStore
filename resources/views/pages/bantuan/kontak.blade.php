@extends('layouts.app')

@section('title', 'Kontak Kami - DefaCraftStore')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #contactMap { height: 300px; width: 100%; border-radius: 12px; margin-top: 20px; border: 1px solid #ddd; }
</style>
@endpush
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold mb-2" style="color: #4A3F5C;">Kontak Kami</h2>
                    <p class="text-muted mb-4">Ada pertanyaan? Kami siap membantu Anda kapan saja.</p>

                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 text-center h-100">
                                <div style="font-size: 2rem;">📍</div>
                                <h6 class="fw-bold mt-2 mb-1">Lokasi</h6>
                                <p class="text-muted mb-0" style="font-size: 0.9rem;">Bogor, Jawa Barat, Indonesia</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 text-center h-100">
                                <div style="font-size: 2rem;">📧</div>
                                <h6 class="fw-bold mt-2 mb-1">Email</h6>
                                <a href="mailto:dendyfadhlullah46@gmail.com" class="text-muted text-decoration-none" style="font-size: 0.9rem; word-break: break-all;">dendyfadhlullah46@gmail.com</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 text-center h-100">
                                <div style="font-size: 2rem;">📱</div>
                                <h6 class="fw-bold mt-2 mb-1">WhatsApp</h6>
                                <a href="https://wa.me/6285658080575" target="_blank" class="text-muted text-decoration-none" style="font-size: 0.9rem;">+62 856-5808-0575</a>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-3 mb-4" style="background: #f8f9fa;">
                        <p class="mb-1 fw-bold" style="font-size: 0.9rem;">⏰ Jam Operasional</p>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">Senin – Sabtu, pukul 08.00 – 17.00 WIB</p>
                    </div>

                    <div id="contactMap"></div>
                    <div class="mt-2 mb-4 text-center">
                        <small class="text-muted">📍 Bogor, Jawa Barat, Indonesia</small>
                    </div>
                    <a href="https://wa.me/6285658080575" target="_blank"
                       class="btn btn-success d-inline-flex align-items-center gap-2 px-4 py-2 fw-bold rounded-pill">
                        <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const STORE_LATLNG = [-6.5971, 106.8060];
        const map = L.map('contactMap').setView(STORE_LATLNG, 19);
        
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

        const StoreIcon = L.divIcon({
            html: '🏪',
            className: 'custom-div-icon',
            iconSize: [40, 40],
            iconAnchor: [20, 20]
        });

        L.marker(STORE_LATLNG, { icon: StoreIcon })
            .addTo(map)
            .bindPopup('<strong>DefaCraftStore Hub</strong><br>Bogor, Jawa Barat')
            .openPopup();
    });
</script>
@endpush
@endsection
