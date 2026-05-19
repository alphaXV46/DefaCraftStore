@extends('layouts.app')

@section('title', 'Keranjang - DefaCraftStore')

@push('styles')
    @vite(['resources/css/keranjang-index.css'])
@endpush

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h1>
    
    @if($keranjang->isEmpty())
        <!-- Ganti alert dengan card modern -->
        <div class="empty-cart-card text-center py-5 shadow-sm rounded-4 bg-white">
            <span class="display-1"><i class="fas fa-shopping-cart"></i></span>
            <h3 class="mt-3">Keranjang Anda Kosong</h3>
            <p class="text-muted mb-4">Yuk belanja produk lucu kami!</p>
            <a href="{{ route('produk.index') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="row">
            <!-- Daftar Item Keranjang -->
            <div class="col-md-8">
                <div class="card mb-4 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <!-- Select All -->
                        <div class="form-check mb-3 pb-3 border-bottom">
                            <input class="form-check-input cart-checkbox" type="checkbox" 
                                   id="selectAll" onchange="toggleSelectAll(this)">
                            <label class="form-check-label fw-bold" for="selectAll">
                                Pilih Semua ({{ $keranjang->count() }} Produk)
                            </label>
                        </div>
                        
                        @foreach($keranjang as $item)
                            <div class="cart-item {{ $item->checked ? '' : 'unchecked' }} row align-items-center border-bottom py-3" 
                                 id="item-{{ $item->id }}">
                                
                                <!-- Checkbox -->
                                <div class="col-auto">
                                    <input class="form-check-input cart-checkbox item-checkbox" 
                                           type="checkbox" 
                                           data-id="{{ $item->id }}"
                                           {{ $item->checked ? 'checked' : '' }}
                                           onchange="toggleCheck({{ $item->id }})">
                                </div>
                                
                                <!-- Gambar -->
                                <div class="col-md-2 col-3">
                                    @php 
                                        $pathBunglon = 'images/produk/' . $item->produk->gambar;
                                        $pathOlif = 'uploads/produk/' . $item->produk->gambar; 
                                    @endphp
                                    
                                    @if($item->produk->gambar && file_exists(public_path($pathBunglon)))
                                        <img src="{{ asset($pathBunglon) }}"
                                             class="img-fluid rounded-3 shadow-sm" alt="{{ $item->produk->nama }}"
                                             style="width: 100px; height: 100px; object-fit: cover;"
                                             loading="lazy" decoding="async">
                                    @elseif($item->produk->gambar && file_exists(public_path($pathOlif)))
                                        <img src="{{ asset($pathOlif) }}"
                                             class="img-fluid rounded-3 shadow-sm" alt="{{ $item->produk->nama }}"
                                             style="width: 100px; height: 100px; object-fit: cover;"
                                             loading="lazy" decoding="async">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center border" 
                                             style="width: 100px; height: 100px;">
                                            <span><i class="fas fa-box"></i></span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Info Produk -->
                                <div class="col-md-3 col-9">
                                    <h6 class="mb-1 fw-bold">{{ $item->produk->nama }}</h6>
                                    <span class="badge bg-light text-muted border mb-1">{{ $item->produk->kategori->nama ?? $item->produk->kategori ?? 'Tanpa Kategori' }}</span><br>
                                    <small class="text-muted">Stok: {{ $item->produk->stok }}</small>
                                </div>
                                
                                <!-- Harga dengan Diskon Logic -->
                                <div class="col-md-2 col-4">
                                    @if($item->produk->harga_diskon)
                                        <p class="mb-0 fw-bold text-danger" style="line-height: 1.2;">
                                            Rp {{ number_format($item->produk->harga_diskon, 0, ',', '.') }}
                                        </p>
                                        <small class="text-muted" style="text-decoration: line-through !important; display: block; opacity: 0.7;">
                                            Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                        </small>
                                    @else
                                        <p class="mb-0 fw-bold text-primary">
                                            Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                        </p>
                                    @endif
                                </div>
                                
                                <!-- Jumlah -->
                                <div class="col-md-2 col-4">
                                    <form action="{{ route('keranjang.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="d-flex align-items-center justify-content-center border rounded-pill bg-white overflow-hidden" 
                                             style="width: 100px; height: 35px;">
                                            
                                            <button type="button" class="btn btn-sm border-0 px-2 shadow-none" 
                                                    style="border-radius: 0; background: transparent;"
                                                    onclick="decreaseQty(this)">-</button>
                                            
                                            <input type="number" name="jumlah" class="form-control text-center border-0 p-0 shadow-none" 
                                                   value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}"
                                                   style="width: 30px; font-size: 0.9rem; background: transparent;"
                                                   onchange="this.form.submit()">
                                            
                                            <button type="button" class="btn btn-sm border-0 px-2 shadow-none" 
                                                    style="border-radius: 0; background: transparent;"
                                                    onclick="increaseQty(this, {{ $item->produk->stok }})">+</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Subtotal & Hapus -->
                                <div class="col-md-2 col-4 text-end">
                                    @php 
                                        $hargaAktif = $item->produk->harga_diskon ?: $item->produk->harga;
                                    @endphp
                                    <p class="mb-2 fw-bold text-dark">
                                        Rp {{ number_format($hargaAktif * $item->jumlah, 0, ',', '.') }}
                                    </p>
                                    <form action="{{ route('keranjang.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Hapus produk ini dari keranjang?')">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-3 mb-4">
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary rounded-pill">
                        ← Lanjut Belanja
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="btn btn-outline-primary rounded-pill">
                        <i class="fas fa-heart"></i> Lihat Wishlist
                    </a>
                </div>
            </div>
            
            <!-- Summary -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Produk ({{ $checkedCount }})</span>
                            <span class="fw-bold text-dark">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total Harga</span>
                            <span class="fw-bold fs-5 text-primary">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <!-- Ganti alert info dengan card modern -->
                        @if($total < 200000 && $total > 0)
                            <div class="info-message-card mb-4 rounded-3 border-0 small">
                                <div class="alert-icon d-inline"><i class="fas fa-lightbulb"></i></div>
                                <p class="d-inline">
                                    Belanja Rp {{ number_format(200000 - $total, 0, ',', '.') }} lagi untuk gratis ongkir!
                                </p>
                            </div>
                        @endif
                        
                        <div class="d-grid gap-2">
                            @if($checkedCount > 0)
                                <a href="{{ route('transaksi.checkout') }}" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold shadow-sm">
                                    Checkout ({{ $checkedCount }})
                                </a>
                            @else
                                <button class="btn btn-secondary btn-lg rounded-pill py-3 fw-bold shadow-sm" disabled>
                                    Pilih Produk Dahulu
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
// Toggle check single item
function toggleCheck(itemId) {
    fetch(`/keranjang/${itemId}/toggle-check`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update UI
        const item = document.getElementById(`item-${itemId}`);
        if (data.checked) {
            item.classList.remove('unchecked');
        } else {
            item.classList.add('unchecked');
        }
        // Reload untuk update total
        location.reload();
    });
}

// Select All
function toggleSelectAll(checkbox) {
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    itemCheckboxes.forEach(cb => {
        if (cb.checked !== checkbox.checked) {
            cb.checked = checkbox.checked;
            toggleCheck(cb.dataset.id);
        }
    });
}

// Increase/Decrease Qty
function increaseQty(btn, max) {
    const input = btn.previousElementSibling;
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
        input.form.submit();
    }
}

function decreaseQty(btn) {
    const input = btn.nextElementSibling;
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        input.form.submit();
    }
}

// Update Select All on load
document.addEventListener('DOMContentLoaded', function() {
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const selectAll = document.getElementById('selectAll');
    if(itemCheckboxes.length > 0) {
        const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
        selectAll.checked = allChecked;
    }
});
</script>
@endpush
@endsection