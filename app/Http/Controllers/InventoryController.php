<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $search = $request->input('q');

        $productQuery = Product::where('is_active', true);

        if ($search) {
            $productQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%')
                    ->orWhere('manufacturer', 'like', '%' . $search . '%')
                    ->orWhere('model', 'like', '%' . $search . '%');
            });
        }

        $allProducts = $productQuery->latest()->paginate(12)->withQueryString();
        $featuredProducts = $search ? collect() : Product::where('is_active', true)->where('is_featured', true)->get();

        return view('inventory.index', compact('categories', 'featuredProducts', 'allProducts', 'search'));
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
