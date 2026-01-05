<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() // Nama method diseragamkan menjadi 'index'
    {
        // 1. Statistik Utama
        $stats = [
            'total_revenue' => Order::whereIn('status', ['processing', 'completed'])->sum('total_amount'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->where('payment_status', 'paid')->count(),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'low_stock' => Product::where('stock', '<=', 5)->count(),
        ];

        // 2. Data Tabel Pesanan Terbaru
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // 3. Produk Terlaris
        $topProducts = Product::withCount(['orderItems as sold' => function ($q) {
                $q->select(DB::raw('SUM(quantity)'))
                  ->whereHas('order', function($query) {
                      $query->where('payment_status', 'paid');
                  });
            }])
            ->having('sold', '>', 0)
            ->orderByDesc('sold')
            ->take(5)
            ->get();

        // 4. Data Grafik Pendapatan
        $revenueChart = Order::select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            ])
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'revenueChart'));
    }
}