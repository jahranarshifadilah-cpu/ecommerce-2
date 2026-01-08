@props(['product'])

<div class="card h-100 border-0 shadow-sm product-card transition-all">
    {{-- Image Container --}}
    <div class="position-relative overflow-hidden bg-slate-50 rounded-t-4" style="padding-top: 110%;">
        <img src="{{ $product->image_url }}"
            class="card-img-top position-absolute top-0 start-0 w-100 h-100 object-fit-cover product-image transition-transform"
            alt="{{ $product->name }}">

        {{-- Badge Diskon --}}
        @if($product->has_discount)
            <span class="position-absolute top-0 start-0 m-3 badge bg-danger fw-bold shadow-sm py-2 px-3 rounded-pill" style="z-index: 2;">
                <i class="bi bi-lightning-fill me-1"></i> -{{ $product->discount_percentage }}%
            </span>
        @endif

        {{-- Floating Wishlist Button --}}
        <div class="position-absolute top-0 end-0 m-2" style="z-index: 3;">
            <button onclick="toggleWishlist({{ $product->id }})"
                class="wishlist-btn-{{ $product->id }} btn btn-white shadow-sm rounded-circle d-flex align-items-center justify-content-center"
                style="width: 38px; height: 38px; border: none;">
                <i class="bi {{ Auth::check() && Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart text-secondary' }} fs-5"></i>
            </button>
        </div>
    </div>

    {{-- Info Content --}}
    <div class="card-body d-flex flex-column p-3">
        {{-- Kategori --}}
        <small class="text-uppercase text-slate-500 fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
            {{ $product->category->name }}
        </small>
        
        {{-- Judul Produk --}}
        <h6 class="card-title mb-2 fw-bold text-navy line-clamp-2" style="min-height: 2.5rem; line-height: 1.25;">
            <a href="{{ route('catalog.show', $product->slug) }}" class="text-decoration-none text-inherit stretched-link">
                {{ $product->name }}
            </a>
        </h6>

        {{-- Harga --}}
        <div class="mt-auto pt-2">
            @if($product->has_discount)
                <div class="d-flex flex-column">
                    <span class="text-danger fw-bold fs-5">{{ $product->formatted_price }}</span>
                    <small class="text-decoration-line-through text-slate-400">{{ $product->formatted_original_price }}</small>
                </div>
            @else
                <span class="text-navy fw-bold fs-5">{{ $product->formatted_price }}</span>
            @endif
        </div>
    </div>
</div>

<style>
    /* Utility & Hover Effects */
    .bg-slate-50 { background-color: #f8fafc; }
    .text-navy { color: #0f172a; }
    .text-slate-500 { color: #64728b; }
    .text-slate-400 { color: #94a3b8; }
    
    .product-card {
        border-radius: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px -10px rgba(15, 23, 42, 0.15) !important;
    }

    .product-image {
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.08);
    }

    /* Membatasi teks hanya 2 baris agar card tetap sejajar */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-white {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
    }

    .btn-white:hover {
        background-color: #ffffff;
        transform: scale(1.1);
    }
</style>