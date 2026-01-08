@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@push('styles')
<style>
    /* ===== THEME CONSISTENCY ===== */
    .bg-navy { background-color: #0f172a !important; }
    .text-navy { color: #0f172a !important; }
    .bg-slate-50 { background-color: #f8fafc; }
    
    /* ===== MODAL REFINEMENT ===== */
    .modal-content {
        border: none !important;
        border-radius: 1rem !important;
        overflow: hidden;
    }
    
    .modal-header {
        background-color: #0f172a !important;
        color: white;
        border-bottom: none;
        padding: 1.5rem;
    }

    .modal-footer {
        background-color: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 1.25rem;
    }

    /* ===== SMOOTH ANIMATION ===== */
    .modal.fade .modal-dialog {
        transform: scale(0.9) translateY(20px);
        transition: transform 0.25s ease-out;
    }
    .modal.show .modal-dialog {
        transform: scale(1) translateY(0);
    }

    /* ===== TABLE STYLING ===== */
    .category-img {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #f1f5f9;
    }

    .badge-soft-success { background-color: rgba(16, 185, 129, 0.1); color: #059669; }
    .badge-soft-secondary { background-color: rgba(100, 116, 139, 0.1); color: #475569; }
    .badge-soft-info { background-color: rgba(14, 165, 233, 0.1); color: #0284c7; }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- HEADER SECTION --}}
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="h3 mb-1 fw-bold text-navy">Manajemen Kategori</h2>
                <p class="text-muted small mb-0">Kelola kelompok produk untuk mempermudah navigasi pelanggan.</p>
            </div>
            <button class="btn btn-dark rounded-3 px-4 shadow-sm bg-navy" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
            </button>
        </div>

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="ps-4 py-3 text-slate-500 fw-bold small">KATEGORI</th>
                                <th class="text-center py-3 text-slate-500 fw-bold small">JUMLAH PRODUK</th>
                                <th class="text-center py-3 text-slate-500 fw-bold small">STATUS</th>
                                <th class="text-end pe-4 py-3 text-slate-500 fw-bold small">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($category->image)
                                            <img src="{{ Storage::url($category->image) }}" class="category-img me-3">
                                        @else
                                            <div class="category-img bg-light d-flex align-items-center justify-content-center me-3 border">
                                                <i class="bi bi-tag text-muted fs-4"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-navy">{{ $category->name }}</div>
                                            <small class="text-muted">/{{ $category->slug }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="badge badge-soft-info px-3 py-2 rounded-pill">
                                        {{ $category->products_count }} Produk
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if($category->is_active)
                                        <span class="badge badge-soft-success px-3 py-2 rounded-pill fw-medium">
                                            <i class="bi bi-dot"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-soft-secondary px-3 py-2 rounded-pill fw-medium">
                                            <i class="bi bi-dot"></i> Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-outline-warning rounded-3 px-3" 
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                              onsubmit="return confirm('Menghapus kategori akan berdampak pada produk terkait. Lanjutkan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                        <p class="mb-0">Belum ada kategori yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

{{-- ================= MODALS SECTION ================= --}}

{{-- CREATE MODAL --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Kategori Baru</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold text-navy small">NAMA KATEGORI</label>
                    <input type="text" name="name" class="form-control border-slate-200 py-2 rounded-3" placeholder="Contoh: Elektronik" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-navy small">GAMBAR COVER</label>
                    <input type="file" name="image" class="form-control border-slate-200 py-2 rounded-3">
                </div>
                <div class="form-check form-switch mt-4 p-0 ps-5">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="switchCreate" checked style="width: 2.5em; height: 1.25em;">
                    <label class="form-check-label ms-2 fw-medium" for="switchCreate">Aktifkan Kategori</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-dark px-4 rounded-3 bg-navy">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL LOOP --}}
@foreach($categories as $category)
<div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Kategori</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold text-navy small">NAMA KATEGORI</label>
                    <input type="text" name="name" class="form-control border-slate-200 py-2 rounded-3" value="{{ $category->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-navy small">GAMBAR BARU (OPSIONAL)</label>
                    <input type="file" name="image" class="form-control border-slate-200 py-2 rounded-3">
                </div>
                <div class="form-check form-switch mt-4 p-0 ps-5">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="switch{{ $category->id }}" {{ $category->is_active ? 'checked' : '' }} style="width: 2.5em; height: 1.25em;">
                    <label class="form-check-label ms-2 fw-medium" for="switch{{ $category->id }}">Kategori Aktif</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-dark px-4 rounded-3 bg-navy">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection