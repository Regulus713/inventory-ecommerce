<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    const CART_KEY = 'shopping_cart';

    public function index(Request $request)
    {
        $cart = $request->session()->get(self::CART_KEY, []);
        $products = [];
        $subtotal = 0;

        foreach ($cart as $slug => $quantity) {
            $product = Product::where('slug', $slug)->where('is_active', true)->first();
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ];
                $subtotal += $product->price * $quantity;
            }
        }

        $categories = \App\Models\Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('cart.index', compact('products', 'subtotal', 'categories'));
    }

    public function add(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity < 1) $quantity = 1;
        if ($quantity > $product->quantity) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $product->quantity . ' units available.',
                    'cart_count' => array_sum($request->session()->get(self::CART_KEY, [])),
                ]);
            }
            return back()->with('error', 'Only ' . $product->quantity . ' units available.');
        }

        $cart = $request->session()->get(self::CART_KEY, []);

        if (isset($cart[$slug])) {
            $newQuantity = $cart[$slug] + $quantity;
            if ($newQuantity > $product->quantity) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only ' . $product->quantity . ' units available.',
                        'cart_count' => array_sum($cart),
                    ]);
                }
                return back()->with('error', 'Only ' . $product->quantity . ' units available.');
            }
            $cart[$slug] = $newQuantity;
        } else {
            $cart[$slug] = $quantity;
        }

        $request->session()->put(self::CART_KEY, $cart);

        $message = $product->name . ' added to cart.';
        $cartCount = array_sum($cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cartCount,
            ]);
        }

        return back()->with('success', $message);
    }

    public function update(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity < 1) $quantity = 1;
        if ($quantity > $product->quantity) {
            return back()->with('error', 'Only ' . $product->quantity . ' units available.');
        }

        $cart = $request->session()->get(self::CART_KEY, []);
        $cart[$slug] = $quantity;
        $request->session()->put(self::CART_KEY, $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request, $slug)
    {
        $cart = $request->session()->get(self::CART_KEY, []);
        unset($cart[$slug]);
        $request->session()->put(self::CART_KEY, $cart);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear(Request $request)
    {
        $request->session()->forget(self::CART_KEY);

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
