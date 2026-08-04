<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $recentOrders = $user->orders()->latest()->take(5)->get();

        return view('dashboard', compact('user', 'recentOrders'));
    }
}
