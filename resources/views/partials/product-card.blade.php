{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     FUNGSI: Tampilan Elegant & Premium
     ================================================ --}}

<div class="card product-card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease; border-radius: 12px; background: #ffffff;">
    {{-- Product Image --}}
    <div class="position-relative overflow-hidden" style="border-radius: 12px 12px 0 0;">
        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}"
                 class="card-img-top"
                 alt="{{ $product->name }}"
                 style="height: 220px; object-fit: cover; transition: all 0.5s ease;">
        </a>

        {{-- Badge Diskon: Menggunakan warna Terracotta/Deep Red yang elegan --}}
        @if($product->has_discount)
            <span class="position-absolute top-0 start-0 m-2 px-2 py-1 small fw-bold text-white" 
                  style="background-color: #b91c1c; border-radius: 4px; font-size: 0.75rem;">
                -{{ $product->discount_percentage }}%
            </span>
        @endif

        {{-- Wishlist Button: Transparan ke Solid --}}
        @auth
            <button type="button"
                    onclick="toggleWishlist({{ $product->id }})"
                    class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow-sm wishlist-btn-{{ $product->id }}"
                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: none;">
                <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
            </button>
        @endauth
    </div>

    {{-- Card Body --}}
    <div class="card-body d-flex flex-column px-3 pt-3 pb-2">
        {{-- Category: Soft Slate --}}
        <small class="text-uppercase tracking-wider mb-1" style="font-size: 0.65rem; color: #64748b; letter-spacing: 0.05em; font-weight: 600;">
            {{ $product->category->name }}
        </small>

        {{-- Product Name --}}
        <h6 class="card-title mb-2" style="font-size: 0.95rem; line-height: 1.4;">
            <a href="{{ route('catalog.show', $product->slug) }}"
               class="text-decoration-none text-dark stretched-link fw-semibold" style="color: #1e293b !important;">
                {{ Str::limit($product->name, 40) }}
            </a>
        </h6>

        {{-- Price: Deep Navy & Muted Grey --}}
        <div class="mt-auto">
            @if($product->has_discount)
                <small class="text-muted text-decoration-line-through" style="font-size: 0.8rem;">
                    {{ $product->formatted_original_price }}
                </small>
            @endif
            <div class="fw-bold" style="color: #0f172a; font-size: 1.1rem;">
                {{ $product->formatted_price }}
            </div>
        </div>

        {{-- Stock Info: Subtle Colors --}}
        @if($product->stock <= 5 && $product->stock > 0)
            <small class="mt-2 fw-medium" style="color: #d97706; font-size: 0.75rem;">
                <i class="bi bi-clock-history me-1"></i> Sisa {{ $product->stock }} stok
            </small>
        @elseif($product->stock == 0)
            <small class="text-muted mt-2 fw-medium" style="font-size: 0.75rem;">
                <i class="bi bi-x-circle me-1"></i> Persediaan Habis
            </small>
        @endif
    </div>

    {{-- Card Footer: Minimalist Button --}}
    <div class="card-footer bg-white border-0 p-3 pt-0">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit"
                    class="btn w-100 d-flex align-items-center justify-content-center"
                    style="background-color: #1e293b; color: #ffffff; border-radius: 8px; font-size: 0.85rem; font-weight: 500; padding: 8px; transition: all 0.3s;"
                    @if($product->stock == 0) disabled @endif>
                @if($product->stock == 0)
                    Sudah Terjual
                @else
                    <i class="bi bi-bag-plus me-2"></i> Tambahkan
                @endif
            </button>
        </form>
    </div>
</div>

<style>
    /* Menambah efek interaksi yang halus */
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }
    .product-card:hover img {
        transform: scale(1.05);
    }
    .btn-dark:hover {
        background-color: #0f172a !important;
    }
</style>