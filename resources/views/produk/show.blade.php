@extends('layouts.app')

@section('title', $produk->nama . ' - DefaCraftStore')

@push('styles')
    @vite(['resources/css/produk-show.css'])
@endpush

@section('content')
<div class="product-detail-page">
    <div class="product-container">
<<<<<<< HEAD
        <div class="product-card shadow-sm border-0">
            <div class="product-content">
                <div class="image-section">
                    {{-- Pastikan path folder sinkron dengan controller (uploads/produk) --}}
                    @php $path = 'uploads/produk/' . $produk->gambar; @endphp
                    
                    @if($produk->gambar && file_exists(public_path($path)))
                        <img src="{{ asset($path) }}"
                             class="product-image img-fluid" alt="{{ $produk->nama }}"
                             style="width: 100%; height: auto; border-radius: 15px;"
                             loading="eager"
                             fetchpriority="high"
                             decoding="sync">
                    @else
                        <div class="placeholder-image d-flex align-items-center justify-content-center bg-light" style="height: 400px; border-radius: 15px;">
                            <span class="placeholder-icon" style="font-size: 4rem;">📦</span>
                        </div>
                    @endif
                </div>

                <div class="info-section p-4">
                    <div class="product-category badge bg-light text-primary mb-2 border">{{ $produk->kategori }}</div>
                    <h1 class="product-title fw-bold mb-3">{{ $produk->nama }}</h1>
                    
                    <div class="product-price mb-4">
                        @if($produk->harga_diskon)
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h2 class="text-danger fw-bold mb-0">
                                    Rp {{ number_format($produk->harga_diskon, 0, ',', '.') }}
                                </h2>
                                <del class="text-muted fs-5">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </del>
                                <span class="badge bg-danger rounded-pill">
                                    Hemat Rp {{ number_format($produk->harga - $produk->harga_diskon, 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <h2 class="text-dark fw-bold">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </h2>
                        @endif
                    </div>
                    
                    <div class="stock-info mb-4">
                        <div class="stock-label text-muted small mb-1">Ketersediaan:</div>
                        @if($produk->stok > 10)
                            <span class="badge bg-success-subtle text-success p-2">
                                ✅ Stok Tersedia ({{ $produk->stok }})
                            </span>
                        @elseif($produk->stok > 0)
                            <span class="badge bg-warning-subtle text-warning p-2">
                                ⚠️ Stok Terbatas ({{ $produk->stok }})
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger p-2">
=======
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
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
                                ❌ Stok Habis
                            </span>
                        @endif
                    </div>
                    
<<<<<<< HEAD
                    <div class="description-section mb-4 pb-4 border-bottom">
                        <h5 class="fw-bold">Deskripsi Produk</h5>
                        <p class="text-muted" style="line-height: 1.6;">{{ $produk->deskripsi }}</p>
                    </div>
                    
=======
                    <!-- Description -->
                    <div class="description-section">
                        <h5 class="description-title">Deskripsi Produk</h5>
                        <p class="description-text">{{ $produk->deskripsi }}</p>
                    </div>
                    
                    <!-- Form Section -->
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
                    <div class="form-section">
                        @auth
                            @if($produk->stok > 0)
                                <form action="{{ route('keranjang.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                    
<<<<<<< HEAD
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jumlah</label>
                                        <input type="number" name="jumlah" class="form-control" 
                                            style="width: 100px;"
                                            value="1" min="1" max="{{ $produk->stok }}" required>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold shadow-sm rounded-pill py-3">
=======
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="jumlah" class="quantity-input" 
                                        value="1" min="1" max="{{ $produk->stok }}" required>
                                    
                                    <button type="submit" class="cart-button mt-3">
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
                                        🛒 Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
<<<<<<< HEAD
                                <div class="alert alert-danger border-0 shadow-sm">
=======
                                <div class="alert-custom alert-danger-custom">
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
                                    <strong>Maaf, produk ini sedang habis.</strong>
                                </div>
                            @endif
                        @else
<<<<<<< HEAD
                            <div class="alert alert-info border-0 shadow-sm text-center">
                                <p class="mb-2">Silakan login untuk membeli produk ini</p>
                                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4">
=======
                            <div class="alert-custom alert-info-custom">
                                <p class="mb-2">Silakan login untuk membeli produk ini</p>
                                <a href="{{ route('login') }}" class="cart-button">
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
                                    Login Sekarang
                                </a>
                            </div>
                        @endauth
                    </div>
                    
<<<<<<< HEAD
                    <div class="mt-4">
                        <a href="{{ route('produk.index') }}" class="text-decoration-none text-muted small">
                            ← Kembali ke Produk
                        </a>
                    </div>
=======
                    <a href="{{ route('produk.index') }}" class="back-button">
                        ← Kembali ke Produk
                    </a>
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
                </div>
            </div>
        </div>
        
<<<<<<< HEAD
        <div class="related-products-section mt-5">
            <h3 class="section-title fw-bold mb-4">Produk Terkait 🎨</h3>
            <div class="row g-4">
                @forelse($produkTerkait as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm related-product-card rounded-4">
                            <div class="position-relative">
                                @php $itemPath = 'uploads/produk/' . $item->gambar; @endphp
                                @if($item->gambar && file_exists(public_path($itemPath)))
                                    <img src="{{ asset($itemPath) }}"
                                         class="card-img-top rounded-4" alt="{{ $item->nama }}"
                                         style="height: 200px; object-fit: cover;"
                                         loading="lazy">
                                @else
                                    <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <span class="fs-1">📦</span>
                                    </div>
                                @endif
                                
                                @if($item->harga_diskon)
                                    <span class="badge bg-danger position-absolute m-2 top-0 start-0">Promo</span>
                                @endif
                            </div>
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-1">{{ $item->nama }}</h6>
                                <div class="mb-2">
                                    @if($item->harga_diskon)
                                        <span class="text-danger fw-bold">Rp {{ number_format($item->harga_diskon, 0, ',', '.') }}</span><br>
                                        <small class="text-muted text-decoration-line-through">Rp {{ number_format($item->harga, 0, ',', '.') }}</small>
                                    @else
                                        <span class="text-dark fw-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('produk.show', $item->id) }}" 
                                   class="btn btn-outline-warning btn-sm w-100 rounded-pill fw-bold">
=======
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
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
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