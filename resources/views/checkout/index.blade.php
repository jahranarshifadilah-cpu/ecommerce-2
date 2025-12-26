{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-light min-vh-100 py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Keranjang</a></li>
                <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Pengiriman & Pembayaran</li>
            </ol>
        </nav>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Alamat Pengiriman</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">NAMA PENERIMA</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" 
                                       class="form-control border-light-subtle py-2 shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">NOMOR TELEPON</label>
                                <input type="text" name="phone" placeholder="08xxxx"
                                       class="form-control border-light-subtle py-2 shadow-none" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold">ALAMAT LENGKAP</label>
                                <textarea name="address" rows="3" class="form-control border-light-subtle shadow-none" 
                                          placeholder="Tuliskan alamat lengkap Anda..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-4 rounded-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-credit-card-fill"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Metode Pembayaran</h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check border p-3 rounded-3 mb-2 hover-border-primary">
                                    <input class="form-check-input ms-0 me-3" type="radio" name="payment" id="pay1" checked>
                                    <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="pay1">
                                        <span>Transfer Bank</span>
                                        <i class="bi bi-bank text-muted"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check border p-3 rounded-3 mb-2 opacity-50">
                                    <input class="form-check-input ms-0 me-3" type="radio" name="payment" id="pay2" disabled>
                                    <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="pay2">
                                        <span>E-Wallet (Soon)</span>
                                        <i class="bi bi-wallet2 text-muted"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-sticky" style="top: 20px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="fw-bold">Ringkasan Belanja</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4" style="max-height: 200px; overflow-y: auto;">
                                @foreach($cart->items as $item)
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0 bg-light rounded-3" style="width: 50px; height: 50px;">
                                        {{-- Jika ada gambar: <img src="{{ asset('storage/'.$item->product->image) }}" class="w-100 rounded"> --}}
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 small fw-bold">{{ $item->product->name }}</h6>
                                        <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="small fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <hr class="border-light">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Total Harga ({{ $cart->items->sum('quantity') }} barang)</span>
                                <span class="small">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Biaya Pengiriman</span>
                                <span class="text-success small fw-bold">FREE</span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-4 mb-4 p-3 bg-primary bg-opacity-10 rounded-3">
                                <span class="fw-bold text-primary">Total Bayar</span>
                                <h5 class="mb-0 fw-bold text-primary">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</h5>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm py-3 mb-2">
                                Buat Pesanan Sekarang
                            </button>
                            <p class="text-center text-muted x-small" style="font-size: 0.75rem;">
                                Dengan mengklik tombol, Anda menyetujui syarat & ketentuan kami.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #0d6efd;
        background-color: #c0c4c9;
    }
    .hover-border-primary:hover {
        border-color: #0d6efd !important;
        background-color: #afb3b7;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "\F285"; /* Ikon chevron kanan */
        font-family: "bootstrap-icons";
        font-size: 10px;
        color: #b0b2b5;
    }
    .rounded-4 { border-radius: 1rem !important; }
</style>
@endsection