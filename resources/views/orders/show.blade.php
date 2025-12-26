{{-- resources/views/orders/show.blade.php --}}

@extends('layouts.app') <!-- Asumsi layout admin sudah menggunakan Bootstrap 5 -->

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    {{-- Header Order --}}
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="h3 mb-0 fw-bold text-dark">
                                    Order #{{ $order->order_number }}
                                </h1>
                                <p class="text-muted mb-0 mt-1">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>

                            {{-- Status Badge --}}
                            <span class="badge rounded-pill fs-6
                                @switch($order->status)
                                    @case('pending')
                                        text-bg-warning
                                        @break
                                    @case('processing')
                                        text-bg-info
                                        @break
                                    @case('shipped')
                                        text-bg-primary
                                        @break
                                    @case('delivered')
                                        text-bg-success
                                        @break
                                    @case('cancelled')
                                        text-bg-danger
                                        @break
                                @endswitch
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Detail Items --}}
                    <div class="card-body">
                        <h3 class="h5 fw-semibold mb-4">Produk yang Dipesan</h3>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start">Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    @if($order->shipping_cost > 0)
                                    <tr>
                                        <td colspan="3" class="text-end pt-3">Ongkos Kirim:</td>
                                        <td class="text-end pt-3">
                                            Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr class="border-top border-dark">
                                        <td colspan="3" class="text-end fw-bold fs-5 pt-3">
                                            TOTAL BAYAR:
                                        </td>
                                        <td class="text-end fw-bold fs-5 text-primary pt-3">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Alamat Pengiriman --}}
                    <div class="card-footer bg-light">
                        <h3 class="h5 fw-semibold mb-3">Alamat Pengiriman</h3>
                        <address class="mb-0">
                            <strong>{{ $order->shipping_name }}</strong><br>
                            {{ $order->shipping_phone }}<br>
                            {{ $order->shipping_address }}
                        </address>
                    </div>

                    {{-- Tombol Bayar (hanya tampil jika pending) --}}
                    @if($order->status === 'pending' && $snapToken)
                    <div class="card-footer bg-primary-subtle text-center py-4">
                        <p class="text-muted mb-4">
                            Selesaikan pembayaran Anda sebelum batas waktu berakhir.
                        </p>
                        <button id="pay-button"
                                class="btn btn-primary btn-lg shadow-sm scale-hover">
                            💳 Bayar Sekarang
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Custom CSS untuk hover scale (karena Bootstrap 5 tidak punya built-in scale) --}}
    <style>
        .scale-hover {
            transition: transform 0.15s ease-in-out;
        }
        .scale-hover:hover {
            transform: scale(1.05);
        }
    </style>

    {{-- Snap.js Integration --}}
    @if($snapToken)
    @push('scripts')
        {{-- Load Snap JS dari Midtrans --}}
        <script src="{{ config('midtrans.snap_url') }}"
                data-client-key="{{ config('midtrans.client_key') }}"></script>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('pay-button');

                if (payButton) {
                    payButton.addEventListener('click', function() {
                        // Disable button untuk mencegah double click
                        payButton.disabled = true;
                        payButton.textContent = 'Memproses...';

                        // Panggil Snap.pay dengan token dari server
                        window.snap.pay('{{ $snapToken }}', {

                            // ✅ Callback saat pembayaran SUKSES
                            onSuccess: function(result) {
                                console.log('Payment Success:', result);
                                window.location.href = '{{ route("orders.success", $order) }}';
                            },

                            // ⏳ Callback saat pembayaran PENDING
                            onPending: function(result) {
                                console.log('Payment Pending:', result);
                                window.location.href = '{{ route("orders.pending", $order) }}';
                            },

                            // ❌ Callback saat pembayaran GAGAL
                            onError: function(result) {
                                console.log('Payment Error:', result);
                                alert('Pembayaran gagal! Silakan coba lagi.');
                                payButton.disabled = false;
                                payButton.textContent = '💳 Bayar Sekarang';
                            },

                            // 🚪 Callback saat popup DITUTUP tanpa menyelesaikan
                            onClose: function() {
                                console.log('Payment popup closed');
                                payButton.disabled = false;
                                payButton.textContent = '💳 Bayar Sekarang';
                            }
                        });
                    });
                }
            });
        </script>
    @endpush
    @endif
@endsection