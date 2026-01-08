@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1 text-slate-900 fw-bold" style="color: #0f172a;">Laporan Penjualan</h2>
            <p class="text-muted small mb-0">Pantau performa bisnis dan arus kas Anda secara real-time.</p>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4">
            <form method="GET" class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-slate-600">DARI TANGGAL</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control border-slate-200 shadow-none">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-slate-600">SAMPAI TANGGAL</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control border-slate-200 shadow-none">
                </div>
                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-dark px-4 rounded-3" style="background-color: #0f172a;">
                        <i class="bi bi-funnel me-1"></i> Terapkan Filter
                    </button>
                    {{-- Tombol Export --}}
                    <a href="{{ route('admin.reports.sales', array_merge(request()->all(), ['export' => 'excel'])) }}" 
                       class="btn btn-outline-success px-4 rounded-3 border-2">
                        <i class="bi bi-file-earmark-spreadsheet me-1"></i> Simpan Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm border-start border-4 h-100 rounded-3" style="border-color: #10b981 !important;">
                <div class="card-body p-4">
                    <div class="text-muted small text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">Total Pendapatan Bersih</div>
                    <div class="h3 fw-bold mb-1" style="color: #0f172a;">
                         Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-success small fw-medium">
                        <i class="bi bi-check-circle-fill me-1"></i> Dari total pesanan dibayar
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm border-start border-4 h-100 rounded-3" style="border-color: #0f172a !important;">
                <div class="card-body p-4">
                    <div class="text-muted small text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">Volume Transaksi</div>
                    <div class="h3 fw-bold mb-1" style="color: #0f172a;">
                        {{ number_format($summary->total_orders ?? 0) }}
                    </div>
                    <div class="text-muted small fw-medium">Pesanan masuk dalam periode ini</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Sales By Category --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold" style="color: #0f172a;">Dominasi Kategori</h5>
                </div>
                <div class="card-body px-4 pt-0">
                    @forelse($byCategory as $cat)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-medium text-slate-700">{{ $cat->name }}</span>
                                <span class="fw-bold text-slate-900">Rp {{ number_format($cat->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px; background-color: #f1f5f9;">
                                <div class="progress-bar" role="progressbar"
                                     style="width: {{ ($cat->total / ($summary->total_revenue ?: 1)) * 100 }}%; background-color: #0f172a;">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-5">Belum ada data kategori.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Transactions Table --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                     <h5 class="card-title mb-0 fw-bold" style="color: #0f172a;">Rincian Transaksi Terakhir</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr style="background-color: #f8fafc;">
                                <th class="ps-4 border-0 py-3 text-slate-500 small fw-bold">ORDER ID</th>
                                <th class="border-0 py-3 text-slate-500 small fw-bold">TANGGAL</th>
                                <th class="border-0 py-3 text-slate-500 small fw-bold">CUSTOMER</th>
                                <th class="text-end pe-4 border-0 py-3 text-slate-500 small fw-bold">TOTAL BAYAR</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($orders as $order)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-decoration-none" style="color: #0f172a;">
                                            #{{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td class="text-muted py-3">{{ $order->created_at->format('d M Y') }} <span class="small opacity-50">{{ $order->created_at->format('H:i') }}</span></td>
                                    <td class="py-3">
                                        <div class="fw-semibold text-slate-800">{{ $order->user->name }}</div>
                                        <div class="small text-muted">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="text-end pe-4 py-3 fw-bold text-slate-900">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                        Tidak ada data penjualan pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $orders->appends(request()->all())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection