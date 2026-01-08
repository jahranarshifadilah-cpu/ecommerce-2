@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 mb-1 fw-bold" style="color: #0f172a;">
                    <i class="bi bi-plus-circle me-2 text-slate-400"></i>Tambah Produk Baru
                </h2>
                <p class="text-muted small mb-0">Isi formulir di bawah ini untuk menambahkan koleksi produk baru ke toko Anda.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark rounded-3 px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- KOLOM KIRI: Konten Utama --}}
                <div class="col-lg-8">
                    {{-- 1. Informasi Produk --}}
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center" style="color: #334155;">
                                <span class="bg-slate-100 p-2 rounded-2 me-2 d-inline-flex">
                                    <i class="bi bi-info-circle" style="color: #0f172a;"></i>
                                </span>
                                Detil Produk
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-slate-600">NAMA PRODUK</label>
                                <input type="text" name="name" class="form-control border-slate-200 shadow-none @error('name') is-invalid @enderror"
                                    placeholder="Contoh: Kemeja Flanel Slim Fit" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-slate-600">KATEGORI</label>
                                <select name="category_id" class="form-select border-slate-200 shadow-none @error('category_id') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori Produk...</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-semibold small text-slate-600">DESKRIPSI LENGKAP</label>
                                <textarea name="description" id="editor" rows="10"
                                    class="form-control border-slate-200 shadow-none @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- 2. Media/Gambar --}}
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center" style="color: #334155;">
                                <span class="bg-slate-100 p-2 rounded-2 me-2 d-inline-flex">
                                    <i class="bi bi-images" style="color: #0f172a;"></i>
                                </span>
                                Visual Produk
                            </h6>

                            <div class="upload-zone p-5 border-2 border-dashed rounded-3 text-center bg-light">
                                <i class="bi bi-cloud-arrow-up fs-1 text-slate-400"></i>
                                <label class="form-label d-block fw-semibold mt-2">Pilih Foto Produk</label>
                                <input type="file" name="images[]" class="form-control shadow-none mt-3" multiple>
                                <p class="text-muted small mt-3 mb-0">
                                    Unggah hingga 10 gambar. Format: JPG, PNG, WEBP (Maks. 2MB/file).
                                </p>
                            </div>
                            @error('images') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                            @error('images.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: Inventaris & Aksi --}}
                <div class="col-lg-4">
                    {{-- 3. Inventaris & Harga --}}
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center" style="color: #334155;">
                                <span class="bg-slate-100 p-2 rounded-2 me-2 d-inline-flex">
                                    <i class="bi bi-tag" style="color: #0f172a;"></i>
                                </span>
                                Harga & Stok
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-slate-600">HARGA JUAL (RP)</label>
                                <div class="input-group">
                                    <span class="input-group-text border-slate-200 bg-light fw-medium">Rp</span>
                                    <input type="number" name="price" class="form-control border-slate-200 shadow-none @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}" placeholder="0" required>
                                </div>
                                @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-slate-600">HARGA DISKON (OPSIONAL)</label>
                                <div class="input-group">
                                    <span class="input-group-text border-slate-200 bg-light text-muted">Rp</span>
                                    <input type="number" name="discount_price" class="form-control border-slate-200 shadow-none @error('discount_price') is-invalid @enderror"
                                        value="{{ old('discount_price') }}" placeholder="0">
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-semibold small text-slate-600">JUMLAH STOK</label>
                                    <input type="number" name="stock" class="form-control border-slate-200 shadow-none @error('stock') is-invalid @enderror"
                                        value="{{ old('stock', 0) }}" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-semibold small text-slate-600">BERAT (GR)</label>
                                    <input type="number" name="weight" class="form-control border-slate-200 shadow-none @error('weight') is-invalid @enderror"
                                        value="{{ old('weight', 100) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 4. Status Produk --}}
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center" style="color: #334155;">
                                <span class="bg-slate-100 p-2 rounded-2 me-2 d-inline-flex">
                                    <i class="bi bi-toggle-on" style="color: #0f172a;"></i>
                                </span>
                                Publikasi
                            </h6>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input shadow-none" type="checkbox" id="is_active" name="is_active" value="1" 
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium text-slate-700" for="is_active">Aktifkan Sekarang</label>
                            </div>

                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input shadow-none" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                    {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium text-slate-700" for="is_featured">Set sebagai Unggulan</label>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="d-grid gap-2 mb-5">
                        <button type="submit" class="btn btn-dark btn-lg rounded-3 border-0 py-3 shadow" style="background-color: #0f172a;">
                            <i class="bi bi-check-lg me-2"></i>Simpan Produk Baru
                        </button>
                        <p class="text-center text-muted small mt-2">Pastikan semua data sudah benar sebelum menyimpan.</p>
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
    .form-switch .form-check-input:checked { background-color: #0f172a; border-color: #0f172a; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/ctgoj8efdfr1i2jqusoi0hyy1luhjn7lk7r8rnmmhe2f6r35/tinymce/8/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor',
        height: 350,
        menubar: false,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | link table | numlist bullist indent outdent | removeformat',
        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>
@endpush