<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('q');

        $query = Order::with('user', 'items');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhere('contact_email', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders', 'status', 'search'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->status = $validated['status'];

        if ($validated['status'] === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = now();
        }

        if ($validated['status'] === 'delivered' && !$order->delivered_at) {
            $order->delivered_at = now();
        }

        $order->save();

        return back()->with('success', 'Order status updated to ' . ucfirst($validated['status']) . '.');
    }
}
