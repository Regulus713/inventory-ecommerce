<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $role = $request->input('role', 'all');

        $query = User::withCount('orders');

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'role'));
    }

    public function show($id)
    {
        $user = User::withCount('orders')->findOrFail($id);
        $orders = Order::where('user_id', $user->id)->latest()->paginate(10);
        $cart = $user->cart()->with('items.product')->first();

        return view('admin.users.show', compact('user', 'orders', 'cart'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role' => 'required|in:admin,customer',
        ]);

        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'You cannot demote yourself.');
        }

        $user->role = $validated['role'];
        $user->save();

        return back()->with('success', 'User role updated to ' . ucfirst($validated['role']) . '.');
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        if ($user->id === auth()->id() && ! $validated['is_active']) {
            return back()->with('error', 'You cannot disable your own account.');
        }

        $user->is_active = $validated['is_active'];
        $user->save();

        $status = $user->is_active ? 'enabled' : 'disabled';

        return back()->with('success', 'User account ' . $status . '.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
