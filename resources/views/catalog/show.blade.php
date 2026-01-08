{{-- resources/views/catalog/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="min-vh-100 py-5" style="background-color: #f8fafc;">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted">Katalog</a></li>
                <li class="breadcrumb-item active fw-bold" style="color: #0f172a;" aria-current="page">{{ Str::limit($product->name, 20) }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            {{-- Bagian Kiri: Visual Produk --}}
            <div class="col-lg-6">
                <div class="position-sticky" style="top: 20px;">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        {{-- Main Image Display --}}
                        <div class="main-image-container p-4 d-flex align-items-center justify-content-center" style="height: 500px; background-color: #fff;">
                            <img src="{{ $product->image_url }}"
                                 id="main-image"
                                 class="img-fluid"
                                 alt="{{ $product->name }}"
                                 style="max-height: 100%; object-fit: contain;">

                            @if($product->has_discount)
                                <span class="badge position-absolute top-0 start-0 m-4 px-3 py-2 rounded-pill shadow-sm" style="background-color: #ef4444;">
                                    Hemat {{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>

                        {{-- Gallery Thumbnails --}}
                        @if($product->images->count() > 1)
                            <div class="card-footer bg-white border-0 p-4 pt-0">
                                <div class="d-flex gap-3 overflow-auto pb-2 custom-scrollbar">
                                    @foreach($product->images as $image)
                                        <div class="thumb-wrapper rounded-3 border p-1 cursor-pointer transition-all" 
                                             onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}', this)">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                 class="rounded-2"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Informasi Produk --}}
            <div class="col-lg-6">
                <div class="ps-lg-4">
                    {{-- Category & Brand --}}
                    <nav class="mb-2">
                        <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
                           class="text-decoration-none small fw-bold text-uppercase tracking-wider" style="color: #64748b; letter-spacing: 1px;">
                            {{ $product->category->name }}
                        </a>
                    </nav>

                    <h1 class="display-6 fw-bold mb-3" style="color: #0f172a;">{{ $product->name }}</h1>

                    {{-- Pricing --}}
                    <div class="d-flex align-items-center mb-4">
                        <h2 class="fw-bold mb-0 me-3" style="color: #0f172a;">{{ $product->formatted_price }}</h2>
                        @if($product->has_discount)
                            <span class="text-muted text-decoration-line-through fs-5">
                                {{ $product->formatted_original_price }}
                            </span>
                        @endif
                    </div>

                    {{-- Stock Status --}}
                    <div class="mb-4">
                        @if($product->stock > 10)
                            <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-success bg-opacity-10 text-success small fw-bold">
                                <span class="dot bg-success me-2"></span> Stok Tersedia
                            </div>
                        @elseif($product->stock > 0)
                            <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-warning bg-opacity-10 text-warning small fw-bold">
                                <span class="dot bg-warning me-2"></span> Stok Terbatas: {{ $product->stock }} sisa
                            </div>
                        @else
                            <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-danger bg-opacity-10 text-danger small fw-bold">
                                <span class="dot bg-danger me-2"></span> Stok Habis
                            </div>
                        @endif
                    </div>

                    <hr class="my-4 border-light">

                    {{-- Add to Cart Action --}}
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">JUMLAH</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-xs">
                                    <button type="button" class="btn btn-light border-0 px-3" onclick="decrementQty()">-</button>
                                    <input type="number" name="quantity" id="quantity"
                                           value="1" min="1" max="{{ $product->stock }}"
                                           class="form-control border-0 text-center bg-transparent fw-bold shadow-none">
                                    <button type="button" class="btn btn-light border-0 px-3" onclick="incrementQty()">+</button>
                                </div>
                            </div>
                            <div class="col-md-8 d-flex align-items-end">
                                <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-bold border-0 shadow-sm"
                                        style="background-color: #0f172a;"
                                        @if($product->stock == 0) disabled @endif>
                                    <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Wishlist & Share --}}
                    <div class="d-flex gap-2 mb-5">
                        @auth
                            <button type="button" onclick="toggleWishlist({{ $product->id }})"
                                    class="btn btn-outline-light border text-dark flex-grow-1 py-2 rounded-3 small fw-medium transition-all hover-danger">
                                <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }} me-2"></i>
                                Wishlist
                            </button>
                        @endauth
                        <button class="btn btn-outline-light border text-dark py-2 px-3 rounded-3">
                            <i class="bi bi-share"></i>
                        </button>
                    </div>

                    {{-- Description Tabs --}}
                    <div class="product-details">
                        <h6 class="fw-bold text-uppercase small mb-3" style="letter-spacing: 1px; color: #0f172a;">Deskripsi Produk</h6>
                        <div class="text-muted leading-relaxed mb-4">
                            {!! nl2br(e($product->description)) !!}
                        </div>

                        <div class="bg-white p-3 rounded-3 border border-light shadow-xs">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-box-seam me-2 text-primary"></i>
                                        <span class="small text-muted">Berat: <strong>{{ $product->weight }} gr</strong></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-qr-code me-2 text-primary"></i>
                                        <span class="small text-muted">SKU: <strong>PROD-{{ $product->id }}</strong></span>
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
    .cursor-pointer { cursor: pointer; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .tracking-wider { letter-spacing: 0.05em; }
    
    .dot {
        height: 8px;
        width: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .thumb-wrapper:hover, .thumb-wrapper.active {
        border-color: #0f172a !important;
        transform: translateY(-2px);
    }

    .hover-danger:hover {
        background-color: #fff1f2 !important;
        border-color: #fda4af !important;
        color: #e11d48 !important;
    }

    .transition-all { transition: all 0.2s ease; }

    /* Hide arrow on number input */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .leading-relaxed { line-height: 1.625; }
    
    .custom-scrollbar::-webkit-scrollbar { height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

@push('scripts')
<script>
    function changeMainImage(src, element) {
        document.getElementById('main-image').src = src;
        // Remove active class from all
        document.querySelectorAll('.thumb-wrapper').forEach(el => el.classList.remove('active', 'border-dark'));
        // Add to clicked
        element.classList.add('active', 'border-dark');
    }

    function incrementQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
@endpush
@endsection