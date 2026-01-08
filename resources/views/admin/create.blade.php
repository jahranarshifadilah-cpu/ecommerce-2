{{-- resources/views/admin/products/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        {{-- Header Page --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 mb-1 text-slate-900 fw-bold">Tambah Produk Baru</h2>
                <p class="text-muted small">Kelola informasi produk, stok, dan kategori dalam satu tempat.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark px-4 rounded-3">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Kolom Kiri: Informasi Dasar --}}
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-semibold" style="color: #0f172a;">Nama Produk</label>
                                <input type="text" name="name" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       placeholder="Contoh: Sepatu Lari Ultra Boost"
                                       value="{{ old('name') }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Deskripsi Produk</label>
                                <textarea name="description" rows="5" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Jelaskan detail produk Anda di sini...">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">Rp</span>
                                        <input type="number" name="price" 
                                               class="form-control @error('price') is-invalid @enderror" 
                                               value="{{ old('price') }}" placeholder="0">
                                    </div>
                                    @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">Stok Inventaris</label>
                                    <input type="number" name="stock" 
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           value="{{ old('stock') }}" placeholder="0">
                                    @error('stock') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Kategori & Media --}}
                <div class="col-md-4">
                    {{-- Card Kategori --}}
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <label class="form-label fw-semibold">Kategori Produk</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Card Upload Gambar --}}
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <label class="form-label fw-semibold">Gambar Produk</label>
                            <div class="border-dashed border-2 p-3 text-center rounded-3 mb-3 bg-light" style="border-color: #cbd5e1 !important;">
                                <i class="ti ti-photo-plus fs-1 text-muted"></i>
                                <input type="file" name="images[]" multiple class="form-control mt-2" id="imageInput">
                                <p class="text-muted small mt-2">Maksimal 5 gambar (JPG, PNG)</p>
                            </div>
                            <div id="imagePreview" class="row g-2"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 shadow">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Produk
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview gambar sebelum diupload
    document.getElementById('imageInput').addEventListener('change', function() {
        const previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = '';
        
        [...this.files].forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-4';
                col.innerHTML = `
                    <div class="ratio ratio-1x1 rounded-3 overflow-hidden border shadow-sm">
                        <img src="${e.target.result}" class="object-fit-cover" alt="preview">
                    </div>
                `;
                previewContainer.appendChild(col);
            }
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush