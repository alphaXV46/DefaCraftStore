@extends('layouts.app')

@section('title', 'Checkout - DefaCraftStore')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @vite(['resources/css/transaksi-checkout.css'])
@endpush

@section('content')
<div class="checkout-wrapper">
    <div class="container">
        <h1 class="fw-bold mb-4">📦 Checkout</h1>

        <div class="row g-4 align-items-start">

            {{-- KOLOM KIRI --}}
            <div class="col-lg-8">
                <form action="{{ route('transaksi.store') }}" method="POST" id="checkoutForm">
                    @csrf

                    {{-- Hidden fields --}}
                    <input type="hidden" name="destination_id" id="input_destination_id">
                    <input type="hidden" name="city_name" id="input_city_name">
                    <input type="hidden" name="kurir" id="input_kurir">
                    <input type="hidden" name="layanan_kurir" id="input_layanan_kurir">
                    <input type="hidden" name="estimasi" id="input_estimasi">
                    <input type="hidden" name="ongkir" id="input_ongkir" value="0">
                    <input type="hidden" name="latitude" id="input_latitude">
                    <input type="hidden" name="longitude" id="input_longitude">

                    {{-- DATA PEMBELI --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">👤 Data Pembeli</h5>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pembeli"
                                       class="form-control @error('nama_pembeli') is-invalid @enderror"
                                       value="{{ old('nama_pembeli', auth()->user()->name) }}" required>
                                @error('nama_pembeli')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_wa"
                                       class="form-control @error('nomor_wa') is-invalid @enderror"
                                       value="{{ old('nomor_wa') }}"
                                       placeholder="08xxxxxxxxxx" required>
                                @error('nomor_wa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label">Catatan (opsional)</label>
                                <textarea name="catatan" rows="2" class="form-control"
                                          placeholder="Contoh: Tolong dibungkus rapi">{{ old('catatan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ALAMAT PENGIRIMAN --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">📍 Alamat Pengiriman</h5>

                            {{-- Tombol peta --}}
                            <button type="button" class="btn btn-outline-primary mb-3 w-100"
                                    data-bs-toggle="modal" data-bs-target="#mapModal">
                                🗺️ Pilih Lokasi dari Peta
                            </button>

                            {{-- Search kecamatan --}}
                            <div class="mb-3">
                                <label class="form-label">Cari Kecamatan / Kelurahan <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="text" id="destinationSearch"
                                           class="form-control"
                                           placeholder="Ketik nama kecamatan... (min 3 huruf)"
                                           autocomplete="off">
                                    <div id="destinationDropdown"
                                         class="position-absolute bg-white border rounded shadow"
                                         style="z-index:99999; width:100%; max-height:220px; overflow-y:auto; display:none; top:100%; left:0;">
                                    </div>
                                </div>
                                <div id="destinationSelected" class="alert alert-success mt-2 py-2 px-3 small mb-0" style="display:none;">
                                    ✅ <strong>Terpilih:</strong> <span id="destinationSelectedText"></span>
                                </div>
                            </div>

                            {{-- Alamat lengkap --}}
                            <div class="mb-0">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="input_alamat" rows="3"
                                          class="form-control @error('alamat') is-invalid @enderror"
                                          placeholder="Nama jalan, nomor rumah, RT/RW"
                                          required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Preview dari peta --}}
                            <div id="mapAddressPreview" class="alert alert-info mt-3 mb-0 py-2 small" style="display:none;">
                                🗺️ <span id="mapAddressText"></span>
                            </div>
                        </div>
                    </div>

                    {{-- PILIH KURIR (Progressive Disclosure) --}}
                    <div class="card mb-4 border-0 shadow-sm" id="kurirSection" style="display:none;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">🚚 Pilih Kurir & Ongkos Kirim</h5>

                            <div id="ongkirLoading" style="display:none;" class="text-center py-3">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2 text-muted small">Menghitung ongkir dari 3 kurir...</p>
                            </div>

                            {{-- Opsi termurah per kurir (selalu terlihat) --}}
                            <div id="kurirCheapest" class="row g-3"></div>

                            {{-- Tombol expand --}}
                            <div id="kurirExpandWrapper" class="text-center mt-3" style="display:none;">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="kurirExpandBtn" onclick="toggleMoreCouriers()">
                                    <span id="expandIcon">▼</span> Lihat lebih banyak opsi
                                </button>
                            </div>

                            {{-- Opsi tambahan (hidden by default) --}}
                            <div id="kurirMore" class="row g-3 mt-2" style="display:none;"></div>

                            
                        </div>
                    </div>

                    {{-- METODE PEMBAYARAN --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">💳 Metode Pembayaran</h5>

                            @error('metode_pembayaran')
                                <div class="alert alert-danger py-2 mb-3">{{ $message }}</div>
                            @enderror

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <input type="radio" class="btn-check" name="metode_pembayaran"
                                           id="pay_qris" value="QRIS"
                                           {{ old('metode_pembayaran', 'QRIS') == 'QRIS' ? 'checked' : '' }}>
                                    <label class="payment-card d-block p-3 rounded w-100 h-100" for="pay_qris">
                                        <div class="fw-bold">📱 QRIS / E-Wallet</div>
                                        <small class="text-muted">GoPay, OVO, ShopeePay, DANA</small>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" class="btn-check" name="metode_pembayaran"
                                           id="pay_va" value="VA"
                                           {{ old('metode_pembayaran') == 'VA' ? 'checked' : '' }}>
                                    <label class="payment-card d-block p-3 rounded w-100 h-100" for="pay_va">
                                        <div class="fw-bold">🏦 Virtual Account</div>
                                        <small class="text-muted">BCA, BNI, BRI, Mandiri</small>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" class="btn-check" name="metode_pembayaran"
                                           id="pay_cc" value="CC"
                                           {{ old('metode_pembayaran') == 'CC' ? 'checked' : '' }}>
                                    <label class="payment-card d-block p-3 rounded w-100 h-100" for="pay_cc">
                                        <div class="fw-bold">💳 Kartu Kredit / Debit</div>
                                        <small class="text-muted">Visa, Mastercard</small>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" class="btn-check" name="metode_pembayaran"
                                           id="pay_cod" value="COD"
                                           {{ old('metode_pembayaran') == 'COD' ? 'checked' : '' }}>
                                    <label class="payment-card d-block p-3 rounded w-100 h-100" for="pay_cod">
                                        <div class="fw-bold">💵 COD</div>
                                        <small class="text-muted">Bayar tunai saat barang sampai</small>
                                    </label>
                                </div>
                            </div>

                            
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg shadow">
                            🚀 Buat Pesanan Sekarang
                        </button>
                    </div>

                </form>
            </div>

            {{-- KOLOM KANAN: RINGKASAN --}}
            <div class="col-lg-4">
                <div class="summary-card card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">🧾 Ringkasan Pesanan</h5>

                        @foreach($keranjang as $item)
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="me-2" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $item->produk->nama }}
                                <span class="text-muted">x{{ $item->jumlah }}</span>
                            </span>
                            <span class="text-nowrap">
                                Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2" id="ongkirRow" style="display:none!important;">
                            <span class="text-muted" id="ongkirLabel">Ongkos Kirim</span>
                            <span id="summaryOngkir" class="text-danger">-</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <span class="fw-bold fs-5">Total Bayar</span>
                            <span class="fw-bold fs-5 text-primary" id="summaryTotal">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>

                        <div id="estimasiInfo" class="alert alert-info mt-3 mb-0 py-2 small" style="display:none;">
                            🚚 <span id="estimasiText"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL PETA --}}
<div class="modal fade" id="mapModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🗺️ Pilih Lokasi Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" id="mapSearch" class="form-control"
                           placeholder="Cari alamat...">
                    <button class="btn btn-primary" type="button" onclick="searchMapAddress()">🔍 Cari</button>
                    <button class="btn btn-outline-secondary" type="button" onclick="getMyLocation()">📍 Lokasi Saya</button>
                </div>
                <div id="map"></div>
                <div class="mt-3 p-3 bg-light rounded" id="selectedAddressBox" style="display:none;">
                    <strong>📍 Alamat Terpilih:</strong>
                    <p id="selectedAddressDetail" class="mb-0 mt-1 small"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmLocationBtn"
                        onclick="confirmLocation()" disabled>
                    ✅ Gunakan Lokasi Ini
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ============================================
// KONSTANTA & CONFIG
// ============================================
const SUBTOTAL           = {{ $subtotal }};
const DEBOUNCE_SEARCH    = 800;
const DEBOUNCE_ONGKIR    = 500;
const MIN_SEARCH_CHARS   = 3;
const DEFAULT_WEIGHT     = 1000;

// ============================================
// STATE GLOBAL
// ============================================
let selectedOngkir           = 0;
let map                      = null;
let marker                   = null;
let selectedLatLng           = null;
let selectedAddress          = null;
let searchTimeout            = null;
let isSelectingDestination   = false;
let lastSearchKeyword        = '';
let lastCalculatedId         = '';
let lastCalculatedWeight     = 0;
let lastDestinationId        = '';
let calculateFetchId         = 0;

// ============================================
// UTILITY: DEBOUNCE
// ============================================
function debounce(fn, delay) {
    let timer = null;
    return function(...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
}

// ============================================
// ALAMAT TERSIMPAN
// ============================================
document.getElementById('simpanAlamat')?.addEventListener('change', function() {
    document.getElementById('labelAlamatBox').style.display = this.checked ? 'block' : 'none';
});

function useSavedAddress(id, nama, wa, alamat, destinationId, cityName) {
    document.querySelectorAll('.saved-address-card').forEach(c => {
        c.classList.remove('border-primary', 'bg-light');
    });
    event.currentTarget.classList.add('border-primary', 'bg-light');

    document.querySelector('[name="nama_pembeli"]').value  = nama;
    document.querySelector('[name="nomor_wa"]').value      = wa;
    document.getElementById('input_alamat').value          = alamat;
    document.getElementById('input_destination_id').value  = destinationId;
    document.getElementById('input_city_name').value       = cityName;
    document.getElementById('destinationSearch').value     = cityName;
    document.getElementById('destinationSelectedText').textContent = cityName;
    document.getElementById('destinationSelected').style.display  = 'block';
    document.getElementById('mapAddressPreview').style.display    = 'none';

    if (destinationId && String(destinationId) !== lastDestinationId) {
        lastDestinationId = String(destinationId);
        debouncedCalculate(String(destinationId), DEFAULT_WEIGHT);
    }
}

// ============================================
// PETA (LEAFLET)
// ============================================
document.getElementById('mapModal')?.addEventListener('shown.bs.modal', function () {
    if (!map) {
        map = L.map('map').setView([-6.5971, 106.8060], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        map.on('click', function(e) {
            placeMarker(e.latlng);
            reverseGeocode(e.latlng.lat, e.latlng.lng);
        });
    } else {
        setTimeout(() => map.invalidateSize(), 100);
    }
});

function placeMarker(latlng) {
    if (marker) map.removeLayer(marker);
    marker = L.marker(latlng, { draggable: true }).addTo(map);
    selectedLatLng = latlng;

    marker.on('dragend', function(e) {
        const pos = e.target.getLatLng();
        reverseGeocode(pos.lat, pos.lng);
    });
}

async function reverseGeocode(lat, lng) {
    try {
        const res  = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`,
            { headers: { 'Accept-Language': 'id' } }
        );
        const data = await res.json();

        if (data?.display_name) {
            selectedAddress = data;
            const addr  = data.address;
            const parts = [
                addr.road,
                addr.suburb || addr.village || addr.hamlet,
                addr.city_district,
                addr.city || addr.regency,
                addr.state
            ].filter(Boolean);

            const display = parts.join(', ');
            document.getElementById('selectedAddressDetail').textContent = display;
            document.getElementById('selectedAddressBox').style.display  = 'block';
            document.getElementById('confirmLocationBtn').disabled        = false;
            marker.bindPopup(display).openPopup();
        }
    } catch(e) {
        console.warn('Reverse geocode error:', e.message);
    }
}

async function searchMapAddress() {
    const query = document.getElementById('mapSearch')?.value.trim();
    if (!query) return;

    try {
        const res     = await fetch(
            `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=1&addressdetails=1`,
            { headers: { 'Accept-Language': 'id' } }
        );
        const results = await res.json();

        if (results.length > 0) {
            const r      = results[0];
            const latlng = L.latLng(parseFloat(r.lat), parseFloat(r.lon));
            map.setView(latlng, 16);
            placeMarker(latlng);
            reverseGeocode(r.lat, r.lon);
        } else {
            Swal.fire({ icon: 'warning', title: 'Tidak Ditemukan', text: 'Alamat tidak ditemukan.', confirmButtonColor: '#0d6efd' });
        }
    } catch(e) {
        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal mencari alamat. Periksa koneksi.', confirmButtonColor: '#0d6efd' });
        console.warn('Search map error:', e.message);
    }
}

function getMyLocation() {
    if (!navigator.geolocation) {
        Swal.fire({ icon: 'warning', title: 'Tidak Didukung', text: 'Browser tidak support geolocation.', confirmButtonColor: '#0d6efd' });
        return;
    }

    navigator.geolocation.getCurrentPosition(
        pos => {
            const latlng = L.latLng(pos.coords.latitude, pos.coords.longitude);
            map.setView(latlng, 16);
            placeMarker(latlng);
            reverseGeocode(pos.coords.latitude, pos.coords.longitude);
        },
        () => Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat mengakses lokasi.', confirmButtonColor: '#0d6efd' })
    );
}

document.getElementById('mapSearch')?.addEventListener('keypress', e => {
    if (e.key === 'Enter') {
        e.preventDefault();
        searchMapAddress();
    }
});

async function confirmLocation() {
    if (!selectedAddress || !selectedLatLng) return;

    const addr        = selectedAddress.address;
    const cityName    = addr.city || addr.regency || addr.county || addr.town || '';
    const subdistrict = addr.suburb || addr.village || addr.quarter || '';

    document.getElementById('input_latitude').value  = selectedLatLng.lat;
    document.getElementById('input_longitude').value = selectedLatLng.lng;

    // Isi textarea alamat lengkap dari peta (ini konteks peta — boleh)
    const fullAddress = [
        addr.road, subdistrict, addr.city_district, cityName, addr.state
    ].filter(Boolean).join(', ');

    document.getElementById('input_alamat').value           = fullAddress;
    document.getElementById('mapAddressText').textContent   = fullAddress;
    document.getElementById('mapAddressPreview').style.display = 'block';

    // Reset highlight saved address
    document.querySelectorAll('.saved-address-card').forEach(c => {
        c.classList.remove('border-primary', 'bg-light');
    });

    bootstrap.Modal.getInstance(document.getElementById('mapModal'))?.hide();

    if (subdistrict || cityName) {
        const searchTerm  = subdistrict || cityName;
        const destInput   = document.getElementById('destinationSearch');
        if (destInput) {
            destInput.value = searchTerm;
            await autoSearchDestination(searchTerm);
        }
    }
}

// ============================================
// SEARCH DESTINATION
// ============================================
const debouncedSearch = debounce(async function(keyword) {
    if (keyword.length < MIN_SEARCH_CHARS) return;
    if (keyword === lastSearchKeyword) return;

    lastSearchKeyword = keyword;
    await doSearchDestination(keyword);
}, DEBOUNCE_SEARCH);

document.getElementById('destinationSearch')?.addEventListener('input', function() {
    const keyword  = this.value.trim();
    const dropdown = document.getElementById('destinationDropdown');

    if (keyword.length < MIN_SEARCH_CHARS) {
        dropdown.style.display = 'none';
        lastSearchKeyword = '';
        return;
    }

    dropdown.innerHTML     = '<div class="destination-item text-muted">⏳ Mengetik...</div>';
    dropdown.style.display = 'block';
    debouncedSearch(keyword);
});

document.getElementById('destinationSearch')?.addEventListener('blur', function() {
    if (!isSelectingDestination) {
        setTimeout(() => {
            document.getElementById('destinationDropdown').style.display = 'none';
        }, 150);
    }
});

async function doSearchDestination(keyword) {
    const dropdown = document.getElementById('destinationDropdown');
    if (!dropdown || keyword.length < MIN_SEARCH_CHARS) return;

    dropdown.innerHTML     = '<div class="destination-item text-muted">🔍 Mencari...</div>';
    dropdown.style.display = 'block';

    try {
        const res  = await fetch(`{{ route('ongkir.search') }}?search=${encodeURIComponent(keyword)}`);
        const data = await res.json();

        const currentKeyword = document.getElementById('destinationSearch')?.value.trim();
        if (currentKeyword !== keyword) return; // sudah berubah, abaikan

        dropdown.innerHTML = '';

        if (data.error || !Array.isArray(data) || data.length === 0) {
            dropdown.innerHTML = '<div class="destination-item text-muted">Tidak ditemukan</div>';
            return;
        }

        data.forEach(item => {
            const div       = document.createElement('div');
            div.className   = 'destination-item';
            div.textContent = item.label;

            div.addEventListener('mousedown', function(e) {
                e.preventDefault();
                isSelectingDestination = true;
                selectDestination(item);
                dropdown.style.display = 'none';
                setTimeout(() => isSelectingDestination = false, 200);
            });
            dropdown.appendChild(div);
        });

    } catch(e) {
        console.warn('Search error:', e.message);
        dropdown.innerHTML = '<div class="destination-item text-muted">Gagal memuat. Coba lagi.</div>';
    }
}

async function autoSearchDestination(keyword) {
    try {
        const res  = await fetch(`{{ route('ongkir.search') }}?search=${encodeURIComponent(keyword)}`);
        const data = await res.json();

        if (data && data.length > 0) {
            const match = data.find(d => d.city_name?.toLowerCase().includes(keyword.toLowerCase())) || data[0];
            selectDestination(match);
        }
    } catch(e) {
        console.warn('Auto search error:', e.message);
    }
}

function selectDestination(item) {
    // Isi hidden inputs untuk ongkir
    document.getElementById('input_destination_id').value  = item.id;
    document.getElementById('input_city_name').value       = item.city_name || '';

    // Isi search box dengan label kecamatan
    document.getElementById('destinationSearch').value     = item.label;
    document.getElementById('destinationDropdown').style.display = 'none';

    // Tampilkan badge kecamatan terpilih
    const elSelText = document.getElementById('destinationSelectedText');
    const elSelBox  = document.getElementById('destinationSelected');
    if (elSelText) elSelText.textContent  = item.label;
    if (elSelBox)  elSelBox.style.display = 'block';

    // ⚠️ Kecamatan TIDAK boleh mengisi textarea alamat_lengkap — user isi manual
    // (Textarea #input_alamat TIDAK disentuh di sini)

    document.querySelectorAll('.saved-address-card').forEach(c => {
        c.classList.remove('border-primary', 'bg-light');
    });

    debouncedCalculate(String(item.id), DEFAULT_WEIGHT);
}

document.addEventListener('click', function(e) {
    const search   = document.getElementById('destinationSearch');
    const dropdown = document.getElementById('destinationDropdown');
    if (search && dropdown && !e.target.closest('#destinationSearch') && !e.target.closest('#destinationDropdown')) {
        dropdown.style.display = 'none';
    }
});

// ============================================
// CALCULATE ONGKIR
// ============================================
const debouncedCalculate = debounce(async function(destinationId, weight) {
    if (!destinationId || !/^\d+$/.test(destinationId)) return;
    weight = Math.min(weight, 1000);
    if (weight < 100) return;

    if (destinationId === lastCalculatedId && weight === lastCalculatedWeight) return;

    lastCalculatedId     = destinationId;
    lastCalculatedWeight = weight;
    await calculateOngkir(destinationId, weight);
}, DEBOUNCE_ONGKIR);

// State untuk Progressive Disclosure
let moreExpanded = false;

function toggleMoreCouriers() {
    const moreSection = document.getElementById('kurirMore');
    const icon        = document.getElementById('expandIcon');
    const btn         = document.getElementById('kurirExpandBtn');
    if (!moreSection) return;

    moreExpanded = !moreExpanded;
    moreSection.style.display = moreExpanded ? 'flex' : 'none';
    if (icon) icon.textContent = moreExpanded ? '▲' : '▼';
    if (btn) btn.innerHTML = `<span id="expandIcon">${moreExpanded ? '▲' : '▼'}</span> ${moreExpanded ? 'Sembunyikan' : 'Lihat lebih banyak opsi'}`;
}

function buildKurirCard(item) {
    const col     = document.createElement('div');
    col.className = 'col-sm-6 col-lg-4';
    col.innerHTML = `
        <div class="kurir-card"
             data-courier="${item.courier}"
             data-service="${item.service}"
             data-cost="${item.cost}"
             data-etd="${item.etd}">
            <div class="kurir-card__header">
                <span class="kurir-card__badge">${item.courier}</span>
                <span class="kurir-card__service">${item.service}</span>
            </div>
            <div class="kurir-card__price">Rp ${Number(item.cost).toLocaleString('id-ID')}</div>
            <div class="kurir-card__etd">📦 Estimasi ${item.etd}</div>
        </div>
    `;
    col.querySelector('.kurir-card').addEventListener('click', function() {
        selectKurir(this, item.courier, item.service, item.cost, item.etd);
    });
    return col;
}

async function calculateOngkir(destinationId, weight = DEFAULT_WEIGHT) {
    if (!destinationId || !/^\d+$/.test(String(destinationId))) {
        console.warn('calculateOngkir: invalid destinationId');
        return;
    }

    const currentFetchId = ++calculateFetchId;

    const kurirSection      = document.getElementById('kurirSection');
    const cheapestContainer = document.getElementById('kurirCheapest');
    const moreContainer     = document.getElementById('kurirMore');
    const expandWrapper     = document.getElementById('kurirExpandWrapper');
    const loading           = document.getElementById('ongkirLoading');
    const kurirError        = document.getElementById('kurirError');

    // Reset UI — tampilkan section & spinner, sembunyikan error
    if (kurirSection)      kurirSection.style.display = 'block';
    if (loading)           loading.style.display      = 'block';
    if (cheapestContainer) cheapestContainer.innerHTML = '';
    if (moreContainer)     { moreContainer.innerHTML = ''; moreContainer.style.display = 'none'; }
    if (expandWrapper)     expandWrapper.style.display = 'none';
    if (kurirError)        kurirError.style.display    = 'none'; // Sembunyikan error dulu
    moreExpanded = false;

    selectedOngkir = 0;
    if (document.getElementById('input_kurir'))  document.getElementById('input_kurir').value  = '';
    if (document.getElementById('input_ongkir')) document.getElementById('input_ongkir').value = '0';
    updateTotal();

    try {
        const res = await fetch('{{ route("ongkir.calculate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            },
            body: JSON.stringify({ destination_id: destinationId, weight: Math.min(weight, 1000) }),
        });

        // Abort jika ada request baru yang berjalan
        if (currentFetchId !== calculateFetchId) return;

        // Selalu sembunyikan spinner setelah response diterima
        if (loading) loading.style.display = 'none';

        if (res.status === 429) {
            if (kurirError) {
                kurirError.innerHTML     = '⚠️ Terlalu banyak permintaan. Tunggu sebentar lalu coba lagi.';
                kurirError.style.display = 'block';
            }
            return;
        }

        const data = await res.json();

        // Deteksi kuota API habis
        if (data.status === 'limit') {
            Swal.fire({
                icon: 'warning',
                title: 'Kuota Habis',
                text: 'Maaf, kuota harian perhitungan ongkir telah habis. Silakan hubungi admin atau isi alamat manual.',
                confirmButtonColor: '#0d6efd',
                confirmButtonText: 'Mengerti'
            });
            return;
        }

        // Cek error dari server (hanya jika respons memang error)
        if (!res.ok || data.error) {
            if (kurirError) {
                kurirError.innerHTML     = '⚠️ ' + (data.error || 'Ongkir tidak tersedia untuk tujuan ini.');
                kurirError.style.display = 'block';
            }
            return;
        }

        const grouped      = data.grouped || {};
        const courierNames = Object.keys(grouped);

        // Hanya tampilkan error jika memang tidak ada kurir sama sekali
        if (courierNames.length === 0) {
            if (kurirError) {
                kurirError.innerHTML     = '⚠️ Tidak ada layanan kurir tersedia untuk tujuan ini.';
                kurirError.style.display = 'block';
            }
            return;
        }

        // === PROGRESSIVE DISCLOSURE ===
        // 1) Tampilkan 1 opsi termurah per kurir (primary view)
        let hasMoreOptions = false;

        courierNames.forEach(courierKey => {
            const options = grouped[courierKey];
            if (!options || options.length === 0) return;

            // Opsi termurah → tampil di area utama
            cheapestContainer.appendChild(buildKurirCard(options[0]));

            // Opsi ke-2 & ke-3 → masuk ke area "lebih banyak"
            if (options.length > 1) {
                hasMoreOptions = true;
                for (let i = 1; i < options.length; i++) {
                    moreContainer.appendChild(buildKurirCard(options[i]));
                }
            }
        });

        // 2) Tampilkan tombol expand jika ada opsi tambahan
        if (hasMoreOptions && expandWrapper) {
            expandWrapper.style.display = 'block';
        }

    } catch(e) {
        if (currentFetchId !== calculateFetchId) return;
        
        if (loading)    loading.style.display    = 'none';
        if (kurirError) {
            kurirError.innerHTML     = '⚠️ Gagal menghitung ongkir. Periksa koneksi internet.';
            kurirError.style.display = 'block';
        }
        console.warn('calculateOngkir error:', e.message);
    }
}

function selectKurir(el, courier, service, cost, etd) {
    document.querySelectorAll('.kurir-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');

    selectedOngkir = Number(cost);

    if (document.getElementById('input_kurir'))         document.getElementById('input_kurir').value         = courier;
    if (document.getElementById('input_layanan_kurir')) document.getElementById('input_layanan_kurir').value = service;
    if (document.getElementById('input_estimasi'))      document.getElementById('input_estimasi').value      = etd;
    if (document.getElementById('input_ongkir'))        document.getElementById('input_ongkir').value        = cost;

    updateTotal();

    const estimasiText = document.getElementById('estimasiText');
    const estimasiInfo = document.getElementById('estimasiInfo');
    if (estimasiText) estimasiText.textContent   = `${courier} ${service} - Estimasi ${etd}`;
    if (estimasiInfo) estimasiInfo.style.display = 'block';
}

function updateTotal() {
    const total         = SUBTOTAL + selectedOngkir;
    const ongkirRow     = document.getElementById('ongkirRow');
    const summaryOngkir = document.getElementById('summaryOngkir');
    const summaryTotal  = document.getElementById('summaryTotal');

    if (selectedOngkir > 0) {
        if (ongkirRow)     ongkirRow.style.setProperty('display', 'flex', 'important');
        if (summaryOngkir) summaryOngkir.textContent = 'Rp ' + Number(selectedOngkir).toLocaleString('id-ID');
    } else {
        if (ongkirRow) ongkirRow.style.setProperty('display', 'none', 'important');
    }
    if (summaryTotal) summaryTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// ============================================
// COD INFO TOGGLE — hanya muncul saat COD dipilih
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const radios   = document.querySelectorAll('input[name="metode_pembayaran"]');
    const infoCod  = document.getElementById('infoCod');
    const codRadio = document.getElementById('pay_cod');

    function updateCodInfo() {
        if (infoCod && codRadio) {
            infoCod.style.display = codRadio.checked ? 'block' : 'none';
        }
    }

    // Set initial state pada saat halaman dimuat
    updateCodInfo();

    // Set listener pada semua radio
    radios.forEach(r => {
        r.addEventListener('change', updateCodInfo);
    });
});

// ============================================
// VALIDASI SUBMIT FORM (SweetAlert2)
// ============================================
document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {
    const destId = document.getElementById('input_destination_id')?.value;
    const kurir  = document.getElementById('input_kurir')?.value;
    const metode = document.querySelector('input[name="metode_pembayaran"]:checked');

    if (!destId) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Tujuan Belum Dipilih',
            text: 'Pilih kecamatan/kelurahan tujuan pengiriman terlebih dahulu.',
            confirmButtonColor: '#0d6efd'
        }).then(() => document.getElementById('destinationSearch')?.focus());
        return;
    }
    if (!kurir) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Kurir Belum Dipilih',
            text: 'Pilih kurir pengiriman terlebih dahulu.',
            confirmButtonColor: '#0d6efd'
        }).then(() => document.getElementById('kurirSection')?.scrollIntoView({ behavior: 'smooth' }));
        return;
    }
    if (!metode) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Metode Pembayaran',
            text: 'Pilih metode pembayaran terlebih dahulu.',
            confirmButtonColor: '#0d6efd'
        });
        return;
    }

    // Validasi label alamat jika simpan dicentang
    const simpanAlamat = document.getElementById('simpanAlamat');
    const labelAlamat  = document.querySelector('[name="label_alamat"]');
    if (simpanAlamat?.checked && labelAlamat && !labelAlamat.value.trim()) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Label Alamat Kosong',
            text: 'Isi label alamat (contoh: Rumah, Kantor) untuk menyimpan alamat.',
            confirmButtonColor: '#0d6efd'
        }).then(() => labelAlamat.focus());
        return;
    }

    // Semua validasi lolos — form submit normal ke halaman pembayaran
});
</script>
@endpush

