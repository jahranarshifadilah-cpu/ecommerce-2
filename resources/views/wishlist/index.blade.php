{{-- resources/views/wishlist/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="min-vh-100 py-5" style="background-color: #f8fafc;">
    <div class="container">
        {{-- Header Halaman --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-1" style="color: #0f172a;">Wishlist Saya</h3>
                <p class="text-muted small mb-0">Daftar produk yang Anda simpan untuk nanti</p>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background-color: #f1f5f9; color: #0f172a; border: 1px solid #e2e8f0;">
                {{ $products->total() }} Produk
            </span>
        </div>

        @if($products->count())
            {{-- Grid Produk --}}
            <div class="row row-cols-2 row-cols-md-4 g-4">
                @foreach($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @else
            {{-- Tampilan Jika Kosong --}}
            <div class="row justify-content-center mt-5">
                <div class="col-md-6 text-center">
                    <div class="bg-white rounded-4 shadow-sm p-5 border border-dashed">
                        <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle" 
                             style="width: 100px; height: 100px; background-color: #fff1f2;">
                            <i class="bi bi-heart-fill text-danger" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="fw-bold" style="color: #0f172a;">Belum ada impian?</h4>
                        <p class="text-muted mb-4 px-md-5">Simpan produk favorit Anda di sini agar lebih mudah ditemukan saat Anda siap untuk checkout.</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-dark px-4 py-2 rounded-3 fw-bold border-0 shadow-sm" 
                           style="background-color: #0f172a;">
                            Jelajahi Katalog
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    
    .border-dashed {
        border: 2px dashed #e2e8f0 !important;
    }

    /* Animasi muncul pelan untuk kartu produk */
    .col {
        animation: fadeInUp 0.5s ease backwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Styling Pagination agar serasi */
    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #475569;
        border: none;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .pagination .page-item.active .page-link {
        background-color: #0f172a;
        color: #fff;
    }
</style>
@endsection