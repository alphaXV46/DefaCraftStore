@extends('layouts.app')

@section('title', 'Semua Produk - DefaCraftStore')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Semua Produk 🛍️</h1>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('produk.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari produk..." value="{{ request('search') }}">
                </div>
                
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
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>
    
    @if($produk->isEmpty())
        <div class="alert alert-warning text-center">
            Tidak ada produk yang ditemukan.
        </div>
    @else
        <div class="row g-4">
            @foreach($produk as $item)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm position-relative">
                        
                        @auth
                            <button type="button" 
                                    class="btn btn-love position-absolute"
                                    style="top: 10px; right: 10px; z-index: 3; width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.9); border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"
                                    onclick="toggleWishlist({{ $item->id }}, this)">
                                @if(auth()->user()->hasWishlist($item->id))
                                    <span style="font-size: 1.2rem;">❤️</span>
                                @else
                                    <span style="font-size: 1.2rem;">🤍</span>
                                @endif
                            </button>
                        @endauth

                        @if($item->harga_diskon && $item->harga_diskon < $item->harga)
                            @php
                                $persenDiskon = round((($item->harga - $item->harga_diskon) / $item->harga) * 100);
                            @endphp
                            <div class="badge bg-danger position-absolute mt-2 ms-2" style="z-index: 2;">
                                Hemat {{ $persenDiskon }}%
                            </div>
                        @endif

                        @php $imagePath = 'uploads/produk/' . $item->gambar; @endphp
                        @if($item->gambar && file_exists(public_path($imagePath)))
                            <img src="{{ asset($imagePath) }}" class="card-img-top" alt="{{ $item->nama }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                                <span class="fs-1">📦</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column p-3">
                            <span class="badge bg-light text-primary mb-2 align-self-start border">
                                {{ $item->kategori->nama ?? 'Tanpa Kategori' }}
                            </span>

                            <h2 class="card-title h6 fw-bold mb-1">{{ $item->nama }}</h2>
                            
                            <p class="card-text text-muted small flex-grow-1 mb-2">
                                {{ Str::limit($item->deskripsi, 50) }}
                            </p>
                            
                            <div class="mb-3">
                                @if($item->harga_diskon && $item->harga_diskon > 0)
                                    <span class="text-muted text-decoration-line-through small">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </span><br>
                                    <span class="text-danger fw-bold fs-5">
                                        Rp {{ number_format($item->harga_diskon, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-primary fw-bold fs-5">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('produk.show', $item->id) }}" class="btn btn-primary w-100 mt-auto rounded-pill">
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