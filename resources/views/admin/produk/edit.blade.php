@extends('layouts.admin')

@section('title', 'Edit Produk - Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">✏️ Edit Produk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Nama Produk <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $produk->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Boneka" {{ old('kategori', $produk->kategori) == 'Boneka' ? 'selected' : '' }}>
                                    Boneka
                                </option>
                                <option value="Aksesoris" {{ old('kategori', $produk->kategori) == 'Aksesoris' ? 'selected' : '' }}>
                                    Aksesoris
                                </option>
                                <option value="Dekorasi" {{ old('kategori', $produk->kategori) == 'Dekorasi' ? 'selected' : '' }}>
                                    Dekorasi
                                </option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Harga -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Harga (Rp) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="harga" 
                                class="form-control @error('harga') is-invalid @enderror" 
                                value="{{ old('harga', $produk->harga) }}" min="0" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TAMBAH INPUT STOK DI SINI 👇 -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Stok <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="stok" 
                                class="form-control @error('stok') is-invalid @enderror" 
                                value="{{ old('stok', $produk->stok) }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jumlah stok barang yang tersedia</small>
                        </div>
                        
                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi" rows="4" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Gambar Lama -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar Saat Ini</label>
                            <div>
                                @if($produk->gambar && file_exists(public_path('images/produk/' . $produk->gambar)))
                                    <img src="{{ asset('images/produk/' . $produk->gambar) }}" 
                                         class="img-thumbnail" width="200" alt="{{ $produk->nama }}">
                                @else
                                    <div class="bg-secondary rounded d-inline-flex align-items-center justify-content-center text-white" 
                                         style="width: 200px; height: 200px;">
                                        <span class="fs-1">📦</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Upload Gambar Baru -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Gambar Baru (Opsional)</label>
                            <input type="file" name="gambar" 
                                   class="form-control @error('gambar') is-invalid @enderror" 
                                   accept="image/*" onchange="previewImage(event)">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG. Maksimal 2MB</small>
                            
                            <!-- Preview Gambar Baru -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <p class="fw-bold">Preview Gambar Baru:</p>
                                <img id="preview" src="" class="img-thumbnail" width="200">
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                💾 Update Produk
                            </button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                                ❌ Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');
        preview.src = reader.result;
        previewDiv.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endpush
@endsection