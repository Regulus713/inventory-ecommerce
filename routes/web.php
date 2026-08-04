<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

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

// Admin CRUD routes
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
