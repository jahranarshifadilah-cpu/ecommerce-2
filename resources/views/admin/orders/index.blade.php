@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold" style="color: #0f172a;">Manajemen Pesanan</h2>
        <p class="text-muted small mb-0">Pantau dan kelola seluruh transaksi masuk dari pelanggan Anda.</p>
    </div>
</div>

{{-- Statistik Ringkas (Optional tapi Bagus untuk User Experience) --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm border-0 rounded-4 p-3 bg-white">
            <small class="text-muted fw-bold d-block mb-1">TOTAL PESANAN</small>
            <h4 class="fw-bold mb-0">{{ $orders->total() }}</h4>
        </div>
    </div>
    </div>

<div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3 px-4">
        {{-- Filter Status dengan Styling Modern --}}
        <ul class="nav nav-pills gap-2">
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 {{ !request('status') ? 'active bg-navy' : 'text-slate-600 bg-slate-100' }}" 
                   href="{{ route('admin.orders.index') }}">Semua</a>
            </li>
            @php
                $statuses = [
                    'pending' => 'Pending',
                    'processing' => 'Diproses',
                    'shipped' => 'Dikirim',
                    'delivered' => 'Sampai',
                    'cancelled' => 'Batal'
                ];
            @endphp
            @foreach($statuses as $key => $label)
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 {{ request('status') == $key ? 'active bg-navy' : 'text-slate-600 bg-slate-100' }}" 
                   href="{{ route('admin.orders.index', ['status' => $key]) }}">
                    {{ $label }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8fafc;">
                    <tr>
                        <th class="ps-4 py-3 text-slate-500 fw-bold small">NO. ORDER</th>
                        <th class="py-3 text-slate-500 fw-bold small">PELANGGAN</th>
                        <th class="py-3 text-slate-500 fw-bold small">TANGGAL</th>
                        <th class="py-3 text-slate-500 fw-bold small">TOTAL</th>
                        <th class="py-3 text-slate-500 fw-bold small">STATUS</th>
                        <th class="text-end pe-4 py-3 text-slate-500 fw-bold small">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-navy">#{{ $order->order_number }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-slate-800">{{ $order->user->name }}</div>
                                <div class="text-muted small" style="font-size: 0.75rem;">{{ $order->user->email }}</div>
                            </td>
                            <td class="text-slate-600 small">
                                {{ $order->created_at->format('d M Y') }}
                                <div class="text-muted" style="font-size: 0.7rem;">{{ $order->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                <span class="fw-bold text-slate-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-pending text-pending-dark',
                                        'processing' => 'bg-info-soft text-info-dark',
                                        'shipped' => 'bg-primary-soft text-primary-dark',
                                        'delivered' => 'bg-success-soft text-success-dark',
                                        'cancelled' => 'bg-danger-soft text-danger-dark',
                                    ];
                                    $currentClass = $statusClasses[$order->status] ?? 'bg-secondary text-white';
                                @endphp
                                <span class="badge rounded-pill px-3 py-2 {{ $currentClass }} fw-medium" style="font-size: 0.75rem;">
                                    {{ ucfirst($statuses[$order->status] ?? $order->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark rounded-3 px-3 shadow-none">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty" style="width: 80px; opacity: 0.2;">
                                <p class="text-muted mt-3 mb-0">Tidak ada pesanan ditemukan pada kategori ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center">
            <span class="small text-muted">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan</span>
            {{ $orders->links() }}
        </div>
    </div>
</div>

<style>
    .bg-navy { background-color: #0f172a !important; color: white !important; }
    .text-navy { color: #0f172a; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .text-slate-500 { color: #64748b; }
    .text-slate-600 { color: #475569; }
    
    /* Soft Status Colors */
    .bg-pending { background-color: rgba(245, 158, 11, 0.15); }
    .text-pending-dark { color: #b45309; }
    
    .bg-info-soft { background-color: rgba(14, 165, 233, 0.15); }
    .text-info-dark { color: #0369a1; }
    
    .bg-primary-soft { background-color: rgba(79, 70, 229, 0.15); }
    .text-primary-dark { color: #4338ca; }
    
    .bg-success-soft { background-color: rgba(16, 185, 129, 0.15); }
    .text-success-dark { color: #047857; }
    
    .bg-danger-soft { background-color: rgba(239, 68, 68, 0.15); }
    .text-danger-dark { color: #b91c1c; }

    .nav-pills .nav-link:not(.active):hover { background-color: #e2e8f0; color: #0f172a; }
    .table-hover tbody tr:hover { background-color: #fcfcfd; }
</style>
@endsection