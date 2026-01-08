@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header dengan gaya minimalis --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Riwayat Pesanan</h1>
            <p class="text-muted small mb-0">Kelola dan pantau status pesanan Anda di sini.</p>
        </div>
        <i class="bi bi-receipt text-muted opacity-50" style="font-size: 2rem;"></i>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    {{-- Header Tabel: Menggunakan background soft slate --}}
                    <thead style="background-color: #f8fafc; border-bottom: 2px solid #f1f5f9;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 0.5px;">No. Order</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 0.5px;">Tanggal</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 0.5px;">Status</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 0.5px;">Total</th>
                            <th class="pe-4 py-3 text-end text-uppercase small fw-bold text-muted" style="letter-spacing: 0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr style="transition: all 0.2s ease;">
                            <td class="ps-4 py-4">
                                <span class="fw-bold" style="color: #0f172a;">#{{ $order->order_number }}</span>
                            </td>
                            <td class="text-secondary small">
                                {{ $order->created_at->format('d M Y') }}
                                <div class="text-muted" style="font-size: 0.75rem;">{{ $order->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                {{-- Badge dengan warna yang lebih dewasa/soft --}}
                                <span class="badge px-3 py-2 fw-medium" 
                                    style="border-radius: 6px; font-size: 0.75rem; 
                                    @if($order->status == 'pending') background-color: #fef3c7; color: #92400e;
                                    @elseif($order->status == 'processing') background-color: #e0f2fe; color: #075985;
                                    @elseif($order->status == 'shipped') background-color: #e0e7ff; color: #3730a3;
                                    @elseif($order->status == 'delivered') background-color: #dcfce7; color: #166534;
                                    @elseif($order->status == 'cancelled') background-color: #fee2e2; color: #991b1b;
                                    @endif">
                                    <i class="bi bi-dot"></i>
                                    @if($order->status == 'pending') Menunggu Pembayaran
                                    @elseif($order->status == 'processing') Sedang Diproses
                                    @elseif($order->status == 'shipped') Dalam Pengiriman
                                    @elseif($order->status == 'delivered') Selesai
                                    @elseif($order->status == 'cancelled') Dibatalkan
                                    @else {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="fw-bold" style="color: #1e293b;">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('orders.show', $order) }}" 
                                   class="btn btn-sm px-3 fw-bold" 
                                   style="border: 1px solid #e2e8f0; border-radius: 6px; color: #475569; background: #fff;">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/slate/shaking-hands.svg" alt="empty" style="height: 120px; opacity: 0.5;" class="mb-3">
                                <p class="text-muted mb-0">Belum ada riwayat pesanan.</p>
                                <a href="{{ route('catalog.index') }}" class="btn btn-link btn-sm text-primary text-decoration-none">Mulai belanja sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Pagination yang rapi --}}
        @if($orders->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4">
            <div class="d-flex justify-content-center custom-pagination">
                {{ $orders->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Menghilangkan garis biru standar bootstrap saat tombol diklik */
    .btn:focus { box-shadow: none; }
    
    /* Efek hover pada baris tabel */
    tbody tr:hover {
        background-color: #f8fafc !important;
    }

    /* Styling pagination agar selaras */
    .custom-pagination .page-link {
        border: none;
        color: #64748b;
        margin: 0 4px;
        border-radius: 6px !important;
    }
    .custom-pagination .page-item.active .page-link {
        background-color: #0f172a;
        color: #fff;
    }
</style>
@endsection