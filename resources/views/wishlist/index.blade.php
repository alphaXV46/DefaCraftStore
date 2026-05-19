@extends('layouts.app')

@section('title', 'Wishlist - DefaCraftStore')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4"><i class="fas fa-heart"></i> Wishlist Saya</h1>
    
    @if($wishlist->isEmpty())
        <div class="card text-center py-5">
            <div class="card-body">
                <span class="display-1"><i class="fas fa-heart-broken"></i></span>
                <h3 class="mt-3">Wishlist Anda Kosong</h3>
                <p class="text-muted mb-4">Simpan produk favorit Anda di sini!</p>
                <a href="{{ route('produk.index') }}" class="btn btn-primary btn-lg">
                    Jelajahi Produk
                </a>
            </div>
        </div>
    @else
        
        <div class="row g-4">
            @foreach($wishlist as $item)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <!-- Gambar Produk -->
                        <div class="position-relative">
                            @if($item->produk->gambar && file_exists(public_path('images/produk/' . $item->produk->gambar)))
                                <img src="{{ asset('images/produk/' . $item->produk->gambar) }}"
                                     class="card-img-top" alt="{{ $item->produk->nama }}"
                                     width="300" height="240"
                                     style="height: 240px; object-fit: cover;"
                                     loading="lazy" decoding="async">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white"
                                     style="height: 240px;">
                                    <span class="fs-1"><i class="fas fa-box"></i></span>
                                </div>
                            @endif
                            
                            <!-- Badge Stok -->
                            @if($item->produk->stok > 0)
                                <span class="position-absolute top-0 end-0 m-2 badge bg-success">
                                    Stok: {{ $item->produk->stok }}
                                </span>
                            @else
                                <span class="position-absolute top-0 end-0 m-2 badge bg-danger">
                                    Habis
                                </span>
                            @endif
                            
                            <!-- Button Remove Love -->
                            <button type="button" 
                                    class="btn btn-danger position-absolute top-0 start-0 m-2 btn-sm rounded-circle"
                                    onclick="removeFromWishlist({{ $item->id }})"
                                    style="width: 40px; height: 40px;">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <span class="badge badge-custom mb-2 align-self-start">
                                {{ $item->produk->kategori }}
                            </span>
                            <h2 class="card-title h5">{{ $item->produk->nama }}</h2>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($item->produk->deskripsi, 60) }}
                            </p>
                            <div class="price-tag mb-3">
                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                            </div>
                            
                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                @if($item->produk->stok > 0)
                                    <form action="{{ route('wishlist.move.cart', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-shopping-cart"></i> Pindah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        Stok Habis
                                    </button>
                                @endif
                                
                                <a href="{{ route('produk.show', $item->produk_id) }}" 
                                   class="btn btn-outline-primary">
                                     Lihat Detail
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-light text-muted small">
                            Ditambahkan {{ $item->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary btn-lg">
                Cari Produk Lainnya
            </a>
        </div>
    @endif
</div>

<!-- Form Hidden untuk Remove -->
<form id="removeWishlistForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function removeFromWishlist(itemId) {
    if (confirm('Hapus dari wishlist?')) {
        const form = document.getElementById('removeWishlistForm');
        form.action = `/wishlist/${itemId}`;
        form.submit();
    }
}
</script>
@endpush
@endsection