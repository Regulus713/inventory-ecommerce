<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

// Public inventory routes
Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/category/{slug}', [InventoryController::class, 'category'])->name('inventory.category');
Route::get('/product/{slug}', [InventoryController::class, 'product'])->name('inventory.product');
Route::get('/api/products/search', [InventoryController::class, 'search'])->name('inventory.search');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/api/cart/sidebar', [CartController::class, 'sidebar'])->name('cart.sidebar');
Route::post('/cart/add/{slug}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{slug}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{slug}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

// Auth routes (Breeze)
require __DIR__.'/auth.php';

// Logout route
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('inventory.index');
})->name('logout');

// Authenticated account routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    // Customer account orders
    Route::get('/account/orders', [\App\Http\Controllers\Account\OrderController::class, 'index'])->name('account.orders.index');
    Route::get('/account/orders/{id}', [\App\Http\Controllers\Account\OrderController::class, 'show'])->name('account.orders.show');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Admin CRUD routes (categories & products)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});
