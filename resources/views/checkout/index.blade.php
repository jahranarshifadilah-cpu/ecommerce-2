{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-vh-100 py-5" style="background-color: #f8fafc;">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-decoration-none text-muted">Keranjang</a></li>
                <li class="breadcrumb-item active fw-bold" style="color: #0f172a;" aria-current="page">Pengiriman & Pembayaran</li>
            </ol>
        </nav>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                
                {{-- Bagian Kiri: Formulir --}}
                <div class="col-lg-8">
                    {{-- Alamat Pengiriman --}}
                    <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; background-color: #f1f5f9; color: #0f172a;">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <h5 class="mb-0 fw-bold" style="color: #0f172a;">Alamat Pengiriman</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Nama Penerima</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" 
                                       class="form-control bg-light border-0 py-2 shadow-none rounded-3" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Nomor Telepon</label>
                                <input type="text" name="phone" placeholder="08xxxx"
                                       class="form-control bg-light border-0 py-2 shadow-none rounded-3" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Alamat Lengkap</label>
                                <textarea name="address" rows="3" class="form-control bg-light border-0 shadow-none rounded-3" 
                                          placeholder="Tuliskan alamat lengkap pengiriman..." required></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="card border-0 shadow-sm p-4 rounded-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; background-color: #f1f5f9; color: #0f172a;">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <h5 class="mb-0 fw-bold" style="color: #0f172a;">Metode Pembayaran</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check border p-3 rounded-3 shadow-xs payment-card active-payment">
                                    <input class="form-check-input ms-0 me-3" type="radio" name="payment" id="pay1" checked>
                                    <label class="form-check-label d-flex justify-content-between align-items-center w-100 cursor-pointer" for="pay1">
                                        <span class="fw-medium">Transfer Bank</span>
                                        <i class="bi bi-bank2 text-muted"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check border p-3 rounded-3 opacity-50 bg-light shadow-none">
                                    <input class="form-check-input ms-0 me-3" type="radio" name="payment" id="pay2" disabled>
                                    <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="pay2">
                                        <span class="text-muted small">E-Wallet (Segera Hadir)</span>
                                        <i class="bi bi-wallet2 text-muted"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian Kanan: Summary --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-sticky" style="top: 20px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold text-uppercase small text-muted mb-0" style="letter-spacing: 1px;">Ringkasan Belanja</h6>
                        </div>
                        <div class="card-body p-4">
                            {{-- Daftar Produk dengan Foto --}}
                            <div class="mb-4" style="max-height: 280px; overflow-y: auto;">
                                @foreach($cart->items as $item)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0" style="width: 50px; height: 50px;">
                                        <img src="{{ $item->product->image_url }}" 
                                             class="w-100 h-100 rounded-2 border shadow-sm" 
                                             style="object-fit: cover;" 
                                             alt="{{ $item->product->name }}">
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 small fw-bold text-dark text-truncate" style="max-width: 140px;">{{ $item->product->name }}</h6>
                                        <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="small fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Total Harga ({{ $cart->items->sum('quantity') }} unit)</span>
                                    <span class="small fw-medium">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted small">Biaya Pengiriman</span>
                                    <span class="text-success small fw-bold">FREE</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top mb-4">
                                    <span class="fw-bold" style="color: #0f172a;">Total Bayar</span>
                                    <h5 class="mb-0 fw-bold" style="color: #0f172a;">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</h5>
                                </div>

                                <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-bold shadow-sm mb-3 border-0" style="background-color: #0f172a;">
                                    Buat Pesanan Sekarang
                                </button>
                                
                                <p class="text-center text-muted mb-0" style="font-size: 0.7rem;">
                                    <i class="bi bi-shield-lock-fill me-1"></i> Pembayaran Aman & Terenkripsi
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<style>
    /* Styling Elemen Input */
    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03) !important;
    }
    
    /* Styling Card Pembayaran */
    .payment-card {
        transition: all 0.2s ease;
        border: 1.5px solid #f1f5f9 !important;
    }
    
    .active-payment {
        border-color: #0f172a !important;
        background-color: #f8fafc;
    }

    .cursor-pointer { cursor: pointer; }

    /* Scrollbar Halus */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-size: 1.1rem;
        vertical-align: middle;
        line-height: 1;
    }
    
    .btn-dark:hover {
        background-color: #1e293b !important;
        transform: translateY(-1px);
    }
</style>
@endsection