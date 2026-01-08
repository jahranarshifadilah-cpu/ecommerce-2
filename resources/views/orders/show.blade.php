@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                {{-- Breadcrumb simpel --}}
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-decoration-none text-muted">Pesanan Saya</a></li>
                        <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">Detail #{{ $order->order_number }}</li>
                    </ol>
                </nav>

                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    {{-- Header Order --}}
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="h4 mb-1 fw-bold text-dark">
                                    Invoice #{{ $order->order_number }}
                                </h1>
                                <p class="text-muted small mb-0">
                                    Dipesan pada {{ $order->created_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>

                            {{-- Status Badge (Muted Colors) --}}
                            <span class="badge px-3 py-2 fw-semibold" 
                                  style="border-radius: 8px; font-size: 0.8rem;
                                    @if($order->status == 'pending') background-color: #fef3c7; color: #92400e;
                                    @elseif($order->status == 'processing') background-color: #e0f2fe; color: #075985;
                                    @elseif($order->status == 'shipped') background-color: #e0e7ff; color: #3730a3;
                                    @elseif($order->status == 'delivered') background-color: #dcfce7; color: #166534;
                                    @elseif($order->status == 'cancelled') background-color: #fee2e2; color: #991b1b;
                                    @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Detail Items --}}
                    <div class="card-body px-4">
                        <h6 class="text-uppercase small fw-bold text-muted mb-3" style="letter-spacing: 1px;">Rincian Produk</h6>
                        
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="small text-muted" style="background-color: #f8fafc;">
                                    <tr>
                                        <th class="border-0 py-3 ps-3">Item</th>
                                        <th class="border-0 py-3 text-center">Jumlah</th>
                                        <th class="border-0 py-3 text-end pe-3">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td class="py-3 ps-3">
                                            <div class="fw-semibold text-dark">{{ $item->product_name }}</div>
                                            <div class="text-muted small">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="py-3 text-center text-muted">{{ $item->quantity }}x</td>
                                        <td class="py-3 text-end pe-3 fw-medium">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Ringkasan Biaya --}}
                        <div class="row justify-content-end mt-3">
                            <div class="col-md-5">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Ongkos Kirim</span>
                                    <span class="text-dark">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                </div>
                                <hr class="my-2 opacity-50">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold text-dark">Total Pembayaran</span>
                                    <span class="fw-bold fs-5" style="color: #0f172a;">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Alamat & Pembayaran --}}
                    <div class="card-footer bg-white border-0 px-4 pb-4 mt-3">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="text-uppercase small fw-bold text-muted mb-2" style="letter-spacing: 1px;">Alamat Pengiriman</h6>
                                <div class="p-3 border rounded-3" style="background-color: #f8fafc;">
                                    <div class="fw-bold text-dark mb-1">{{ $order->shipping_name }}</div>
                                    <div class="text-muted small mb-2">{{ $order->shipping_phone }}</div>
                                    <div class="text-secondary small mb-0">{{ $order->shipping_address }}</div>
                                </div>
                            </div>
                            
                            {{-- Area Tombol Bayar --}}
                            <div class="col-md-6 d-flex flex-column justify-content-end">
                                @if($order->status === 'pending' && $snapToken)
                                    <div class="text-md-end">
                                        <p class="small text-muted mb-3">Mohon selesaikan pembayaran agar pesanan dapat segera kami proses.</p>
                                        <button id="pay-button" class="btn btn-dark w-100 py-3 fw-bold" style="background-color: #0f172a; border-radius: 10px;">
                                            <i class="bi bi-shield-check me-2"></i> Bayar Sekarang
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('orders.index') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .breadcrumb-item + .breadcrumb-item::before { content: "›"; }
        .table thead th { font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        #pay-button:hover { background-color: #1e293b !important; transform: translateY(-2px); transition: all 0.2s; }
        .card { box-shadow: 0 10px 30px rgba(0,0,0,0.03) !important; }
    </style>

    {{-- Midtrans Snap Script tetap sama --}}
    @if($snapToken)
    @push('scripts')
        <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('pay-button');
                if (payButton) {
                    payButton.addEventListener('click', function() {
                        payButton.disabled = true;
                        payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghubungkan...';
                        
                        window.snap.pay('{{ $snapToken }}', {
                            onSuccess: function(result) { window.location.href = '{{ route("orders.success", $order) }}'; },
                            onPending: function(result) { window.location.href = '{{ route("orders.pending", $order) }}'; },
                            onError: function(result) { 
                                alert('Pembayaran gagal!'); 
                                payButton.disabled = false; 
                                payButton.innerHTML = '<i class="bi bi-shield-check me-2"></i> Bayar Sekarang';
                            },
                            onClose: function() { 
                                payButton.disabled = false; 
                                payButton.innerHTML = '<i class="bi bi-shield-check me-2"></i> Bayar Sekarang';
                            }
                        });
                    });
                }
            });
        </script>
    @endpush
    @endif
@endsection