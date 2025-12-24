{{-- ================================================
     FILE: resources/views/cart/index.blade.php
     FUNGSI: Halaman keranjang belanja (UI Updated)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    {{-- Header dengan Breadcrumb sederhana --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}" class="text-decoration-none">Katalog</a></li>
            <li class="breadcrumb-item active">Keranjang Belanja</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold m-0">
            <i class="bi bi-cart3 me-2 text-primary"></i>Keranjang Belanja
        </h2>
        @if($cart && $cart->items->count())
            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                {{ $cart->items->count() }} Produk Berbeda
            </span>
        @endif
    </div>

    @if($cart && $cart->items->count())
        <div class="row g-4">
            {{-- Cart Items --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light text-muted small uppercase">
                                <tr>
                                    <th class="ps-4 py-3 border-0">PRODUK</th>
                                    <th class="text-center py-3 border-0">HARGA</th>
                                    <th class="text-center py-3 border-0" style="width: 150px;">JUMLAH</th>
                                    <th class="text-end py-3 border-0">SUBTOTAL</th>
                                    <th class="pe-4 py-3 border-0"></th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach($cart->items as $item)
                                    <tr>
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="position-relative">
                                                    <img src="{{ $item->product->image_url }}" 
                                                         class="rounded-3 border shadow-sm" 
                                                         width="80" height="80" 
                                                         style="object-fit: cover;">
                                                </div>
                                                <div class="ms-3">
                                                    <a href="{{ route('catalog.show', $item->product->slug) }}" 
                                                       class="text-decoration-none text-dark fw-bold mb-1 d-block hover-primary">
                                                        {{ Str::limit($item->product->name, 45) }}
                                                    </a>
                                                    <span class="badge bg-light text-muted fw-normal">
                                                        {{ $item->product->category->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-muted">
                                            {{ $item->product->formatted_price }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="mx-auto" style="max-width: 100px;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" 
                                                       value="{{ $item->quantity }}" 
                                                       min="1" max="{{ $item->product->stock }}" 
                                                       class="form-control form-control-sm border-2 text-center rounded-pill" 
                                                       onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="text-end fw-bold text-dark">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" 
                                                        onclick="return confirm('Hapus item ini?')">
                                                    <i class="bi bi-trash3 fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-0 p-4">
                         <a href="{{ route('catalog.index') }}" class="text-decoration-none small fw-bold">
                            <i class="bi bi-arrow-left me-1"></i> Kembali Belanja
                        </a>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-2">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal ({{ $cart->items->sum('quantity') }} unit)</span>
                            <span class="fw-medium">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Biaya Pengiriman</span>
                            <span class="text-success fw-medium">Gratis</span>
                        </div>
                        
                        <hr class="my-4 border-dashed">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="h6 mb-0 fw-bold">Total Harga</span>
                            <span class="h4 mb-0 fw-bold text-primary">
                                Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-3 rounded-3 fw-bold mb-3 shadow-sm">
                            Checkout <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        
                        <div class="d-flex align-items-center justify-content-center small text-muted">
                            <i class="bi bi-shield-check me-2 text-success"></i> Pembayaran Aman & Terenkripsi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Empty Cart --}}
        <div class="card border-0 shadow-sm rounded-4 py-5 mt-4">
            <div class="card-body text-center py-5">
                <div class="bg-light d-inline-block p-4 rounded-circle mb-4">
                    <i class="bi bi-cart-x display-4 text-muted"></i>
                </div>
                <h4 class="fw-bold">Wah, keranjangmu masih kosong!</h4>
                <p class="text-muted mb-4">Yuk, cari produk favoritmu dan masukkan ke keranjang sekarang.</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary px-5 py-2 rounded-pill fw-bold">
                    Mulai Belanja
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    /* CSS tambahan untuk mempercantik */
    .bg-soft-primary { background-color: #e7f1ff; }
    .border-dashed { border-style: dashed !important; }
    .hover-primary:hover { color: #0d6efd !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .table thead th { font-size: 0.75rem; letter-spacing: 0.05rem; }
    .form-control:focus { box-shadow: none; border-color: #0d6efd; }
</style>
@endsection