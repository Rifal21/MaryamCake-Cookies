<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $lastMonth = $now->copy()->subMonth();

        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_products' => Product::count(),
            'revenue' => Order::where('status', 'completed')->sum('total_price'),
            'monthly_revenue' => Order::where('status', 'completed')
                ->where('created_at', '>=', $startOfMonth)
                ->sum('total_price'),
            'last_month_revenue' => Order::where('status', 'completed')
                ->whereBetween('created_at', [$lastMonth->copy()->startOfMonth(), $lastMonth->copy()->endOfMonth()])
                ->sum('total_price'),
        ];

        $recentOrders = Order::latest()->take(5)->get();

        $topProducts = \App\Models\OrderItem::select('product_id', \DB::raw('SUM(quantity) as total_sold'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}
