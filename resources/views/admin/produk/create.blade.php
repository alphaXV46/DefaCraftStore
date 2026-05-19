@extends('layouts.admin')

@section('title', 'Tambah Produk - Admin')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<style>
    .img-container { 
        max-height: 400px; 
        overflow: hidden;
    }
    #image-to-crop { 
        display: block;
        max-width: 100%; 
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus"></i> Tambah Produk Baru</h4>
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
                            <label class="form-label fw-bold">Kategori Produk <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select rounded-3 @error('kategori_id') is-invalid @enderror" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Kategori tidak ada? 
                                <a href="{{ route('admin.kategori.index') }}" target="_blank">Tambah di sini</a>
                            </small>
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

                        <!-- Harga Diskon -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Diskon (Rp) <small class="text-muted">(Opsional)</small></label>
                            <input type="number" name="harga_diskon" class="form-control" value="{{ old('harga_diskon') }}" placeholder="Contoh: 125000">
                            <small class="text-info">Isi jika ingin menampilkan harga coret.</small>
                        </div>

                        <!-- Status Publikasi -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Publikasi</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" value="published" id="statusSwitch" checked>
                                <label class="form-check-label" for="statusSwitch">Langsung Terbitkan (Published)</label>
                            </div>
                            <small class="text-muted">Jika dimatikan, barang akan masuk ke Draf.</small>
                        </div>

                        <!-- Stok -->
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
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>

                            <!-- Cropper Modal -->
                            <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="img-container">
                                                <img id="image-to-crop">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-primary" id="cropButton">Potong & Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="cropped_image" id="cropped_image">
                            
                            <!-- Preview Gambar -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="preview" src="" class="img-thumbnail" width="200">
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Produk
                            </button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let cropper;
        const imageInput = document.querySelector('input[name="gambar"]');
        const imageToCrop = document.getElementById('image-to-crop');
        const cropperModalElement = document.getElementById('cropperModal');
        const cropButton = document.getElementById('cropButton');
        const croppedImageInput = document.getElementById('cropped_image');
        const previewDisplay = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');
        
        let cropperModal;

        imageInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imageToCrop.src = event.target.result;
                    
                    if (!cropperModal) {
                        cropperModal = new bootstrap.Modal(cropperModalElement);
                    }
                    cropperModal.show();
                };
                reader.readAsDataURL(files[0]);
            }
        });

        cropperModalElement.addEventListener('shown.bs.modal', function() {
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1 / 1,
                viewMode: 2,
                autoCropArea: 1,
            });
        });

        cropperModalElement.addEventListener('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            if (!croppedImageInput.value) {
                imageInput.value = "";
            }
        });

        cropButton.addEventListener('click', function() {
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas({
                width: 600,
                height: 600,
            });

            const base64Image = canvas.toDataURL('image/jpeg');
            
            croppedImageInput.value = base64Image;

            previewDisplay.src = base64Image;
            previewDiv.style.display = 'block';

            cropperModal.hide();
        });
    });
</script>
@endpush
@endsection