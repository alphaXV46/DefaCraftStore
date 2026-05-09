@extends('layouts.app')

@section('title', 'Keranjang - DefaCraftStore')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/keranjang-index.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">🛒 Keranjang Belanja</h1>
    
    @if($keranjang->isEmpty())
        <!-- Ganti alert dengan card modern -->
        <div class="empty-cart-card">
            <span class="display-1">🛒</span>
            <h3>Keranjang Anda Kosong</h3>
            <p class="text-muted mb-4">Yuk belanja produk lucu kami!</p>
            <a href="{{ route('produk.index') }}" class="btn btn-primary btn-lg px-5 py-3">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="row">
            <!-- Daftar Item Keranjang -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
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
                                    @if($item->produk->gambar && file_exists(public_path('images/produk/' . $item->produk->gambar)))
                                        <img src="{{ asset('images/produk/' . $item->produk->gambar) }}" 
                                             class="img-fluid rounded" alt="{{ $item->produk->nama }}">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                             style="height: 80px;">
                                            <span>📦</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Info Produk -->
                                <div class="col-md-3 col-9">
                                    <h6 class="mb-1">{{ $item->produk->nama }}</h6>
                                    <small class="text-muted">{{ $item->produk->kategori }}</small><br>
                                    <small class="text-muted">Stok: {{ $item->produk->stok }}</small>
                                </div>
                                
                                <!-- Harga -->
                                <div class="col-md-2 col-4">
                                    <p class="mb-0 fw-bold text-primary">
                                        Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <!-- Jumlah -->
                                <div class="col-md-2 col-4">
                                    <form action="{{ route('keranjang.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm">
                                            <button type="button" class="btn btn-outline-secondary" 
                                                    onclick="decreaseQty(this)">-</button>
                                            <input type="number" name="jumlah" class="form-control text-center" 
                                                   value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}"
                                                   onchange="this.form.submit()">
                                            <button type="button" class="btn btn-outline-secondary" 
                                                    onclick="increaseQty(this, {{ $item->produk->stok }})">+</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Subtotal & Hapus -->
                                <div class="col-md-2 col-4 text-end">
                                    <p class="mb-2 fw-bold">
                                        Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                    </p>
                                    <form action="{{ route('keranjang.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Hapus produk ini dari keranjang?')">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
                        ← Lanjut Belanja
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="btn btn-outline-primary">
                        ❤️ Lihat Wishlist
                    </a>
                </div>
            </div>
            
            <!-- Summary -->
            <div class="col-md-4">
                <div class="summary-sticky-container">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                            
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Produk</span>
                                <span class="fw-bold">{{ $checkedCount }} item</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold price-tag">
                                    Rp {{ number_format($total >= 200000 ? $total : $total , 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <!-- Ganti alert info dengan card modern -->
                            @if($total < 200000 && $total > 0)
                                <div class="info-message-card mb-3">
                                    <div class="alert-icon d-inline">💡</div>
                                    <p class="d-inline">
                                        Belanja Rp {{ number_format(200000 - $total, 0, ',', '.') }} lagi untuk gratis ongkir!
                                    </p>
                                </div>
                            @endif
                            
                            @if($checkedCount > 0)
                                <div class="d-grid">
                                    <a href="{{ route('transaksi.checkout') }}" class="btn btn-primary btn-lg">
                                        Checkout ({{ $checkedCount }})
                                    </a>
                                </div>
                            @else
                                <!-- Ganti alert warning dengan card modern -->
                                <div class="checkout-message-card">
                                    <div class="alert-icon">⚠️</div>
                                    <p>Pilih minimal 1 produk untuk checkout</p>
                                </div>
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
    const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
    selectAll.checked = allChecked;
});
</script>
@endpush
@endsection