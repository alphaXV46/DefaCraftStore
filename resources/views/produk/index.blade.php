@extends('layouts.app')

@section('title', 'Semua Produk - DefaCraftStore')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Semua Produk 🛍️</h1>
    
    <!-- Filter & Search -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('produk.index') }}" method="GET" class="row g-3">
                <!-- Search -->
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari produk..." value="{{ request('search') }}">
                </div>
                
                <!-- Filter Kategori -->
                <div class="col-md-4">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="Boneka" {{ request('kategori') == 'Boneka' ? 'selected' : '' }}>
                            Boneka
                        </option>
                        <option value="Aksesoris" {{ request('kategori') == 'Aksesoris' ? 'selected' : '' }}>
                            Aksesoris
                        </option>
                        <option value="Dekorasi" {{ request('kategori') == 'Dekorasi' ? 'selected' : '' }}>
                            Dekorasi
                        </option>
                    </select>
                </div>
                
                <!-- Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Daftar Produk -->
    @if($produk->isEmpty())
        <div class="alert alert-warning text-center">
            Tidak ada produk yang ditemukan.
        </div>
    @else
        <div class="row g-4">
            @foreach($produk as $item)
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
@endsection