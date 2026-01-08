@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="h3 mb-1 fw-bold" style="color: #0f172a;">Review Produk</h2>
                <p class="text-muted small mb-0">Melihat rincian lengkap dan status inventaris produk.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-dark px-4 rounded-3 shadow-sm" style="background-color: #0f172a;">
                    <i class="bi bi-pencil-square me-2"></i>Edit Produk
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row g-4">

            {{-- LEFT: Media Showcase --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-3">
                        {{-- Primary Image Showcase --}}
                        <div class="rounded-4 overflow-hidden border mb-3 bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                            <img src="{{ $product->primaryImage?->image_url ?? asset('img/no-image.png') }}" 
                                 class="img-fluid w-100 h-100 object-fit-cover" id="mainImageDisplay">
                        </div>

                        {{-- Gallery Thumbnails --}}
                        <div class="row g-2">
                            @foreach($product->images as $image)
                            <div class="col-3">
                                <div class="rounded-3 border overflow-hidden cursor-pointer thumbnail-box {{ $image->is_primary ? 'border-primary border-2' : '' }}" 
                                     onclick="changePreview(this, '{{ asset('storage/'.$image->image_path) }}')"
                                     style="height: 80px; cursor: pointer;">
                                    <img src="{{ asset('storage/'.$image->image_path) }}" 
                                         class="w-100 h-100 object-fit-cover opacity-hover">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Product Specifications --}}
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-slate-100 text-slate-600 px-3 py-2 rounded-pill mb-2 border">
                                    {{ $product->category->name }}
                                </span>
                                <h3 class="fw-bold text-slate-900 mb-0">{{ $product->name }}</h3>
                            </div>
                            <div class="text-end">
                                <span class="badge rounded-pill px-3 py-2" 
                                      style="font-size: 0.75rem; 
                                             background-color: {{ $product->is_active ? 'rgba(16, 185, 129, 0.1)' : 'rgba(100, 116, 139, 0.1)' }}; 
                                             color: {{ $product->is_active ? '#059669' : '#475569' }};">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @if($product->is_featured)
                                <div class="mt-2 text-warning small fw-bold">
                                    <i class="bi bi-star-fill me-1"></i> Produk Unggulan
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="price-section bg-light p-3 rounded-4 mb-4">
                            <label class="text-muted small fw-bold d-block mb-1">HARGA JUAL</label>
                            <h3 class="fw-bold mb-0" style="color: #0f172a;">
                                Rp {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}
                                @if($product->discount_price)
                                <span class="text-muted fs-5 text-decoration-line-through fw-normal ms-2">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                @endif
                            </h3>
                        </div>

                        <h6 class="fw-bold text-slate-700 mb-3">Deskripsi Produk</h6>
                        <div class="text-slate-600 mb-4 lh-lg" style="font-size: 0.95rem;">
                            {!! $product->description ?: '<em class="text-muted">Tidak ada deskripsi.</em>' !!}
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="p-3 border rounded-4 text-center">
                                    <div class="text-muted small fw-bold mb-1">STOK</div>
                                    <div class="h5 fw-bold mb-0 {{ $product->stock <= 5 ? 'text-danger' : 'text-slate-900' }}">
                                        {{ $product->stock }} <small class="fw-normal text-muted">Unit</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-3 border rounded-4 text-center">
                                    <div class="text-muted small fw-bold mb-1">BERAT</div>
                                    <div class="h5 fw-bold mb-0 text-slate-900">
                                        {{ $product->weight }} <small class="fw-normal text-muted">Gram</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-3 border rounded-4 text-center">
                                    <div class="text-muted small fw-bold mb-1">DIBUAT PADA</div>
                                    <div class="h5 fw-bold mb-0 text-slate-900" style="font-size: 1rem;">
                                        {{ $product->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-slate-100 { background-color: #f1f5f9; }
    .text-slate-600 { color: #475569; }
    .text-slate-900 { color: #0f172a; }
    .object-fit-cover { object-fit: cover; }
    .opacity-hover:hover { opacity: 0.8; transition: 0.3s; }
    .cursor-pointer { cursor: pointer; }
    .thumbnail-box.active { border-color: #0f172a !important; border-width: 2px; }
</style>

<script>
    function changePreview(element, src) {
        // Change main image
        document.getElementById('mainImageDisplay').src = src;
        
        // Update active thumbnail border
        document.querySelectorAll('.thumbnail-box').forEach(box => {
            box.classList.remove('border-primary', 'border-2', 'active');
        });
        element.classList.add('active', 'border-primary', 'border-2');
    }
</script>
@endsection