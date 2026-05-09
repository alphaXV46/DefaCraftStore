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
    @if($produk->gambar && file_exists(public_path('images/produk/' . $produk->gambar)))
        <img src="{{ asset('images/produk/' . $produk->gambar) }}"
             class="product-image" alt="{{ $produk->nama }}"
             width="600" height="600"
             loading="eager"
             fetchpriority="high"
             decoding="sync">
    @else
        <div class="placeholder-image">
            <span class="placeholder-icon">📦</span>
        </div>
    @endif

</div>
                <!-- Info Section -->
                <div class="info-section">
                    <div class="product-category">{{ $produk->kategori }}</div>
                    <h1 class="product-title">{{ $produk->nama }}</h1>
                    
                    <div class="product-price">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </div>
                    
                    <!-- Stock Info -->
                    <div class="stock-info">
                        <div class="stock-label">Ketersediaan:</div>
                        @if($produk->stok > 10)
                            <span class="stock-badge stock-available">
                                ✅ Stok Tersedia ({{ $produk->stok }})
                            </span>
                        @elseif($produk->stok > 0)
                            <span class="stock-badge stock-limited">
                                ⚠️ Stok Terbatas ({{ $produk->stok }})
                            </span>
                        @else
                            <span class="stock-badge stock-out">
                                ❌ Stok Habis
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
                                    
                                    <button type="submit" class="cart-button mt-3">
                                        🛒 Tambah ke Keranjang
                                    </button>
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
            <h3 class="section-title">Produk Terkait 🎨</h3>
            <div class="row g-4">

                
                @forelse($produkTerkait as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="related-product-card h-100">
                            <div class="related-product-image-wrapper">
                                @if($item->gambar && file_exists(public_path('images/produk/' . $item->gambar)))
                                    <img src="{{ asset('images/produk/' . $item->gambar) }}"
                                         class="related-product-image" alt="{{ $item->nama }}"
                                         width="300" height="280"
                                         loading="lazy" decoding="async">
                                @else
                                    <div class="related-product-placeholder">
                                        <span class="fs-1">📦</span>
                                    </div>
                                @endif
                            </div>
                            <div class="related-product-info">
                                <h5 class="related-product-name">{{ $item->nama }}</h5>
                                <div class="related-product-price">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
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