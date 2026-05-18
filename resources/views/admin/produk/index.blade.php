@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">📦 Kelola Produk</h1>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                ← Dashboard
            </a>
            <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                ➕ Tambah Produk Baru
            </a>
        </div>
    </div>
<<<<<<< HEAD
    <form action="{{ route('admin.produk.index') }}" method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
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
        <button type="submit" class="btn btn-primary w-100">Cari</button>
    </div>
</form>
=======
    
    <!-- Card Daftar Produk -->
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
    <div class="card shadow">
        <div class="card-body">
            @if($produk->isEmpty())
                <div class="text-center py-5">
                    <span class="display-3">📦</span>
                    <h4 class="mt-3">Belum Ada Produk</h4>
                    <p class="text-muted">Tambahkan produk pertama Anda!</p>
                    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                        Tambah Produk
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80">Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
<<<<<<< HEAD
                                <th>Stok</th>
                                <th>Status</th> <th width="150" class="text-center">Aksi</th>
=======
                                <th>Stok</th>  <!-- TAMBAH INI -->
                                <th>Deskripsi</th>
                                <th width="200" class="text-center">Aksi</th>
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produk as $item)
<<<<<<< HEAD
                            <tr>
                                <td>
                                    @if($item->gambar && file_exists(public_path('uploads/produk/' . $item->gambar)))
                                        <img src="{{ asset('uploads/produk/' . $item->gambar) }}" 
                                             class="rounded" width="60" height="60" 
                                             style="object-fit: cover;" alt="{{ $item->nama }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px; border: 1px dashed #ccc;">
                                            <span>📦</span>
                                        </div>
                                    @endif
                                </td>
                                
                                <td>
                                    <strong>{{ $item->nama }}</strong>
                                </td>
                                
                                <td>
                                    <span class="badge bg-info text-dark">{{ $item->kategori->nama ?? 'Tanpa Kategori' }}</span>
                                </td>
                                
                                <td>
                                    <div class="fw-bold text-primary">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </div>
                                    @if($item->harga_diskon)
                                        <small class="text-danger text-decoration-line-through">
                                            Rp {{ number_format($item->harga_diskon, 0, ',', '.') }}
                                        </small>
                                    @endif
                                </td>
                                
                                <td>
                                    @if($item->stok > 10)
                                        <span class="badge bg-success">{{ $item->stok }}</span>
                                    @elseif($item->stok > 0)
                                        <span class="badge bg-warning text-dark">{{ $item->stok }}</span>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item->status == 'published')
                                            <span class="badge bg-success">Tayang</span>
                                        @else
                                            <span class="badge bg-secondary">Draf</span>
                                        @endif
                                        
                                        <form action="{{ route('admin.produk.toggle-status', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-primary" style="padding: 0px 5px; font-size: 10px;" title="Ubah Status">
                                                🔄
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.produk.edit', $item->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('admin.produk.destroy', $item->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
=======
                                <tr>
                                    <!-- Gambar -->
                                    <td>
                                        @if($item->gambar && file_exists(public_path('images/produk/' . $item->gambar)))
                                            <img src="{{ asset('images/produk/' . $item->gambar) }}" 
                                                class="rounded" width="60" height="60" 
                                                style="object-fit: cover;" alt="{{ $item->nama }}">
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                style="width: 60px; height: 60px;">
                                                <span>📦</span>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <!-- Nama -->
                                    <td>
                                        <strong>{{ $item->nama }}</strong>
                                    </td>
                                    
                                    <!-- Kategori -->
                                    <td>
                                        <span class="badge badge-custom">{{ $item->kategori }}</span>
                                    </td>
                                    
                                    <!-- Harga -->
                                    <td>
                                        <span class="fw-bold text-primary">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    
                                    <!-- STOK 👇 TAMBAH INI -->
                                    <td>
                                        @if($item->stok > 10)
                                            <span class="badge bg-success">{{ $item->stok }}</span>
                                        @elseif($item->stok > 0)
                                            <span class="badge bg-warning">{{ $item->stok }}</span>
                                        @else
                                            <span class="badge bg-danger">Habis</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Deskripsi -->
                                    <td>
                                        <small class="text-muted">
                                            {{ Str::limit($item->deskripsi, 50) }}
                                        </small>
                                    </td>
                                    
                                    <!-- Aksi -->
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('produk.show', $item->id) }}" 
                                            class="btn btn-sm btn-info" title="Lihat" target="_blank">
                                                👁️
                                            </a>
                                            <a href="{{ route('admin.produk.edit', $item->id) }}" 
                                            class="btn btn-sm btn-warning" title="Ed    it">
                                                ✏️
                                            </a>
                                            <form action="{{ route('admin.produk.destroy', $item->id) }}" 
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
<<<<<<< HEAD
                <div class="mt-3 d-flex justify-content-between">
                    <p class="text-muted">Total: <strong>{{ $produk->count() }}</strong> produk</p>
=======
                <div class="mt-3">
                    <p class="text-muted mb-0">Total: <strong>{{ $produk->count() }}</strong> produk</p>
>>>>>>> 55be931ee8bbfb5a5db858b94ac065ca9e173cd3
                </div>
            @endif
        </div>
    </div>
</div>
@endsection