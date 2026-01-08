@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold" style="color: #0f172a;">Inventaris Produk</h2>
        <p class="text-muted small mb-0">Kelola stok, harga, dan visibilitas produk Anda.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-dark px-4 rounded-3 shadow-sm" style="background-color: #0f172a;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Produk
    </a>
</div>

{{-- Filter Box --}}
<div class="card border-0 shadow-sm mb-4 rounded-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 shadow-none" 
                           placeholder="Cari nama produk atau SKU..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select shadow-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-dark w-100 fw-semibold">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background-color: #f8fafc;">
                <tr>
                    <th class="ps-4 py-3 border-0 text-slate-500 small fw-bold">PRODUK</th>
                    <th class="border-0 py-3 text-slate-500 small fw-bold">KATEGORI</th>
                    <th class="border-0 py-3 text-slate-500 small fw-bold">HARGA</th>
                    <th class="border-0 py-3 text-slate-500 small fw-bold text-center">STOK</th>
                    <th class="border-0 py-3 text-slate-500 small fw-bold text-center">STATUS</th>
                    <th class="pe-4 border-0 py-3 text-slate-500 small fw-bold text-end">AKSI</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse($products as $product)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 border overflow-hidden me-3" style="width: 50px; height: 50px;">
                                <img src="{{ $product->primaryImage?->image_url ?? asset('img/no-image.png') }}" 
                                     class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                            </div>
                            <div class="fw-bold text-slate-900">{{ $product->name }}</div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border fw-medium px-2 py-1">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="fw-bold" style="color: #0f172a;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @if($product->stock <= 5)
                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> {{ $product->stock }}</span>
                        @else
                            <span class="text-slate-600">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge rounded-pill px-3 py-2" 
                              style="font-size: 0.7rem; 
                                     background-color: {{ $product->is_active ? 'rgba(16, 185, 129, 0.1)' : 'rgba(100, 116, 139, 0.1)' }}; 
                                     color: {{ $product->is_active ? '#059669' : '#475569' }};">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-white btn-sm border-end" title="Detail">
                                <i class="bi bi-eye text-slate-600"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-white btn-sm" title="Edit">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </a>
                            <button type="button" class="btn btn-white btn-sm text-danger border-start" 
                                    onclick="confirmDelete('{{ $product->id }}')" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-box-seam fs-1 d-block mb-3 opacity-25"></i>
                        Data produk tidak ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $products->appends(request()->all())->links('pagination::bootstrap-5') }}
</div>

<style>
    .btn-white { background-color: #fff; color: #64748b; border: 1px solid #e2e8f0; }
    .btn-white:hover { background-color: #f8fafc; color: #0f172a; }
    .object-fit-cover { object-fit: cover; }
</style>
@endsection