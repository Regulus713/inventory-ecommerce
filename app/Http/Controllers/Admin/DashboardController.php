<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();

        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $pendingOrders = Order::pending()->count();
        $lowStockProducts = Product::where('quantity', '<=', 5)->where('quantity', '>', 0)->count();
        $outOfStockProducts = Product::where('quantity', 0)->count();

        $recentOrders = Order::with('user', 'items')->latest()->take(5)->get();
        $lowStockItems = Product::where('quantity', '<=', 5)->with('category')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalCategories',
            'totalRevenue',
            'pendingOrders',
            'lowStockProducts',
            'outOfStockProducts',
            'recentOrders',
            'lowStockItems',
            'recentUsers',
        ));
    }
}
