<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Public inventory routes
Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/category/{slug}', [InventoryController::class, 'category'])->name('inventory.category');
Route::get('/product/{slug}', [InventoryController::class, 'product'])->name('inventory.product');
Route::get('/api/products/search', [InventoryController::class, 'search'])->name('inventory.search');

// Admin CRUD routes
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
