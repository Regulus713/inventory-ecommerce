<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;

class CheckoutController extends Controller
{
    const CART_KEY = 'shopping_cart';

    public function index(Request $request)
    {
        $cart = $request->session()->get(self::CART_KEY, []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $products = [];
        $subtotal = 0;
        $itemCount = 0;

        foreach ($cart as $slug => $quantity) {
            $product = Product::where('slug', $slug)->where('is_active', true)->first();
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ];
                $subtotal += $product->price * $quantity;
                $itemCount += $quantity;
            }
        }

        if (empty($products)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $tax = round($subtotal * 0.08, 2);
        $shipping = $subtotal > 500 ? 0 : 15;
        $total = round($subtotal + $tax + $shipping, 2);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('checkout.index', compact('products', 'subtotal', 'tax', 'shipping', 'total', 'itemCount', 'categories'));
    }

    public function store(Request $request)
    {
        $cart = $request->session()->get(self::CART_KEY, []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'shipping_address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $orderItems = [];
        $subtotal = 0;

        foreach ($cart as $slug => $quantity) {
            $product = Product::where('slug', $slug)->where('is_active', true)->lockForUpdate()->first();

            if (!$product) {
                return back()->with('error', 'Product no longer available: ' . $slug);
            }

            if ($product->quantity < $quantity) {
                return back()->with('error', 'Not enough stock for ' . $product->name . '. Available: ' . $product->quantity);
            }

            $orderItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => $product->price * $quantity,
            ];

            $subtotal += $product->price * $quantity;
        }

        $tax = round($subtotal * 0.08, 2);
        $shipping = $subtotal > 500 ? 0 : 15;
        $total = round($subtotal + $tax + $shipping, 2);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'discount' => 0,
                'total' => $total,
                'shipping_method' => 'Standard Shipping',
                'payment_method' => 'Dummy Payment',
                'payment_status' => 'paid',
                'shipping_address' => $validated['shipping_address'] ?? 'Guest checkout',
                'billing_address' => $validated['shipping_address'] ?? 'Guest checkout',
                'contact_email' => $validated['customer_email'] ?? 'guest@example.com',
                'contact_phone' => $validated['customer_phone'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($orderItems as $item) {
                $product = $item['product'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'specifications' => null,
                ]);

                $product->quantity -= $item['quantity'];
                $product->save();
            }

            DB::commit();

            $request->session()->forget(self::CART_KEY);

            return redirect()->route('checkout.success', $order->order_number)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items.product')->firstOrFail();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('checkout.success', compact('order', 'categories'));
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(uniqid() . mt_rand(100, 999));
    }
}
