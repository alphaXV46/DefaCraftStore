@extends('layouts.admin')

@section('title', 'Tambah Produk - Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">➕ Tambah Produk Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Nama Produk <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama') }}" 
                                   placeholder="Contoh: Boneka Beruang Lucu" required>
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
                                <option value="Boneka" {{ old('kategori') == 'Boneka' ? 'selected' : '' }}>
                                    Boneka
                                </option>
                                <option value="Aksesoris" {{ old('kategori') == 'Aksesoris' ? 'selected' : '' }}>
                                    Aksesoris
                                </option>
                                <option value="Dekorasi" {{ old('kategori') == 'Dekorasi' ? 'selected' : '' }}>
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
                                value="{{ old('harga') }}" 
                                placeholder="150000" min="0" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Masukkan harga tanpa titik atau koma</small>
                        </div>

                        <!-- TAMBAH INPUT STOK DI SINI 👇 -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Stok <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="stok" 
                                class="form-control @error('stok') is-invalid @enderror" 
                                value="{{ old('stok', 0) }}" 
                                placeholder="50" min="0" required>
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
                                      placeholder="Deskripsikan produk Anda..." required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Gambar -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar Produk</label>
                            <input type="file" name="gambar" 
                                   class="form-control @error('gambar') is-invalid @enderror" 
                                   accept="image/*" onchange="previewImage(event)">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                            
                            <!-- Preview Gambar -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="preview" src="" class="img-thumbnail" width="200">
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                💾 Simpan Produk
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