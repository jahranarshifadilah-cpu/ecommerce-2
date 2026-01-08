@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 mb-1 fw-bold" style="color: #0f172a;">
                    <i class="bi bi-pencil-square me-2 text-slate-400"></i>Edit Produk
                </h2>
                <p class="text-muted small mb-0">Perbarui informasi, harga, dan ketersediaan stok produk Anda.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark rounded-3 px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- LEFT COLUMN --}}
                <div class="col-lg-8">
                    {{-- 1. Informasi Dasar --}}
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center" style="color: #334155;">
                                <span class="bg-slate-100 p-2 rounded-2 me-2 d-inline-flex">
                                    <i class="bi bi-info-circle" style="color: #0f172a;"></i>
                                </span>
                                Informasi Umum
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-slate-600">NAMA PRODUK</label>
                                <input type="text" name="name" class="form-control border-slate-200 shadow-none @error('name') is-invalid @enderror"
                                    value="{{ old('name', $product->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-slate-600">KATEGORI</label>
                                <select name="category_id" class="form-select border-slate-200 shadow-none @error('category_id') is-invalid @enderror" required>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-semibold small text-slate-600">DESKRIPSI LENGKAP</label>
                                <textarea name="description" id="editor" rows="10"
                                    class="form-control border-slate-200 shadow-none @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- 2. Manajemen Gambar --}}
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center" style="color: #334155;">
                                <span class="bg-slate-100 p-2 rounded-2 me-2 d-inline-flex">
                                    <i class="bi bi-images" style="color: #0f172a;"></i>
                                </span>
                                Galeri Produk
                            </h6>

                            <div class="upload-zone mb-4 p-4 border-2 border-dashed rounded-3 text-center bg-light">
                                <label class="form-label fw-semibold mb-2">Tambah Foto Baru</label>
                                <input type="file" name="images[]" class="form-control shadow-none" multiple>
                                <p class="text-muted small mt-2 mb-0">Format: JPG, PNG, WEBP. Bisa pilih lebih dari satu.</p>
                            </div>

                            <div class="row g-3">
                                @foreach($product->images as $image)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card h-100 shadow-sm border-0 overflow-hidden product-image-card">
                                        <img src="{{ asset('storage/'.$image->image_path) }}" class="card-img-top"
                                            style="object-fit:cover;height:140px">
                                        
                                        <div class="card-body p-2 bg-white">
                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="radio" name="primary_image"
                                                    id="primary_{{ $image->id }}" value="{{ $image->id }}" {{ $image->is_primary ? 'checked' : '' }}>
                                                <label class="form-check-label small fw-medium" for="primary_{{ $image->id }}">
                                                    Utama
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="delete_images[]"
                                                    id="del_{{ $image->id }}" value="{{ $image->id }}">
                                                <label class="form-check-label small text-danger fw-medium" for="del_{{ $image->id }}">
                                                    Hapus
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-lg-4">
                    {{-- 3. Harga & Stok --}}
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center" style="color: #334155;">
                                <span class="bg-slate-100 p-2 rounded-2 me-2 d-inline-flex">
                                    <i class="bi bi-tag" style="color: #0f172a;"></i>
                                </span>
                                Inventaris & Harga
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-slate-600">HARGA (RP)</label>
                                <div class="input-group">
                                    <span class="input-group-text border-slate-200 bg-light">Rp</span>
                                    <input type="number" name="price" class="form-control border-slate-200 shadow-none @error('price') is-invalid @enderror"
                                        value="{{ old('price', $product->price) }}" required>
                                </div>
                                @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-slate-600">HARGA DISKON (OPSIONAL)</label>
                                <div class="input-group">
                                    <span class="input-group-text border-slate-200 bg-light text-muted">Rp</span>
                                    <input type="number" name="discount_price" class="form-control border-slate-200 shadow-none @error('discount_price') is-invalid @enderror"
                                        value="{{ old('discount_price', $product->discount_price) }}">
                                </div>
                                @error('discount_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-semibold small text-slate-600">STOK</label>
                                    <input type="number" name="stock" class="form-control border-slate-200 shadow-none @error('stock') is-invalid @enderror"
                                        value="{{ old('stock', $product->stock) }}" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-semibold small text-slate-600">BERAT (GR)</label>
                                    <input type="number" name="weight" class="form-control border-slate-200 shadow-none @error('weight') is-invalid @enderror"
                                        value="{{ old('weight', $product->weight) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 4. Status & Visibility --}}
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center" style="color: #334155;">
                                <span class="bg-slate-100 p-2 rounded-2 me-2 d-inline-flex">
                                    <i class="bi bi-eye" style="color: #0f172a;"></i>
                                </span>
                                Pengaturan Visibilitas
                            </h6>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input shadow-none" type="checkbox" id="is_active" name="is_active" value="1" 
                                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium text-slate-700" for="is_active">Aktifkan Produk</label>
                                <p class="text-muted small mb-0">Produk akan tampil di katalog toko.</p>
                            </div>

                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input shadow-none" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                    {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium text-slate-700" for="is_featured">Produk Unggulan</label>
                                <p class="text-muted small mb-0">Muncul di section "Hot Products".</p>
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-lg rounded-3 border-0 py-3" style="background-color: #0f172a;">
                            <i class="bi bi-save2 me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .bg-slate-100 { background-color: #f1f5f9; }
    .border-slate-200 { border-color: #e2e8f0; }
    .text-slate-600 { color: #475569; }
    .border-dashed { border-style: dashed !important; }
    .product-image-card { transition: transform 0.2s; }
    .product-image-card:hover { transform: scale(1.02); }
    .form-switch .form-check-input:checked { background-color: #0f172a; border-color: #0f172a; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/ctgoj8efdfr1i2jqusoi0hyy1luhjn7lk7r8rnmmhe2f6r35/tinymce/8/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor',
        height: 400,
        menubar: false,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | link table | numlist bullist indent outdent | removeformat',
        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>
@endpush