{{-- resources/views/catalog/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-vh-100 py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row g-4">
            {{-- SIDEBAR FILTER --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-sticky" style="top: 20px;">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase small mb-0" style="color: #0f172a; letter-spacing: 1px;">Filter Produk</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('catalog.index') }}" method="GET">
                            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

                            {{-- Filter Kategori --}}
                            <div class="mb-4">
                                <label class="fw-bold small text-muted text-uppercase mb-3 d-block" style="letter-spacing: 0.5px;">Kategori</label>
                                @foreach($categories as $cat)
                                <div class="form-check mb-2">
                                    <input class="form-check-input custom-check" type="radio" name="category" id="cat-{{ $cat->slug }}" 
                                           value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <label class="form-check-label small d-flex justify-content-between align-items-center w-100 cursor-pointer" for="cat-{{ $cat->slug }}">
                                        <span class="{{ request('category') == $cat->slug ? 'fw-bold text-dark' : 'text-secondary' }}">
                                            {{ $cat->name }}
                                        </span>
                                        <span class="badge rounded-pill bg-light text-muted fw-normal border" style="font-size: 0.7rem;">
                                            {{ $cat->products_count }}
                                        </span>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            {{-- Filter Harga --}}
                            <div class="mb-4">
                                <label class="fw-bold small text-muted text-uppercase mb-3 d-block" style="letter-spacing: 0.5px;">Rentang Harga</label>
                                <div class="input-group input-group-sm mb-2 shadow-xs">
                                    <span class="input-group-text bg-light border-0 text-muted small">Rp</span>
                                    <input type="number" name="min_price" class="form-control bg-light border-0 shadow-none"
                                           placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="input-group input-group-sm shadow-xs">
                                    <span class="input-group-text bg-light border-0 text-muted small">Rp</span>
                                    <input type="number" name="max_price" class="form-control bg-light border-0 shadow-none"
                                           placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>

                            <div class="d-grid gap-2 border-top pt-4">
                                <button type="submit" class="btn btn-dark rounded-3 btn-sm py-2 fw-bold border-0 shadow-sm" style="background-color: #0f172a;">
                                    Terapkan Filter
                                </button>
                                <a href="{{ route('catalog.index') }}"
                                    class="btn btn-link text-decoration-none text-muted small fw-medium text-center">
                                    Reset Semua
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- PRODUCT GRID --}}
            <div class="col-lg-9">
                {{-- Toolbar Atas --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #0f172a;">Katalog Produk</h4>
                        <p class="text-muted small mb-0">Menampilkan produk terbaik pilihan kami</p>
                    </div>
                    
                    {{-- Sorting --}}
                    <div class="d-flex align-items-center bg-white p-2 rounded-3 shadow-sm border border-light">
                        <label class="small text-muted me-2 ms-1 text-nowrap">Urutkan:</label>
                        <form method="GET" class="mb-0">
                            @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="sort" class="form-select form-select-sm border-0 bg-transparent shadow-none fw-bold" 
                                    style="color: #0f172a; cursor: pointer;" onchange="this.form.submit()">
                                <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @forelse($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <div class="bg-white rounded-4 shadow-sm p-5 border border-dashed">
                            <i class="bi bi-search text-muted display-1 opacity-25"></i>
                            <h5 class="fw-bold mt-4" style="color: #0f172a;">Produk tidak ditemukan</h5>
                            <p class="text-muted">Coba kurangi filter atau gunakan kata kunci lain.</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-dark px-4 rounded-pill border-0" style="background-color: #0f172a;">
                                Lihat Semua Produk
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Elemen Filter */
    .custom-check:checked {
        background-color: #0f172a;
        border-color: #0f172a;
    }
    
    .cursor-pointer { cursor: pointer; }
    
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }

    .card { transition: all 0.3s ease; }
    
    .rounded-4 { border-radius: 1rem !important; }

    /* Customizing Select Box */
    .form-select:focus {
        box-shadow: none;
        border-color: transparent;
    }

    /* Pagination Styling */
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

    .border-dashed {
        border: 2px dashed #e2e8f0 !important;
    }

    .btn-dark:hover {
        background-color: #1e293b !important;
        transform: translateY(-1px);
    }
</style>
@endsection