@extends('layouts.app')

@section('title', $produk->nama . ' - DefaCraftStore')

@push('styles')
    @vite(['resources/css/produk-show.css'])
@endpush

@section('content')
<div class="product-detail-page">
    <div class="product-container">
        <!-- Main Product Card -->
        <div class="product-card">
            <div class="product-content">
                <!-- Image Section -->
                <div class="image-section">
                    @php 
                        $pathBunglon = 'images/produk/' . $produk->gambar;
                        $pathOlif = 'uploads/produk/' . $produk->gambar; 
                    @endphp
                    @if($produk->gambar && file_exists(public_path($pathBunglon)))
                        <img src="{{ asset($pathBunglon) }}"
                             class="product-image" alt="{{ $produk->nama }}"
                             width="600" height="600"
                             loading="eager" fetchpriority="high" decoding="sync">
                    @elseif($produk->gambar && file_exists(public_path($pathOlif)))
                        <img src="{{ asset($pathOlif) }}"
                             class="product-image" alt="{{ $produk->nama }}"
                             width="600" height="600"
                             loading="eager" fetchpriority="high" decoding="sync">
                    @else
                        <div class="placeholder-image">
                            <span class="placeholder-icon"><i class="fas fa-box"></i></span>
                        </div>
                    @endif
                </div>

                <!-- Info Section -->
                <div class="info-section">
                    <div class="product-category">{{ $produk->kategori->nama ?? $produk->kategori ?? 'Tanpa Kategori' }}</div>
                    <h1 class="product-title">{{ $produk->nama }}</h1>
                    
                    <div class="product-price" style="margin-bottom: 2rem;">
                        @if($produk->harga_diskon && $produk->harga_diskon > 0)
                            <div style="display: flex; flex-direction: column; gap: 5px;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <span style="color: #ef4444;">Rp {{ number_format($produk->harga_diskon, 0, ',', '.') }}</span>
                                    <span class="badge" style="background: #ef4444; color: white; font-size: 0.9rem; padding: 5px 10px; border-radius: 20px; font-weight: 600;">
                                        Hemat Rp {{ number_format($produk->harga - $produk->harga_diskon, 0, ',', '.') }}
                                    </span>
                                </div>
                                <del style="color: #9ca3af; font-size: 1.2rem;">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </del>
                            </div>
                        @else
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        @endif
                    </div>
                    
                    <!-- Stock Info -->
                    <div class="stock-info">
                        <div class="stock-label">Ketersediaan:</div>
                        @if($produk->stok > 10)
                            <span class="stock-badge stock-available">
                                <i class="fas fa-check-circle"></i> Stok Tersedia ({{ $produk->stok }})
                            </span>
                        @elseif($produk->stok > 0)
                            <span class="stock-badge stock-limited">
                                <i class="fas fa-exclamation-triangle"></i> Stok Terbatas ({{ $produk->stok }})
                            </span>
                        @else
                            <span class="stock-badge stock-out">
                                <i class="fas fa-times-circle"></i> Stok Habis
                            </span>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    <div class="description-section">
                        <h5 class="description-title">Deskripsi Produk</h5>
                        <p class="description-text">{{ $produk->deskripsi }}</p>
                    </div>
                    
                    <!-- Form Section -->
                    <div class="form-section">
                        @auth
                            @if($produk->stok > 0)
                                <form action="{{ route('keranjang.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                    
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="jumlah" class="quantity-input" 
                                        value="1" min="1" max="{{ $produk->stok }}" required>
                                    
                                    <div class="d-flex gap-2 mt-3 flex-column flex-sm-row">
                                        <button type="submit" class="cart-button w-100">
                                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                        </button>
                                        <button type="submit" formaction="{{ route('beli-langsung') }}" class="cart-button w-100" style="background-color: #10b981; border-color: #10b981;">
                                            <i class="fas fa-bolt"></i> Beli Langsung
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="alert-custom alert-danger-custom">
                                    <strong>Maaf, produk ini sedang habis.</strong>
                                </div>
                            @endif
                        @else
                            <div class="alert-custom alert-info-custom">
                                <p class="mb-2">Silakan login untuk membeli produk ini</p>
                                <a href="{{ route('login') }}" class="cart-button">
                                    Login Sekarang
                                </a>
                            </div>
                        @endauth
                    </div>
                    
                    <a href="{{ route('produk.index') }}" class="back-button">
                        ← Kembali ke Produk
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Related Products Section -->
        <div class="related-products-section">
            <h3 class="section-title">Produk Terkait <i class="fas fa-palette"></i></h3>
            <div class="row g-4">
                @forelse($produkTerkait as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="related-product-card h-100">
                            <div class="related-product-image-wrapper">
                                @php 
                                    $pathBunglon = 'images/produk/' . $item->gambar;
                                    $pathOlif = 'uploads/produk/' . $item->gambar; 
                                @endphp
                                @if($item->gambar && file_exists(public_path($pathBunglon)))
                                    <img src="{{ asset($pathBunglon) }}"
                                         class="related-product-image" alt="{{ $item->nama }}"
                                         width="300" height="280"
                                         loading="lazy" decoding="async">
                                @elseif($item->gambar && file_exists(public_path($pathOlif)))
                                    <img src="{{ asset($pathOlif) }}"
                                         class="related-product-image" alt="{{ $item->nama }}"
                                         width="300" height="280"
                                         loading="lazy" decoding="async">
                                @else
                                    <div class="related-product-placeholder">
                                        <span class="fs-1"><i class="fas fa-box"></i></span>
                                    </div>
                                @endif
                                
                                @if($item->harga_diskon && $item->harga_diskon < $item->harga)
                                    <span class="badge position-absolute" style="background: #ef4444; color: white; top: 10px; left: 10px; z-index: 5; padding: 5px 10px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                        Promo
                                    </span>
                                @endif
                            </div>
                            <div class="related-product-info">
                                <h5 class="related-product-name">{{ $item->nama }}</h5>
                                <div class="related-product-price">
                                    @if($item->harga_diskon && $item->harga_diskon > 0)
                                        <span style="color: #ef4444;">Rp {{ number_format($item->harga_diskon, 0, ',', '.') }}</span><br>
                                        <small style="text-decoration: line-through; color: #9ca3af;">Rp {{ number_format($item->harga, 0, ',', '.') }}</small>
                                    @else
                                        <span>Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('produk.show', $item->id) }}" 
                                   class="related-product-button">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted fs-5">Tidak ada produk terkait.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var img = document.querySelector('.product-image');
    var section = document.querySelector('.image-section');
    if (!img) return;

    var ov = document.createElement('div');
    ov.className = 'pd-zoom-overlay';
    ov.innerHTML = '<button class="pd-zoom-close">✕</button><img src="" alt="Zoom">';
    document.body.appendChild(ov);

    section.addEventListener('click', function(e) {
        if (e.target === img) {
            ov.querySelector('img').src = img.src;
            ov.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    });

    ov.addEventListener('click', function(e) {
        if (e.target === ov || e.target.classList.contains('pd-zoom-close')) {
            ov.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && ov.classList.contains('active')) {
            ov.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
</script>
@endpush
@endsection