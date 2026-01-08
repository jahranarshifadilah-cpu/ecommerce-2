{{-- ================================================
     FILE: resources/views/cart/index.blade.php
     FUNGSI: Halaman keranjang belanja (Elegant UI)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    {{-- Header dengan Breadcrumb sederhana --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Keranjang Belanja</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold m-0" style="color: #0f172a;">
            <i class="bi bi-cart3 me-2" style="color: #0f172a;"></i>Keranjang Belanja
        </h2>
        @if($cart && $cart->items->count())
            <span class="badge px-3 py-2 rounded-pill fw-medium" style="background-color: #f1f5f9; color: #475569;">
                {{ $cart->items->count() }} Produk
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
                            <thead style="background-color: #f8fafc; color: #64748b;" class="small uppercase">
                                <tr>
                                    <th class="ps-4 py-3 border-0 fw-bold">PRODUK</th>
                                    <th class="text-center py-3 border-0 fw-bold">HARGA</th>
                                    <th class="text-center py-3 border-0 fw-bold" style="width: 150px;">JUMLAH</th>
                                    <th class="text-end py-3 border-0 fw-bold">SUBTOTAL</th>
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
                                                         class="rounded-3 shadow-sm border" 
                                                         width="70" height="70" 
                                                         style="object-fit: cover;">
                                                </div>
                                                <div class="ms-3">
                                                    <a href="{{ route('catalog.show', $item->product->slug) }}" 
                                                       class="text-decoration-none text-dark fw-bold mb-1 d-block hover-navy">
                                                        {{ Str::limit($item->product->name, 40) }}
                                                    </a>
                                                    <span class="text-muted small">
                                                        {{ $item->product->category->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-secondary small">
                                            {{ $item->product->formatted_price }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="mx-auto" style="max-width: 90px;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" 
                                                       value="{{ $item->quantity }}" 
                                                       min="1" max="{{ $item->product->stock }}" 
                                                       class="form-control form-control-sm border-light-subtle text-center rounded-3 bg-light" 
                                                       onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="text-end fw-bold" style="color: #0f172a;">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-muted p-0 hover-danger" 
                                                        onclick="return confirm('Hapus item ini?')">
                                                    <i class="bi bi-x-circle fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-0 p-4">
                         <a href="{{ route('catalog.index') }}" class="text-decoration-none small fw-bold text-muted hover-navy">
                            <i class="bi bi-arrow-left me-1"></i> Kembali Belanja
                        </a>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-2">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4" style="color: #0f172a;">Ringkasan Pesanan</h5>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted small">Subtotal ({{ $cart->items->sum('quantity') }} unit)</span>
                            <span class="fw-medium text-dark small">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted small">Biaya Pengiriman</span>
                            <span class="text-success fw-bold small">Gratis</span>
                        </div>
                        
                        <hr class="my-4 opacity-50">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold text-dark">Total Harga</span>
                            <span class="h4 mb-0 fw-bold" style="color: #0f172a;">
                                Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-dark w-100 py-3 rounded-3 fw-bold mb-3 shadow-sm border-0" style="background-color: #0f172a;">
                            Lanjut ke Checkout <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        
                        <div class="d-flex align-items-center justify-content-center small text-muted">
                            <i class="bi bi-shield-lock me-2"></i> Aman & Terenkripsi
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
                <h4 class="fw-bold" style="color: #0f172a;">Wah, keranjangmu masih kosong!</h4>
                <p class="text-muted mb-4">Yuk, cari produk favoritmu dan masukkan ke keranjang sekarang.</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-dark px-5 py-2 rounded-pill fw-bold border-0" style="background-color: #0f172a;">
                    Mulai Belanja
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    /* Elegant Custom Overrides */
    .hover-navy:hover { color: #0f172a !important; text-decoration: underline !important; }
    .hover-danger:hover { color: #dc3545 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .table thead th { font-size: 0.7rem; letter-spacing: 0.08rem; }
    .form-control:focus { box-shadow: none; border-color: #cbd5e1; background-color: #fff !important; }
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; font-size: 1.1rem; vertical-align: middle; line-height: 1; }
    .btn-dark:hover { background-color: #1e293b !important; transform: translateY(-1px); transition: all 0.2s; }
</style>
@endsection