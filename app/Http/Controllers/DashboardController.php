<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show dashboard with statistics.
     */
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // General counts
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalUsers = User::count();

        // Today's sales
        $todaySalesCount = Sale::whereDate('created_at', $today)
            ->where('status', '!=', 'cancelled')
            ->count();
        $todaySalesRevenue = Sale::whereDate('created_at', $today)
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        // This month's sales
        $monthSalesCount = Sale::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', '!=', 'cancelled')
            ->count();
        $monthSalesRevenue = Sale::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        // Total purchases
        $totalPurchases = Purchase::where('status', '!=', 'cancelled')->count();

        // Low stock products
        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->get();

        // Recent 5 sales
        $recentSales = Sale::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent 5 purchases
        $recentPurchases = Purchase::with(['supplier', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalUsers',
            'todaySalesCount',
            'todaySalesRevenue',
            'monthSalesCount',
            'monthSalesRevenue',
            'totalPurchases',
            'lowStockProducts',
            'recentSales',
            'recentPurchases'
        ));
    }
}
