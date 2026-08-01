<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $featuredProducts = Product::where('is_active', true)->where('is_featured', true)->get();
        $allProducts = Product::where('is_active', true)->latest()->paginate(12);

        return view('inventory.index', compact('categories', 'featuredProducts', 'allProducts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = $category->products()->where('is_active', true)->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('inventory.category', compact('category', 'products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('inventory.product', compact('product', 'categories', 'relatedProducts'));
    }
}
