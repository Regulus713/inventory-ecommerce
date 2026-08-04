<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'layouts.admin'], function ($view) {
            $view->with('categories', Category::where('is_active', true)->orderBy('sort_order')->get());

            $cart = session('shopping_cart', []);
            $cartItems = [];
            $cartSubtotal = 0;

            foreach ($cart as $slug => $quantity) {
                $product = Product::where('slug', $slug)->where('is_active', true)->first();
                if ($product) {
                    $subtotal = $product->price * $quantity;
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ];
                    $cartSubtotal += $subtotal;
                }
            }

            $view->with('cartItems', $cartItems);
            $view->with('cartSubtotal', $cartSubtotal);
            $view->with('cartCount', array_sum($cart));
        });
    }
}
