@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        {{-- Header dengan Navigasi --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 mb-1 fw-bold text-slate-900">
                    <i class="bi bi-receipt me-2 text-muted"></i>Order #{{ $order->order_number }}
                </h2>
                <p class="text-muted small mb-0">Dipesan pada {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark rounded-3 px-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row g-4">
            {{-- KOLOM KIRI: Rincian Produk --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <h6 class="mb-0 fw-bold text-slate-800">Item Pesanan ({{ $order->items->count() }})</h6>
                    </div>
                    <div class="card-body p-4">
                        @foreach($order->items as $item)
                        <div class="d-flex align-items-center mb-4 last-child-mb-0">
                            <div class="flex-shrink-0">
                                <img src="{{ $item->product->primaryImage?->image_url ?? asset('img/no-image.png') }}" 
                                     class="rounded-3 border" style="width: 70px; height: 70px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-bold text-slate-900">{{ $item->product->name }}</h6>
                                <p class="text-muted small mb-0">
                                    {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-slate-900">
                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        @if(!$loop->last) <hr class="border-slate-100"> @endif
                        @endforeach
                    </div>
                    
                    {{-- Summary Pembayaran --}}
                    <div class="card-footer bg-slate-50 p-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-slate-600 fw-medium">Total Pembayaran</span>
                            <span class="h4 fw-bold mb-0 text-navy">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Detail Alamat Pengiriman (Optional - asumsikan ada field address) --}}
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h6 class="fw-bold text-slate-800 mb-3"><i class="bi bi-geo-alt me-2"></i>Alamat Pengiriman</h6>
                    <p class="text-slate-600 mb-0 small lh-base">
                        {{ $order->shipping_address ?? 'Informasi alamat tidak tersedia atau diambil di toko.' }}
                    </p>
                </div>
            </div>

            {{-- KOLOM KANAN: Kontrol & Customer --}}
            <div class="col-lg-4">
                {{-- Panel Status Order --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-slate-800">Kontrol Pesanan</h6>
                        
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Ubah Status</label>
                                <select name="status" class="form-select border-slate-200 shadow-none py-2 px-3 rounded-3 mb-2">
                                    @php
                                        $statuses = [
                                            'pending' => 'Pending (Menunggu)',
                                            'processing' => 'Processing (Dikemas)',
                                            'shipped' => 'Shipped (Dikirim)',
                                            'delivered' => 'Delivered (Sampai)',
                                            'cancelled' => 'Cancelled (Batal)'
                                        ];
                                    @endphp
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ $order->status == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-info-circle me-1"></i> Perubahan status akan menginfokan pelanggan.
                                </small>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-2 rounded-3 fw-bold shadow-sm" style="background-color: #0f172a;">
                                Update Status
                            </button>
                        </form>

                        @if($order->status == 'cancelled')
                        <div class="mt-3 p-3 rounded-3 bg-danger-soft text-danger-dark small border border-danger-subtle">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Pesanan dibatalkan. Sistem telah mengembalikan stok secara otomatis.
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Card Info Customer --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-slate-800">Pelanggan</h6>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-slate-100 d-flex align-items-center justify-content-center text-navy fw-bold" style="width: 45px; height: 45px;">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                            <div class="ms-3">
                                <div class="fw-bold text-slate-900">{{ $order->user->name }}</div>
                                <div class="text-muted small">{{ $order->user->email }}</div>
                            </div>
                        </div>
                        <hr class="my-3 border-slate-100">
                        <a href="mailto:{{ $order->user->email }}" class="btn btn-light w-100 rounded-3 text-slate-600 fw-medium small border">
                            <i class="bi bi-envelope me-2"></i>Hubungi Pelanggan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-navy { color: #0f172a; }
    .bg-slate-50 { background-color: #f8fafc; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .border-slate-100 { border-color: #f1f5f9; }
    .text-slate-800 { color: #1e293b; }
    .text-slate-900 { color: #0f172a; }
    
    .bg-danger-soft { background-color: rgba(239, 68, 68, 0.1); }
    .text-danger-dark { color: #b91c1c; }

    .last-child-mb-0:last-child { margin-bottom: 0 !important; }
</style>
@endsection