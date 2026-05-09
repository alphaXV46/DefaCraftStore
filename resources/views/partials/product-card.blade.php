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
            <img src="{{ asset('images/produk/' . $item->gambar) }}"
                 alt="{{ $item->nama }}"
                 width="300" height="280"
                 loading="lazy"
                 decoding="async">
        @else
            <img src="data:image/svg+xml,%3Csvg width='300' height='280' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='300' height='280' fill='%23e2e8f0'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' fill='%2394a3b8' font-size='60' dy='.3em'%3E📦%3C/text%3E%3C/svg%3E"
                 alt="{{ $item->nama }}"
                 width="300" height="280"
                 loading="lazy"
                 decoding="async">
        @endif
        
        <!-- Overlay Buttons -->
        <div class="product-overlay">
            <a href="{{ route('produk.show', $item->id) }}" class="overlay-btn" title="Lihat Detail">
                👁️
            </a>
            @auth
                <form action="{{ route('keranjang.store') }}" method="POST" class="d-inline">
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
        <h3 class="product-name">{{ $item->nama }}</h3>
        
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