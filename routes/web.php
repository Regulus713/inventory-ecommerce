<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/category/{slug}', [InventoryController::class, 'category'])->name('inventory.category');
Route::get('/product/{slug}', [InventoryController::class, 'product'])->name('inventory.product');
