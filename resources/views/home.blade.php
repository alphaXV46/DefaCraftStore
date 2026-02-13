@extends('layouts.app')
@section('title', 'Home - DefaCraftStore | Kerajinan Tangan Modern')
@push('styles')
<style>
    /* ===============================
       HOME PAGE SPECIFIC STYLES
       =============================== */
    
    /* Hero Section */
    .hero-modern {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        position: relative;
        overflow: hidden;
        padding: 6rem 0 4rem;
        margin-bottom: 4rem;
    }
    
    /* Animasi Latar Belakang Tegas & Kontras */
    .abstract-art-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
    }
    
    .abstract-art-svg {
        width: 100%;
        height: 100%;
        opacity: 0.8;
    }
    
    .abstract-path {
        stroke-dasharray: 1000;
        stroke-dashoffset: 1000;
        animation: draw 3s ease-in-out forwards;
        opacity: 0;
    }
    
    .abstract-circle {
        opacity: 0;
        animation: appear 0.8s ease-in-out 2.5s forwards;
    }
    
    /* Individual path animations for staggered effect */
    .abstract-path:nth-child(1) { animation-delay: 0.1s; }
    .abstract-path:nth-child(2) { animation-delay: 0.2s; }
    .abstract-path:nth-child(3) { animation-delay: 0.3s; }
    .abstract-path:nth-child(4) { animation-delay: 0.4s; }
    .abstract-path:nth-child(5) { animation-delay: 0.5s; }
    .abstract-path:nth-child(6) { animation-delay: 0.6s; }
    .abstract-path:nth-child(7) { animation-delay: 0.7s; }
    .abstract-path:nth-child(8) { animation-delay: 0.8s; }
    .abstract-path:nth-child(9) { animation-delay: 0.9s; }
    .abstract-path:nth-child(10) { animation-delay: 1.0s; }
    .abstract-path:nth-child(11) { animation-delay: 1.1s; }
    .abstract-path:nth-child(12) { animation-delay: 1.2s; }
    .abstract-path:nth-child(13) { animation-delay: 1.3s; }
    .abstract-path:nth-child(14) { animation-delay: 1.4s; }
    
    @keyframes draw {
        to {
            stroke-dashoffset: 0;
            opacity: 1;
        }
    }
    
    @keyframes appear {
        to {
            opacity: 1;
            transform: scale(1.2);
        }
    }
    
    /* Continuous subtle animation for dynamic effect */
    .abstract-path {
        animation: draw 3s ease-in-out forwards, float 5s ease-in-out infinite alternate;
    }
    
    .abstract-circle {
        animation: appear 0.8s ease-in-out 2.5s forwards, pulse 2.5s ease-in-out infinite alternate;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-8px) rotate(3deg); }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.9; }
        50% { transform: scale(1.4); opacity: 1; }
    }
    
    /* Background gradient animation */
    .abstract-art-container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(
            from 0deg at 50% 50%,
            #4F46E5,
            #06B6D4,
            #F59E0B,
            #EC4899,
            #8B5CF6,
            #10B981
        );
        animation: rotate 15s linear infinite;
        opacity: 0.15;
        pointer-events: none;
        z-index: -1;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Additional floating particles */
    .abstract-art-container::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(79, 70, 229, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(6, 182, 212, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(245, 158, 11, 0.3) 0%, transparent 50%);
        animation: float-particles 10s ease-in-out infinite;
        pointer-events: none;
        z-index: -1;
    }
    
    @keyframes float-particles {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-30px) rotate(150deg); }
        66% { transform: translateY(20px) rotate(300deg); }
    }
    
    /* Hero Content - Dijadikan lebih kontras dengan z-index */
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .hero-title {
        font-size: 4rem;
        font-weight: 900;
        color: var(--white);
        line-height: 1.1;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.8s ease-out;
    }
    
    .hero-subtitle {
        font-size: 1.5rem;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 2.5rem;
        animation: fadeInUp 0.8s ease-out 0.2s backwards;
    }
    
    .hero-cta {
        animation: fadeInUp 0.8s ease-out 0.4s backwards;
    }
    
    .hero-image {
        position: relative;
        z-index: 1;
        animation: fadeInUp 0.8s ease-out 0.3s backwards;
    }
    
    .hero-image img {
        max-width: 100%;
        filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
        animation: floatImage 3s ease-in-out infinite;
    }
    
    @keyframes floatImage {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    /* Scroll-triggered animation base */
    .scroll-animate {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    
    .scroll-animate.animate {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Stats Counter */
    .stats-section {
        background: var(--white);
        border-radius: var(--radius-2xl);
        padding: 3rem;
        margin: -4rem auto 4rem;
        max-width: 1200px;
        box-shadow: var(--shadow-2xl);
        position: relative;
        z-index: 10;
    }
    
    .stat-item {
        text-align: center;
        padding: 1rem;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 900;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: var(--gray-600);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    /* Featured Categories */
    .category-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        padding: 2rem;
        text-align: center;
        transition: all var(--transition-base);
        border: 2px solid transparent;
        cursor: pointer;
        height: 100%;
    }
    
    .category-card:hover {
        border-color: var(--primary);
        transform: translateY(-10px);
        box-shadow: var(--shadow-colored);
    }
    
    .category-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: var(--gradient-primary);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        transition: all var(--transition-base);
    }
    
    .category-card:hover .category-icon {
        transform: rotateY(360deg);
    }
    
    .category-name {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }
    
    .category-count {
        color: var(--gray-600);
        font-size: 0.875rem;
    }
    
    /* Flash Sale Section */
    .flash-sale-section {
        background: var(--gradient-secondary);
        border-radius: var(--radius-2xl);
        padding: 3rem;
        margin-bottom: 4rem;
        position: relative;
        overflow: hidden;
    }
    
    .flash-sale-section::before {
        content: '⚡';
        position: absolute;
        font-size: 15rem;
        opacity: 0.1;
        right: -3rem;
        top: -3rem;
        animation: pulse 2s infinite;
    }
    
    .flash-badge {
        background: var(--white);
        color: var(--danger);
        padding: 0.5rem 1.5rem;
        border-radius: var(--radius-full);
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        animation: bounce 1s infinite;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    .countdown {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 1.5rem;
    }
    
    .countdown-item {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        text-align: center;
        min-width: 80px;
    }
    
    .countdown-number {
        font-size: 2rem;
        font-weight: 900;
        color: var(--white);
        line-height: 1;
    }
    
    .countdown-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.9);
        text-transform: uppercase;
        margin-top: 0.25rem;
    }
    
    /* Product Grid Enhanced */
    .product-filters {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    
    .filter-tag {
        padding: 0.5rem 1.5rem;
        border-radius: var(--radius-full);
        background: var(--white);
        border: 2px solid var(--gray-200);
        color: var(--gray-900);
        font-weight: 600;
        cursor: pointer;
        transition: all var(--transition-base);
    }
    
    .filter-tag:hover, .filter-tag.active {
        background: var(--gradient-primary);
        color: var(--white);
        border-color: transparent;
        transform: translateY(-2px);
    }
    
    .product-card-enhanced {
        position: relative;
        background: var(--white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all var(--transition-base);
        height: 100%;
    }
    
    .product-card-enhanced:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-2xl);
    }
    
    .product-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: var(--danger);
        color: var(--white);
        padding: 0.375rem 0.875rem;
        border-radius: var(--radius-full);
        font-weight: 700;
        font-size: 0.75rem;
        z-index: 2;
        animation: pulse 2s infinite;
    }
    
    .product-badge.new {
        background: var(--success);
    }
    
    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 280px;
    }
    
    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-slow);
    }
    
    .product-card-enhanced:hover .product-image-wrapper img {
        transform: scale(1.1);
    }
    
    .product-overlay {
        position: absolute;
        inset: 0;
        background: rgba(79, 70, 229, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        opacity: 0;
        transition: all var(--transition-base);
    }
    
    .product-card-enhanced:hover .product-overlay {
        opacity: 1;
    }
    
    .overlay-btn {
        width: 50px;
        height: 50px;
        background: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.25rem;
        transition: all var(--transition-base);
        cursor: pointer;
    }
    
    .overlay-btn:hover {
        transform: scale(1.1) rotate(360deg);
    }
    
    .product-info {
        padding: 1.5rem;
    }
    
    .product-category {
        font-size: 0.75rem;
        color: var(--primary);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    
    .product-name {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--dark);
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }
    
    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .stars {
        color: #FFA726;
        font-size: 0.875rem;
    }
    
    .rating-count {
        color: var(--gray-600);
        font-size: 0.875rem;
    }
    
    .product-price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .product-price {
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--primary);
    }
    
    .product-price-old {
        font-size: 1rem;
        color: var(--gray-400);
        text-decoration: line-through;
        margin-left: 0.5rem;
    }
    
    .btn-add-cart {
        width: 100%;
        background: var(--gradient-primary);
        color: var(--white);
        border: none;
        padding: 0.875rem;
        border-radius: var(--radius-lg);
        font-weight: 700;
        transition: all var(--transition-base);
    }
    
    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-colored);
    }
    
    /* Testimonial Section */
    .testimonial-section {
        background: var(--gradient-dark);
        padding: 5rem 0;
        margin: 5rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .testimonial-section::before {
        content: '"';
        position: absolute;
        font-size: 30rem;
        color: rgba(255, 255, 255, 0.05);
        top: -5rem;
        left: 2rem;
        font-family: Georgia, serif;
    }
    
    .testimonial-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-xl);
        padding: 2.5rem;
        color: var(--white);
        height: 100%;
    }
    
    .testimonial-text {
        font-size: 1.125rem;
        line-height: 1.8;
        margin-bottom: 1.5rem;
        font-style: italic;
    }
    
    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .author-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .author-info h5 {
        color: var(--white);
        margin-bottom: 0.25rem;
        font-weight: 700;
    }
    
    .author-info p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.875rem;
        margin-bottom: 0;
    }
    
    /* Newsletter Section */
    .newsletter-section {
        background: var(--gradient-accent);
        border-radius: var(--radius-2xl);
        padding: 4rem 3rem;
        margin: 4rem auto;
        max-width: 900px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .newsletter-section::before {
        content: '✉️';
        position: absolute;
        font-size: 12rem;
        opacity: 0.1;
        right: -2rem;
        bottom: -2rem;
    }
    
    .newsletter-title {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--white);
        margin-bottom: 1rem;
    }
    
    .newsletter-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.125rem;
        margin-bottom: 2rem;
    }
    
    .newsletter-form {
        max-width: 500px;
        margin: 0 auto;
        display: flex;
        gap: 1rem;
    }
    
    .newsletter-form input {
        flex: 1;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        border: none;
        font-size: 1rem;
    }
    
    .newsletter-form button {
        padding: 1rem 2rem;
        background: var(--dark);
        color: var(--white);
        border: none;
        border-radius: var(--radius-lg);
        font-weight: 700;
        white-space: nowrap;
        transition: all var(--transition-base);
    }
    
    .newsletter-form button:hover {
        background: var(--gray-900);
        transform: translateY(-2px);
    }
    
    /* Brands Carousel */
    .brands-section {
        padding: 3rem 0;
        background: var(--gray-100);
    }
    
    .brand-logo {
        height: 60px;
        opacity: 0.5;
        transition: all var(--transition-base);
        filter: grayscale(100%);
    }
    
    .brand-logo:hover {
        opacity: 1;
        filter: grayscale(0%);
        transform: scale(1.1);
    }
    
    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin: 4rem 0;
    }
    
    .feature-item {
        text-align: center;
        padding: 2rem;
        background: var(--white);
        border-radius: var(--radius-xl);
        transition: all var(--transition-base);
    }
    
    .feature-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: var(--gradient-primary);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }
    
    .feature-title {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--dark);
        margin-bottom: 0.75rem;
    }
    
    .feature-desc {
        color: var(--gray-600);
        font-size: 0.9375rem;
        line-height: 1.6;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.125rem;
        }
        
        .stats-section {
            padding: 2rem 1rem;
            margin: -3rem 1rem 3rem;
        }
        
        .stat-number {
            font-size: 2rem;
        }
        
        .newsletter-form {
            flex-direction: column;
        }
        
        .countdown {
            gap: 0.5rem;
        }
        
        .countdown-item {
            min-width: 60px;
            padding: 0.75rem 1rem;
        }
        
        .countdown-number {
            font-size: 1.5rem;
        }
    }
</style>
@endpush
@section('content')
<!-- Hero Section Modern -->
<section class="hero-modern">
    <!-- Animasi Latar Belakang -->
    <div class="abstract-art-container">
        <svg class="abstract-art-svg" viewBox="0 0 500 400" preserveAspectRatio="xMidYMid meet">
            
            <!-- Complex abstract shapes -->
            <path class="abstract-path" d="M50,200 Q150,100 250,200 T450,200" stroke="url(#grad1)" stroke-width="2.5" fill="none"/>
            <path class="abstract-path" d="M50,250 Q200,350 350,250 T450,250" stroke="url(#grad2)" stroke-width="2.5" fill="none"/>
            <path class="abstract-path" d="M100,100 Q250,50 400,100" stroke="url(#grad1)" stroke-width="2" fill="none"/>
            <path class="abstract-path" d="M100,300 Q250,350 400,300" stroke="url(#grad2)" stroke-width="2" fill="none"/>
            <!-- Intersecting lines -->
            <path class="abstract-path" d="M150,50 L150,350" stroke="url(#grad1)" stroke-width="1.5" fill="none"/>
            <path class="abstract-path" d="M250,50 L250,350" stroke="url(#grad2)" stroke-width="1.5" fill="none"/>
            <path class="abstract-path" d="M350,50 L350,350" stroke="url(#grad1)" stroke-width="1.5" fill="none"/>
            <!-- Diagonal elements -->
            <path class="abstract-path" d="M50,50 L450,350" stroke="url(#grad1)" stroke-width="1.2" fill="none"/>
            <path class="abstract-path" d="M450,50 L50,350" stroke="url(#grad2)" stroke-width="1.2" fill="none"/>
            <path class="abstract-path" d="M100,50 L400,350" stroke="url(#grad1)" stroke-width="1" fill="none"/>
            <path class="abstract-path" d="M400,50 L100,350" stroke="url(#grad2)" stroke-width="1" fill="none"/>
            <!-- Curved elements -->
            <path class="abstract-path" d="M50,150 Q150,50 250,150 T450,150" stroke="url(#grad1)" stroke-width="1.5" fill="none"/>
            <path class="abstract-path" d="M50,250 Q150,350 250,250 T450,250" stroke="url(#grad2)" stroke-width="1.5" fill="none"/>
            <!-- Floating circles -->
            <circle class="abstract-circle" cx="150" cy="100" r="6" fill="url(#grad1)"/>
            <circle class="abstract-circle" cx="350" cy="300" r="6" fill="url(#grad2)"/>
            <circle class="abstract-circle" cx="250" cy="200" r="9" fill="url(#grad1)"/>
            <circle class="abstract-circle" cx="100" cy="250" r="5" fill="url(#grad2)"/>
            <circle class="abstract-circle" cx="400" cy="150" r="5" fill="url(#grad1)"/>
        </svg>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">
                    Kerajinan Tangan<br>
                    <span style="color: #FFA726;">Lucu & Unik</span> ✨
                </h1>
                <p class="hero-subtitle">
                    Temukan koleksi handmade terbaik untuk mempercantik hari-harimu
                </p>
                <div class="hero-cta d-flex gap-3">
                    <a href="{{ route('produk.index') }}" class="btn btn-light btn-lg">
                        🛍️ Belanja Sekarang
                    </a>
                    <a href="#featured" class="btn btn-outline-light btn-lg">
                        Lihat Koleksi
                    </a>
                </div>
            </div>
            <div class="col-lg-6 hero-image">
                <!-- Placeholder untuk gambar hero jika ingin ditambahkan -->
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.3); font-size: 4rem;">
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Stats Counter -->
<div class="container scroll-animate" data-animation="slide-up">
    <div class="stats-section">
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number" data-count="12">0</div>
                    <div class="stat-label">Produk</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number" data-count="8">0</div>
                    <div class="stat-label">Pelanggan</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number" data-count="25">0</div>
                    <div class="stat-label">Pesanan</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number" data-count="99">0</div>
                    <div class="stat-label">Kepuasan</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Featured Categories -->
<section class="container mb-5 scroll-animate" data-animation="slide-up" id="featured">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-5 mb-3">Kategori Pilihan</h2>
        <p class="text-muted fs-5">Jelajahi koleksi berdasarkan kategori favorit</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('produk.index', ['kategori' => 'Boneka']) }}" class="text-decoration-none">
                <div class="category-card">
                    <div class="category-icon">🧸</div>
                    <h3 class="category-name">Boneka</h3>
                    <p class="category-count">120+ Produk</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('produk.index', ['kategori' => 'Aksesoris']) }}" class="text-decoration-none">
                <div class="category-card">
                    <div class="category-icon">👜</div>
                    <h3 class="category-name">Aksesoris</h3>
                    <p class="category-count">80+ Produk</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('produk.index', ['kategori' => 'Dekorasi']) }}" class="text-decoration-none">
                <div class="category-card">
                    <div class="category-icon">🏮</div>
                    <h3 class="category-name">Dekorasi</h3>
                    <p class="category-count">95+ Produk</p>
                </div>
            </a>
        </div>
    </div>
</section>
<!-- Flash Sale Section -->
<div class="container scroll-animate" data-animation="slide-up">
    <div class="flash-sale-section">
        <div class="text-center text-white">
            <div class="flash-badge">
                ⚡ FLASH SALE
            </div>
            <h2 class="fw-bold display-6 mb-2">Diskon Hingga 50%!</h2>
            <p class="fs-5 mb-0">Buruan, penawaran terbatas!</p>
            <!-- Countdown Timer -->
            <div class="countdown">
                <div class="countdown-item">
                    <div class="countdown-number" id="hours">00</div>
                    <div class="countdown-label">Jam</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="minutes">00</div>
                    <div class="countdown-label">Menit</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="seconds">00</div>
                    <div class="countdown-label">Detik</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Grid Enhanced -->
<section class="container mb-5 scroll-animate" data-animation="slide-up">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-5 mb-3">Produk Terbaru</h2>
        <p class="text-muted fs-5 mb-4">Koleksi terbaru pilihan terbaik untuk Anda</p>
        <!-- Filter Tags -->
        <div class="product-filters">
            <button class="filter-tag active" data-filter="all">Semua</button>
            <button class="filter-tag" data-filter="new">Terbaru</button>
            <button class="filter-tag" data-filter="sale">Diskon</button>
            <button class="filter-tag" data-filter="popular">Populer</button>
        </div>
    </div>
    @if($produk->isEmpty())
        <div class="alert alert-info text-center scroll-animate" data-animation="slide-up">
            Belum ada produk tersedia.
        </div>
    @else
        <div class="row g-4" id="productGrid">
            @foreach($produk as $index => $item)
                <div class="col-lg-3 col-md-4 col-sm-6 product-item scroll-animate" data-animation="slide-up" data-category="{{ $index % 3 == 0 ? 'new' : ($index % 2 == 0 ? 'sale' : 'popular') }}">
                    <div class="product-card-enhanced">
                        <!-- Badge -->
                        @if($index % 3 == 0)
                            <span class="product-badge new">NEW</span>
                        @elseif($index % 2 == 0)
                            <span class="product-badge">-25%</span>
                        @endif
                        
                        
                        
                        <!-- Image -->
                        <div class="product-image-wrapper">
                            @if($item->gambar && file_exists(public_path('images/produk/' . $item->gambar)))
                                <img src="{{ asset('images/produk/' . $item->gambar) }}" alt="{{ $item->nama }}">
                            @else
                                <img src="data:image/svg+xml,%3Csvg width='300' height='280' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='300' height='280' fill='%23e2e8f0'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' fill='%2394a3b8' font-size='60' dy='.3em'%3E📦%3C/text%3E%3C/svg%3E" alt="{{ $item->nama }}">
                            @endif
                            <!-- Overlay Buttons -->
                            <div class="product-overlay">
                                <a href="{{ route('produk.show', $item->id) }}" class="overlay-btn" title="Lihat Detail">
                                    👁️
                                </a>
                                @auth
                                    <form action="{{ route('keranjang.store') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                        <input type="hidden" name="jumlah" value="1">
                                        <button type="submit" class="overlay-btn" title="Tambah ke Keranjang">
                                            🛒
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="overlay-btn" title="Login untuk Beli">
                                        🛒
                                    </a>
                                @endauth
                            </div>
                        </div>
                        <!-- Info -->
                        <div class="product-info">
                            <div class="product-category">{{ $item->kategori }}</div>
                            <h5 class="product-name">{{ $item->nama }}</h5>
                            <!-- Rating -->
                            <div class="product-rating">
                                <div class="stars">⭐⭐⭐⭐⭐</div>
                                <span class="rating-count">({{ rand(10, 100) }})</span>
                            </div>
                            <!-- Price -->
                            <div class="product-price-row">
                                <div>
                                    <span class="product-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    @if($index % 2 == 0)
                                        <span class="product-price-old">Rp {{ number_format($item->harga *1.33, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Add to Cart Button -->
                            @auth
                                <form action="{{ route('keranjang.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn-add-cart">
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-add-cart text-center text-white text-decoration-none d-block">
                                    Login untuk Beli
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5 scroll-animate" data-animation="slide-up">
            <a href="{{ route('produk.index') }}" class="btn btn-outline-primary btn-lg">
                Lihat Semua Produk →
            </a>
        </div>
    @endif
</section>
<!-- Features Grid -->
<section class="container mb-5 scroll-animate" data-animation="slide-up">
    <div class="features-grid">
        <div class="feature-item">
            <div class="feature-icon">🚚</div>
            <h4 class="feature-title">Gratis Ongkir</h4>
            <p class="feature-desc">Gratis ongkir untuk pembelian di atas Rp 200.000</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">💎</div>
            <h4 class="feature-title">Kualitas Terbaik</h4>
            <p class="feature-desc">100% handmade dengan bahan pilihan berkualitas</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🔒</div>
            <h4 class="feature-title">Pembayaran Aman</h4>
            <p class="feature-desc">Sistem pembayaran terpercaya dan terenkripsi</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">⭐</div>
            <h4 class="feature-title">Kepuasan Terjamin</h4>
            <p class="feature-desc">Garansi 100% uang kembali jika tidak puas</p>
        </div>
    </div>
</section>
<!-- Testimonials -->
<section class="testimonial-section scroll-animate" data-animation="slide-up">
    <div class="container">
        <div class="text-center text-white mb-5">
            <h2 class="fw-bold display-5 mb-3">Kata Pelanggan Kami</h2>
            <p class="fs-5">Apa kata mereka yang sudah belanja di DefaCraftStore</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Bonekanya super lucu dan kualitasnya bagus banget! Pengiriman cepat dan packingnya rapi. Pasti bakal order lagi!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">SA</div>
                        <div class="author-info">
                            <h5>Siti Aminah</h5>
                            <p>Jakarta</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Aksesorisnya unik-unik dan harganya terjangkau. Cocok banget buat kado! Adminnya juga responsif dan ramah."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">BP</div>
                        <div class="author-info">
                            <h5>Budi Prasetyo</h5>
                            <p>Bandung</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Dekorasi kamarku jadi makin aesthetic sejak belanja di sini. Produknya handmade dan detail banget!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">DL</div>
                        <div class="author-info">
                            <h5>Dewi Lestari</h5>
                            <p>Surabaya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Newsletter -->
<div class="container scroll-animate" data-animation="slide-up">
    <div class="newsletter-section">
        <h2 class="newsletter-title">Dapatkan Penawaran Spesial!</h2>
        <p class="newsletter-subtitle">
            Subscribe newsletter kami dan dapatkan diskon 10% untuk pembelian pertama
        </p>
        <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Terima kasih! Kamu akan mendapat email konfirmasi.');">
            <input type="email" placeholder="Masukkan email kamu..." required>
            <button type="submit">Subscribe</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Counter Animation
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-count'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                element.textContent = target + (element.parentElement.querySelector('.stat-label').textContent === 'Kepuasan' ? '%' : '+');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current) + (element.parentElement.querySelector('.stat-label').textContent === 'Kepuasan' ? '%' : '+');
            }
        }, 16);
    }
    // Intersection Observer for counter
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('.stat-number');
                counters.forEach(counter => animateCounter(counter));
                observer.unobserve(entry.target);
            }
        });
    });
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        observer.observe(statsSection);
    }
    // Countdown Timer (24 hours from now)
    function updateCountdown() {
        const now = new Date().getTime();
        const end = new Date(now + 24 * 60 * 60 * 1000).getTime();
        const distance = end - now;
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
    // Product Filter
    const filterTags = document.querySelectorAll('.filter-tag');
    const productItems = document.querySelectorAll('.product-item');
    filterTags.forEach(tag => {
        tag.addEventListener('click', () => {
            // Update active state
            filterTags.forEach(t => t.classList.remove('active'));
            tag.classList.add('active');
            const filter = tag.getAttribute('data-filter');
            // Filter products
            productItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    // Scroll-triggered animations
    const observerOptions = {
        threshold: 0.1, // Trigger when 10% of element is visible
        rootMargin: '0px 0px -50px 0px' // Trigger 50px before element enters viewport
    };
    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                // Optional: Stop observing after animation is triggered
                // scrollObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);
    // Observe all elements with the scroll-animate class
    document.querySelectorAll('.scroll-animate').forEach(el => {
        scrollObserver.observe(el);
    });
    
    // Fungsi toggleWishlist sederhana (perlu diintegrasikan dengan AJAX dan backend)
    function toggleWishlist(produkId, buttonElement) {
        // Kirim permintaan AJAX ke server
        fetch(`/wishlist/toggle/${produkId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Ganti ikon dan status berdasarkan respons server
            if (data.status === 'added') {
                buttonElement.innerHTML = '<span style="font-size: 1.5rem;">❤️</span>';
            } else if (data.status === 'removed') {
                buttonElement.innerHTML = '<span style="font-size: 1.5rem;">🤍</span>';
            }
        })
        .catch(error => {
            console.error('Error toggling wishlist:', error);
            // Tampilkan pesan error ke pengguna jika diperlukan
        });
    }
</script>
@endpush