@extends('layouts.app')

@section('title', $produk->nama . ' - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Gambar Produk -->
        <div class="col-md-6">
            @if($produk->gambar && file_exists(public_path('images/produk/' . $produk->gambar)))
                <img src="{{ asset('images/produk/' . $produk->gambar) }}" 
                     class="img-fluid rounded shadow" alt="{{ $produk->nama }}">
            @else
                <div class="bg-secondary rounded shadow d-flex align-items-center justify-content-center" 
                     style="height: 400px;">
                    <span class="display-1">📦</span>
                </div>
            @endif
        </div>
        
        <!-- Info Produk -->
        <div class="col-md-6">
            <span class="badge badge-custom mb-3">{{ $produk->kategori }}</span>
            <h1 class="fw-bold mb-3">{{ $produk->nama }}</h1>
            
            <div class="price-tag mb-4">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </div>
            
            <div class="mb-4">
                <h5 class="fw-bold">Deskripsi Produk</h5>
                <p class="text-muted">{{ $produk->deskripsi }}</p>
            </div>
            
            <!-- Form Tambah ke Keranjang -->
            @auth
                <form action="{{ route('keranjang.store') }}" method="POST" class="mb-3">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" 
                                   value="1" min="1" max="99" required>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            🛒 Tambah ke Keranjang
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-info">
                    <p class="mb-2">Silakan login untuk membeli produk ini</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login Sekarang</a>
                </div>
            @endauth
            
            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
                ← Kembali ke Produk
            </a>
        </div>
    </div>
    
    <!-- Produk Terkait -->
    <div class="mt-5">
        <h3 class="fw-bold mb-4">Produk Terkait 🎨</h3>
        <div class="row g-4">
            @php
                $produkTerkait = \App\Models\Produk::where('kategori', $produk->kategori)
                                                    ->where('id', '!=', $produk->id)
                                                    ->limit(4)
                                                    ->get();
            @endphp
            
            @forelse($produkTerkait as $item)
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100">
                        @if($item->gambar && file_exists(public_path('images/produk/' . $item->gambar)))
                            <img src="{{ asset('images/produk/' . $item->gambar) }}" 
                                 class="card-img-top" alt="{{ $item->nama }}">
                        @else
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white">
                                <span class="fs-1">📦</span>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }}</h5>
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
            @empty
                <div class="col-12">
                    <p class="text-muted">Tidak ada produk terkait.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection