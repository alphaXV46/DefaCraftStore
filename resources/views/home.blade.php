@extends('layouts.app')

@section('title', 'Home - DefaCraftStore | Kerajinan Tangan Modern')

@push('styles')
    @vite(['resources/css/home.css'])
@endpush

@section('content')
<!-- Hero Section Modern -->
<section class="hero-modern">
    <!-- Animasi Latar Belakang -->
    <div class="abstract-art-container">
        @include('partials.hero-svg')
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">
                    Kerajinan Tangan<br>
                    <span class="hero-title__highlight">Lucu & Unik</span> 
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
                <div class="hero-image__placeholder"></div>
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
            <p class="fs-5 mb-0">Yuk Buruan, penawaran terbatas!</p>
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
                    @include('partials.product-card', ['item' => $item, 'index' => $index])
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
        <x-feature-item icon="🚚" title="Gratis Ongkir" desc="Gratis ongkir untuk pembelian di atas Rp 200.000" />
        <x-feature-item icon="💎" title="Kualitas Terbaik" desc="100% handmade dengan bahan pilihan berkualitas" />
        <x-feature-item icon="🔒" title="Pembayaran Aman" desc="Sistem pembayaran terpercaya dan terenkripsi" />
        <x-feature-item icon="⭐" title="Kepuasan Terjamin" desc="Garansi 100% uang kembali jika tidak puas" />
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
                <x-testimonial-card 
                    text="Bonekanya super lucu dan kualitasnya bagus banget! Pengiriman cepat dan packingnya rapi. Pasti bakal order lagi!" 
                    initials="SA" 
                    name="Siti Aminah" 
                    location="Jakarta" 
                />
            </div>
            <div class="col-md-4">
                <x-testimonial-card 
                    text="Aksesorisnya unik-unik dan harganya terjangkau. Cocok banget buat kado! Adminnya juga responsif dan ramah." 
                    initials="BP" 
                    name="Budi Prasetyo" 
                    location="Bandung" 
                />
            </div>
            <div class="col-md-4">
                <x-testimonial-card 
                    text="Dekorasi kamarku jadi makin aesthetic sejak belanja di sini. Produknya handmade dan detail banget!" 
                    initials="DL" 
                    name="Dewi Lestari" 
                    location="Surabaya" 
                />
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
        if (!element) return;
        const target = parseInt(element.getAttribute('data-count'));
        if (isNaN(target)) return;
        
        const duration = 2000;
        let startTimestamp = null;
        
        const labelEl = element.parentElement ? element.parentElement.querySelector('.stat-label') : null;
        const label = labelEl ? labelEl.textContent : '';
        const suffix = label === 'Kepuasan' ? '%' : '+';

        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const current = Math.floor(progress * target);
            
            element.textContent = current + suffix;
            
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                element.textContent = target + suffix;
            }
        };
        
        window.requestAnimationFrame(step);
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
        threshold: 0.1, 
        rootMargin: '0px 0px -50px 0px' 
    };
    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && entry.target) {
                entry.target.classList.add('animate');
            }
        });
    }, observerOptions);
    document.querySelectorAll('.scroll-animate').forEach(el => {
        scrollObserver.observe(el);
    });
    

</script>
@endpush