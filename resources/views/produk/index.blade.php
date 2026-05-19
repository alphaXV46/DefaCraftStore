@extends('layouts.app')

@section('title', 'Semua Produk - DefaCraftStore')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Semua Produk <i class="fas fa-shopping-bag"></i></h1>
    
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
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
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
                        <!-- BUTTON LOVE 👇 -->
                        <button type="button" 
                                class="btn-love-sticker"
                                onclick="toggleWishlist({{ $item->id }}, this)"
                                data-produk-id="{{ $item->id }}">
                            @if(auth()->check() && auth()->user()->hasWishlist($item->id))
                                <span class="love-emoji" title="Hapus dari Wishlist">❤️</span>
                            @else
                                <span class="love-emoji" title="Tambah ke Wishlist">🤍</span>
                            @endif
                        </button>

                        <!-- DISKON BADGE -->
                        @if($item->harga_diskon && $item->harga_diskon < $item->harga)
                            @php
                                $persenDiskon = round((($item->harga - $item->harga_diskon) / $item->harga) * 100);
                            @endphp
                            <div class="badge bg-danger position-absolute mt-3 ms-3" style="z-index: 2; padding: 0.5rem 0.8rem; font-size: 0.85rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                Hemat {{ $persenDiskon }}%
                            </div>
                        @endif
                        
                        @php 
                            $pathBunglon = 'images/produk/' . $item->gambar;
                            $pathOlif = 'uploads/produk/' . $item->gambar;
                        @endphp

                        @if($item->gambar && file_exists(public_path($pathBunglon)))
                            <img src="{{ asset($pathBunglon) }}"
                                 class="card-img-top" alt="{{ $item->nama }}"
                                 width="300" height="200" style="object-fit: cover;"
                                 loading="lazy" decoding="async">
                        @elseif($item->gambar && file_exists(public_path($pathOlif)))
                            <img src="{{ asset($pathOlif) }}"
                                 class="card-img-top" alt="{{ $item->nama }}"
                                 width="300" height="200" style="object-fit: cover;"
                                 loading="lazy" decoding="async">
                        @else
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white" style="height: 200px;">
                                <span class="fs-1"><i class="fas fa-box"></i></span>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <!-- Kategori sebagai badge -->
                            <span class="badge badge-custom mb-2 align-self-start" style="z-index: 1;">
                                {{ $item->kategori->nama ?? 'Tanpa Kategori' }}
                            </span>
                            
                            <h2 class="card-title h5">{{ $item->nama }}</h2>
                            
                            <!-- Deskripsi dengan jarak dan batas tinggi -->
                            <p class="card-text text-muted small flex-grow-1 mb-2" style="min-height: 60px;">
                                {{ Str::limit($item->deskripsi, 60) }}
                            </p>
                            
                            <!-- Harga Logic -->
                            <div class="mb-3">
                                @if($item->harga_diskon && $item->harga_diskon > 0)
                                    <span class="text-muted text-decoration-line-through small" style="opacity: 0.7;">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </span><br>
                                    <div class="price-tag d-inline-block text-danger">
                                        Rp {{ number_format($item->harga_diskon, 0, ',', '.') }}
                                    </div>
                                @else
                                    <div class="price-tag d-inline-block">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('produk.show', $item->id) }}" 
                               class="btn btn-primary w-100 mt-auto">
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