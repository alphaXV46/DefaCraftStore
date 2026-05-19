<div class="product-card-enhanced">
    <!-- Badge -->
    @if($item->harga_diskon && $item->harga_diskon < $item->harga)
        @php
            $persenDiskon = round((($item->harga - $item->harga_diskon) / $item->harga) * 100);
        @endphp
        <span class="product-badge new bg-danger" style="background-color: #ef4444 !important;">Hemat {{ $persenDiskon }}%</span>
    @elseif($index % 3 == 0)
        <span class="product-badge new">NEW</span>
    @endif
    
    <!-- Image -->
    <div class="product-image-wrapper">
        @php 
            $pathBunglon = 'images/produk/' . rawurlencode($item->gambar);
            $pathOlif = 'uploads/produk/' . rawurlencode($item->gambar);
        @endphp
        
        @if($item->gambar && file_exists(public_path('images/produk/' . $item->gambar)))
            <img src="{{ asset($pathBunglon) }}"
                 srcset="{{ asset($pathBunglon) }} 480w, 
                         {{ asset($pathBunglon) }} 800w"
                 sizes="(max-width: 576px) 100vw, (max-width: 768px) 50vw, 300px"
                 class="img-fluid"
                 style="object-fit: cover; width: 100%; height: 100%; aspect-ratio: 1/1;"
                 alt="{{ $item->nama }}"
                 width="300" height="300"
                 loading="lazy" decoding="async">
        @elseif($item->gambar && file_exists(public_path('uploads/produk/' . $item->gambar)))
            <img src="{{ asset($pathOlif) }}"
                 srcset="{{ asset($pathOlif) }} 480w, 
                         {{ asset($pathOlif) }} 800w"
                 sizes="(max-width: 576px) 100vw, (max-width: 768px) 50vw, 300px"
                 class="img-fluid"
                 style="object-fit: cover; width: 100%; height: 100%; aspect-ratio: 1/1;"
                 alt="{{ $item->nama }}"
                 width="300" height="300"
                 loading="lazy" decoding="async">
        @else
            <img src="data:image/svg+xml,%3Csvg width='300' height='300' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='300' height='300' fill='%23e2e8f0'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' fill='%2394a3b8' font-size='60' dy='.3em'%3E<i class="fas fa-box"></i>%3C/text%3E%3C/svg%3E"
                 class="img-fluid"
                 style="object-fit: cover; width: 100%; height: 100%; aspect-ratio: 1/1;"
                 alt="{{ $item->nama }}"
                 width="300" height="300"
                 loading="lazy" decoding="async">
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
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="overlay-btn" title="Login untuk Beli">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            @endauth
        </div>
    </div>
    
    <!-- Info -->
    <div class="product-info">
        <div class="product-category">{{ $item->kategori->nama ?? $item->kategori ?? 'Tanpa Kategori' }}</div>
        <h3 class="product-name">{{ $item->nama }}</h3>
        
        <!-- Rating -->
        <div class="product-rating">
            <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            <span class="rating-count">({{ rand(10, 100) }})</span>
        </div>
        
        <!-- Price -->
        <div class="product-price-row">
            <div>
                @if($item->harga_diskon && $item->harga_diskon > 0)
                    <span class="product-price text-danger">Rp {{ number_format($item->harga_diskon, 0, ',', '.') }}</span>
                    <span class="product-price-old">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                @else
                    <span class="product-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                @endif
            </div>
        </div>
        
        <!-- Add to Cart Button -->
        @auth
            <form action="{{ route('keranjang.store') }}" method="POST" class="d-flex gap-2">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $item->id }}">
                <input type="hidden" name="jumlah" value="1">
                <button type="submit" class="btn-add-cart flex-grow-1 px-1">
                    <i class="fas fa-shopping-cart"></i> Cart
                </button>
                <button type="submit" formaction="{{ route('beli-langsung') }}" class="btn-add-cart flex-grow-1 px-1" style="background-color: #10b981;">
                    <i class="fas fa-bolt"></i> Beli
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-add-cart text-center text-white text-decoration-none d-block">
                Login untuk Beli
            </a>
        @endauth
    </div>
</div>