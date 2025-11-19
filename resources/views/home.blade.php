@extends('layouts.app')

@section('title', 'Home - DefaCraftStore')

@section('content')
<!-- Hero Banner -->
<div class="hero-banner">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Selamat Datang di DefaCraftStore! 🎨</h1>
        <p class="lead mb-4">Temukan kerajinan tangan lucu dan unik untuk mempercantik harimu</p>
        <a href="{{ route('produk.index') }}" class="btn btn-light btn-lg px-5 rounded-pill">
            Belanja Sekarang 🛍️
        </a>
    </div>
</div>

<div class="container">
    <!-- Kategori Section -->
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-4">Kategori Produk</h2>
        <div class="row justify-content-center g-3">
            <div class="col-md-3">
                <a href="{{ route('produk.index', ['kategori' => 'Aksesoris']) }}" 
                   class="btn category-btn w-100">
                    👜 Aksesoris
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('produk.index', ['kategori' => 'Dekorasi']) }}" 
                   class="btn category-btn w-100">
                    🏮 Dekorasi
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('produk.index', ['kategori' => 'Boneka']) }}" 
                   class="btn category-btn w-100">
                    🧸 Boneka
                </a>
            </div>
        </div>
    </div>
    
    <!-- Produk Terbaru -->
    <div class="mb-5">
        <h2 class="fw-bold mb-4 text-center">Produk Terbaru ✨</h2>
        
        @if($produk->isEmpty())
            <div class="alert alert-info text-center">
                Belum ada produk tersedia.
            </div>
        @else
            <div class="row g-4">
                @foreach($produk as $item)
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100">
                            <!-- Gambar Produk -->
                            @if($item->gambar && file_exists(public_path('images/produk/' . $item->gambar)))
                                <img src="{{ asset('images/produk/' . $item->gambar) }}" 
                                     class="card-img-top" alt="{{ $item->nama }}">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white">
                                    <span class="fs-1">📦</span>
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <span class="badge badge-custom mb-2 align-self-start">
                                    {{ $item->kategori }}
                                </span>
                                <h5 class="card-title">{{ $item->nama }}</h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($item->deskripsi, 60) }}
                                </p>
                                <div class="price-tag mb-3">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('produk.show', $item->id) }}" 
                                   class="btn btn-primary w-100">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    
    <!-- Promo Banner -->
    <div class="card bg-primary text-white mb-5">
        <div class="card-body text-center py-5">
            <h3 class="fw-bold">🎉 Promo Spesial!</h3>
            <p class="lead">Gratis ongkir untuk pembelian di atas Rp 200.000</p>
            <a href="{{ route('produk.index') }}" class="btn btn-light btn-lg">Belanja Sekarang</a>
        </div>
    </div>
</div>
@endsection