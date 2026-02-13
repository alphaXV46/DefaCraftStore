@extends('layouts.app')

@section('title', $produk->nama . ' - DefaCraftStore')

@push('styles')
<style>
    /* ===============================
       PRODUCT DETAIL PAGE STYLES (Shopee-like)
       =============================== */
    
    /* Page Background - Lebih terang */
    .product-detail-page {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f0f9ff 100%);
        min-height: 100vh;
        padding: 2rem 0;
        position: relative;
        overflow-x: hidden;
    }
    
    .product-detail-page::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
        z-index: -1;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Product Container */
    .product-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    /* Main Product Card - Glassmorphism & Elegan */
    .product-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
        z-index: 2;
    }
    
    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #8979d4ff, #71b1b9ff, #7b6ec5ff); /* Warna utama Shopee */
        z-index: 3;
    }
    
    /* Product Content */
    .product-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        padding: 3rem;
    }
    
    @media (max-width: 992px) {
        .product-content {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem;
        }
    }
    
    /* Image Section */
    .image-section {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        padding: 2rem;
        min-height: 500px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .product-image {
        width: 100%;
        max-width: 400px;
        height: 400px;
        object-fit: contain;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        border: 4px solid rgba(255, 255, 255, 0.8);
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .placeholder-image {
        width: 100%;
        max-width: 400px;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(238, 238, 238, 0.8); /* Lebih terang dari sebelumnya */
        border-radius: 16px;
        border: 4px solid rgba(255, 255, 255, 0.8);
    }
    
    .placeholder-icon {
        font-size: 6rem;
        color: rgba(0, 0, 0, 0.1); /* Lebih gelap dari sebelumnya */
    }
    
    /* Info Section */
    .info-section {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .product-category {
        background: linear-gradient(135deg, #63926dff, #66bdbdff);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.875rem;
        display: inline-block;
        width: fit-content;
        margin-bottom: 1rem;
        box-shadow: 0 4px 12px rgba(238, 77, 45, 0.3);
    }
    
    .product-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1rem;
        line-height: 1.2;
    }
    
    .product-price {
        font-size: 2.25rem;
        font-weight: 900;
        color: #6a68d4ff;
        margin-bottom: 1.5rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    /* Stock Info - Adaptasi Shopee */
    .stock-info {
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: rgba(238, 77, 45, 0.05);
        border-radius: 12px;
        border-left: 4px solid #65aebbff;
    }
    
    .stock-label {
        color: #334155;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .stock-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .stock-available {
        background: rgba(16, 185, 129, 0.2);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .stock-limited {
        background: rgba(245, 158, 11, 0.2);
        color: #92400e;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .stock-out {
        background: rgba(239, 68, 68, 0.2);
        color: #3b0505ff;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    /* Description */
    .description-section {
        margin: 1.5rem 0 2rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .description-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.75rem;
    }
    
    .description-text {
        color: #334155;
        line-height: 1.7;
        font-size: 1.1rem;
    }
    
    /* Form Section */
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-label {
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .quantity-input {
        background: rgba(255, 255, 255, 0.8);
        border: 2px solid #cbd5e1;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        color: #0f172a;
        font-size: 1rem;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .quantity-input:focus {
        outline: none;
        border-color: #ee2dd4ff;
        background: rgba(255, 255, 255, 1);
        box-shadow: 0 0 0 4px rgba(238, 77, 45, 0.2);
    }
    
    .cart-button {
        background: linear-gradient(135deg, #5ebec2ff, #226d63ff);
        color: white;
        border: none;
        border-radius: 16px;
        padding: 1rem 2rem;
        font-weight: 700;
        font-size: 1.1rem;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(238, 77, 45, 0.3);
    }
    
    .cart-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(238, 77, 45, 0.4);
    }
    
    .cart-button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    /* Alert Styles - Modern */
    .alert-custom {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 16px;
        padding: 1.5rem;
        color: #0f172a;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow-sm);
    }
    
    .alert-success-custom {
        background: rgba(16, 185, 129, 0.1);
        border-color: rgba(16, 185, 129, 0.3);
        color: #065f46;
    }
    
    .alert-info-custom {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
        color: #1e40af;
    }
    
    .alert-danger-custom {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.3);
        color: #000000ff;
    }
    
    /* Back Button */
    .back-button {
        background: rgba(255, 255, 255, 0.8);
        color: #0f172a;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 16px;
        padding: 0.75rem 1.5rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .back-button:hover {
        background: rgba(238, 77, 45, 0.1);
        color: #000000ff;
        border-color: #000000ff;
        transform: translateY(-2px);
    }
    
    /* Related Products Section */
    .related-products-section {
        margin-top: 4rem;
        position: relative;
        z-index: 2;
    }
    
    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #21225eff, #669b98ff);
        border-radius: 2px;
    }
    
    /* Related Product Card - Mirip Produk Home */
    .related-product-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all var(--transition-base);
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .related-product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-2xl);
        border-color: rgba(212, 162, 152, 0.3);
    }
    
    .related-product-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 200px;
        background: rgba(255, 255, 255, 0.8);
    }
    
    .related-product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-slow);
    }
    
    .related-product-card:hover .related-product-image {
        transform: scale(1.1);
    }
    
    .related-product-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(0, 0, 0, 0.2);
    }
    
    .related-product-info {
        padding: 1.5rem;
    }
    
    .related-product-name {
        font-weight: 700;
        font-size: 1.1rem;
        color: #0f172a;
        margin-bottom: 0.5rem;
        transition: color var(--transition-base);
    }
    
    .related-product-card:hover .related-product-name {
        color: #000000ff;
    }
    
    .related-product-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ee4d2d;
        margin-bottom: 1rem;
    }
    
    .related-product-button {
        background: rgba(255, 255, 255, 0.8);
        color: #0f172a;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .related-product-button:hover {
        background: rgba(238, 77, 45, 0.1);
        color: #000000ff;
        border-color: #000000ff;
        transform: translateY(-2px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .product-content {
            padding: 1.5rem;
            gap: 1.5rem;
        }
        
        .image-section {
            min-height: 300px;
            padding: 1.5rem;
        }
        
        .product-title {
            font-size: 2rem;
        }
        
        .product-price {
            font-size: 1.75rem;
        }
        
        .section-title {
            font-size: 1.75rem;
        }
    }
    
    @media (max-width: 576px) {
        .product-content {
            padding: 1rem;
            gap: 1rem;
        }
        
        .image-section {
            min-height: 250px;
            padding: 1rem;
        }
        
        .product-title {
            font-size: 1.75rem;
        }
        
        .product-price {
            font-size: 1.5rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .quantity-input {
            padding: 0.625rem 0.875rem;
        }
        
        .cart-button {
            padding: 0.875rem 1.5rem;
        }
    }
</style>
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
                             class="product-image" alt="{{ $produk->nama }}">
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
                @php
                    $produkTerkait = \App\Models\Produk::where('kategori', $produk->kategori)
                                                        ->where('id', '!=', $produk->id)
                                                        ->limit(4)
                                                        ->get();
                @endphp
                
                @forelse($produkTerkait as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="related-product-card h-100">
                            <div class="related-product-image-wrapper">
                                @if($item->gambar && file_exists(public_path('images/produk/' . $item->gambar)))
                                    <img src="{{ asset('images/produk/' . $item->gambar) }}" 
                                         class="related-product-image" alt="{{ $item->nama }}">
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
@endsection