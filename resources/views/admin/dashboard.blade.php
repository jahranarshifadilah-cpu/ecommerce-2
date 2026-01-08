@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-4 mb-4">
        {{-- 1. Stats Cards Grid --}}

        {{-- Revenue Card --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-4 h-100" style="border-color: #0f172a !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase fw-bold mb-1" style="font-size: 0.75rem; color: #64748b; letter-spacing: 0.5px;">Total Pendapatan</p>
                            <h4 class="fw-bold mb-0" style="color: #0f172a;">
                                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                            </h4>
                        </div>
                        <div class="p-3 rounded-3" style="background-color: rgba(15, 23, 42, 0.05);">
                            <i class="bi bi-wallet2 fs-3" style="color: #0f172a;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Action Card --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-4 border-warning h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase fw-bold mb-1" style="font-size: 0.75rem; color: #64748b; letter-spacing: 0.5px;">Perlu Diproses</p>
                            <h4 class="fw-bold mb-0 text-warning">
                                {{ $stats['pending_orders'] }}
                            </h4>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-box-seam text-warning fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low Stock Card --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase fw-bold mb-1" style="font-size: 0.75rem; color: #64748b; letter-spacing: 0.5px;">Stok Menipis</p>
                            <h4 class="fw-bold mb-0 text-danger">
                                {{ $stats['low_stock'] }}
                            </h4>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-exclamation-triangle text-danger fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-4 h-100" style="border-color: #334155 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-uppercase fw-bold mb-1" style="font-size: 0.75rem; color: #64748b; letter-spacing: 0.5px;">Total Produk</p>
                            <h4 class="fw-bold mb-0" style="color: #334155;">
                                {{ $stats['total_products'] }}
                            </h4>
                        </div>
                        <div class="p-3 rounded-3" style="background-color: rgba(51, 65, 85, 0.05);">
                            <i class="bi bi-tags fs-3" style="color: #334155;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- 2. Revenue Chart --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold" style="color: #0f172a;">Grafik Penjualan</h5>
                    <p class="text-muted small mb-0">Statistik pendapatan 7 hari terakhir</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <canvas id="revenueChart" height="280"></canvas>
                </div>
            </div>
        </div>

        {{-- 3. Recent Orders --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold" style="color: #0f172a;">Pesanan Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($recentOrders as $order)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 border-light">
                                <div>
                                    <div class="fw-bold" style="color: #0f172a;">#{{ $order->order_number }}</div>
                                    <small class="text-muted">{{ $order->user->name }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold" style="color: #0f172a;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                    <span class="badge rounded-pill shadow-sm py-1 px-2" 
                                          style="font-size: 0.7rem; background-color: {{ $order->payment_status == 'paid' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(100, 116, 139, 0.1)' }}; 
                                                 color: {{ $order->payment_status == 'paid' ? '#059669' : '#475569' }};">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center py-4">
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none fw-bold small" style="color: #0f172a;">
                        LIHAT SEMUA PESANAN <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. Top Selling Products --}}
    <div class="card border-0 shadow-sm mt-4 rounded-4">
        <div class="card-header bg-white border-0 py-4 px-4">
            <h5 class="card-title mb-0 fw-bold" style="color: #0f172a;">Produk Terlaris</h5>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="row g-4">
                @foreach($topProducts as $product)
                    <div class="col-6 col-md-2">
                        <div class="card h-100 border-0 text-center p-2 rounded-3 hover-effect" style="background-color: #f8fafc;">
                            <img src="{{ $product->image_url }}" class="card-img-top rounded-3 mb-3 mx-auto" style="width: 80px; height: 80px; object-fit: cover;">
                            <h6 class="card-title text-truncate px-2 mb-1" style="font-size: 0.85rem; color: #0f172a;">{{ $product->name }}</h6>
                            <span class="badge bg-white text-dark shadow-sm border mx-auto" style="font-size: 0.7rem; width: fit-content;">{{ $product->sold }} Terjual</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .hover-effect { transition: all 0.3s ease; }
        .hover-effect:hover { transform: translateY(-5px); background-color: #f1f5f9 !important; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    </style>

    {{-- Script Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const labels = {!! json_encode($revenueChart->pluck('date')) !!};
        const data = {!! json_encode($revenueChart->pluck('total')) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: data,
                    borderColor: '#0f172a',
                    backgroundColor: 'rgba(15, 23, 42, 0.05)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#0f172a',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        callbacks: {
                            label: (context) => 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw)
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#e2e8f0' },
                        ticks: {
                            color: '#64748b',
                            callback: (v) => 'Rp ' + new Intl.NumberFormat('id-ID', { notation: "compact" }).format(v)
                        }
                    },
                    x: { grid: { display: false }, ticks: { color: '#64748b' } }
                }
            }
        });
    </script>
@endsection