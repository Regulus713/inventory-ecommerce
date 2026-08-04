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
        $sort = $this->getSortField($request->input('sort', 'newest'));
        $view = $this->getView($request->input('view', 'card'));

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

        $productQuery = $this->applySorting($productQuery, $request->input('sort', 'newest'));

        $allProducts = $productQuery->paginate(12)->withQueryString();
        $featuredProducts = $search ? collect() : Product::where('is_active', true)->where('is_featured', true)->get();

        return view('inventory.index', compact('categories', 'featuredProducts', 'allProducts', 'search', 'sort', 'view'));
    }

    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $sort = $this->getSortField($request->input('sort', 'newest'));
        $view = $this->getView($request->input('view', 'card'));

        $productQuery = $category->products()->where('is_active', true);
        $productQuery = $this->applySorting($productQuery, $request->input('sort', 'newest'));

        $products = $productQuery->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('inventory.category', compact('category', 'products', 'categories', 'sort', 'view'));
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

    private function getSortField(?string $sort): string
    {
        return in_array($sort, ['newest', 'oldest', 'price-asc', 'price-desc', 'name-asc', 'name-desc'])
            ? $sort
            : 'newest';
    }

    private function getView(?string $view): string
    {
        return in_array($view, ['card', 'list']) ? $view : 'card';
    }

    private function applySorting($query, string $sort)
    {
        return match ($sort) {
            'oldest' => $query->oldest(),
            'price-asc' => $query->orderBy('price', 'asc'),
            'price-desc' => $query->orderBy('price', 'desc'),
            'name-asc' => $query->orderBy('name', 'asc'),
            'name-desc' => $query->orderBy('name', 'desc'),
            default => $query->latest(),
        };
    }

    public function search(Request $request)
    {
        $search = $request->input('q');
        $categorySlug = $request->input('category');

        $query = Product::where('is_active', true);

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->where('is_active', true)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%')
                    ->orWhere('manufacturer', 'like', '%' . $search . '%')
                    ->orWhere('model', 'like', '%' . $search . '%');
            });
        }

        $products = $query->latest()->take(24)->get();

        return response()->json($products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'stock_status' => $product->isInStock() ? 'in-stock' : ($product->isLowStock() ? 'low-stock' : 'out-of-stock'),
                'category_slug' => $product->category->slug,
                'category_name' => $product->category->name,
            ];
        }));
    }
}
