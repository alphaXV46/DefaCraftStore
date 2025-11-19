@extends('layouts.app')

@section('title', 'Keranjang - DefaCraftStore')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">🛒 Keranjang Belanja</h1>
    
    @if($keranjang->isEmpty())
        <div class="card text-center py-5">
            <div class="card-body">
                <span class="display-1">🛒</span>
                <h3 class="mt-3">Keranjang Anda Kosong</h3>
                <p class="text-muted mb-4">Yuk belanja produk lucu kami!</p>
                <a href="{{ route('produk.index') }}" class="btn btn-primary btn-lg">
                    Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <div class="row">
            <!-- Daftar Item Keranjang -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        @foreach($keranjang as $item)
                            <div class="row align-items-center border-bottom py-3">
                                <!-- Gambar -->
                                <div class="col-md-2">
                                    @if($item->produk->gambar && file_exists(public_path('images/produk/' . $item->produk->gambar)))
                                        <img src="{{ asset('images/produk/' . $item->produk->gambar) }}" 
                                             class="img-fluid rounded" alt="{{ $item->produk->nama }}">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                             style="height: 80px;">
                                            <span>📦</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Info Produk -->
                                <div class="col-md-4">
                                    <h6 class="mb-1">{{ $item->produk->nama }}</h6>
                                    <small class="text-muted">{{ $item->produk->kategori }}</small>
                                </div>
                                
                                <!-- Harga -->
                                <div class="col-md-2">
                                    <p class="mb-0 fw-bold text-primary">
                                        Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <!-- Jumlah -->
                                <div class="col-md-2">
                                    <form action="{{ route('keranjang.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="jumlah" class="form-control" 
                                                   value="{{ $item->jumlah }}" min="1" max="99"
                                                   onchange="this.form.submit()">
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Subtotal & Hapus -->
                                <div class="col-md-2 text-end">
                                    <p class="mb-2 fw-bold">
                                        Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                    </p>
                                    <form action="{{ route('keranjang.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Hapus produk ini dari keranjang?')">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
                    ← Lanjut Belanja
                </a>
            </div>
            
            <!-- Summary -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkir</span>
                            <span class="text-muted">
                                @if($total >= 200000)
                                    <span class="badge bg-success">GRATIS</span>
                                @else
                                    Rp 15.000
                                @endif
                            </span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold price-tag">
                                Rp {{ number_format($total >= 200000 ? $total : $total + 15000, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        @if($total < 200000)
                            <div class="alert alert-info small mb-3">
                                💡 Belanja Rp {{ number_format(200000 - $total, 0, ',', '.') }} lagi untuk gratis ongkir!
                            </div>
                        @endif
                        
                        <div class="d-grid">
                            <a href="{{ route('transaksi.checkout') }}" class="btn btn-primary btn-lg">
                                Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection