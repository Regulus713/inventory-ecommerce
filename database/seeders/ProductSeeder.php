<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laptops = Category::where('slug', 'laptops')->first();
        $monitors = Category::where('slug', 'monitors')->first();
        $peripherals = Category::where('slug', 'peripherals')->first();
        $components = Category::where('slug', 'components')->first();

        $products = [
            [
                'name' => 'MacBook Pro 16"',
                'slug' => 'macbook-pro-16',
                'description' => 'Apple M3 Pro chip, 18GB RAM, 512GB SSD',
                'category_id' => $laptops->id,
                'price' => 2499.99,
                'sku' => 'APPLE-MBP16-M3',
                'quantity' => 15,
                'low_stock_threshold' => 5,
                'manufacturer' => 'Apple',
                'model' => 'MacBook Pro 16"',
                'warranty' => '1 Year',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Dell XPS 15',
                'slug' => 'dell-xps-15',
                'description' => 'Intel Core i7, 16GB RAM, 512GB SSD, OLED Display',
                'category_id' => $laptops->id,
                'price' => 1899.99,
                'sku' => 'DELL-XPS15-I7',
                'quantity' => 20,
                'low_stock_threshold' => 5,
                'manufacturer' => 'Dell',
                'model' => 'XPS 15',
                'warranty' => '2 Years',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'LG UltraGear 27" Gaming Monitor',
                'slug' => 'lg-ultragear-27',
                'description' => '27" 165Hz 1ms IPS Gaming Monitor',
                'category_id' => $monitors->id,
                'price' => 349.99,
                'sku' => 'LG-27GN950',
                'quantity' => 30,
                'low_stock_threshold' => 10,
                'manufacturer' => 'LG',
                'model' => '27GN950',
                'warranty' => '1 Year',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Logitech MX Master 3S',
                'slug' => 'logitech-mx-master-3s',
                'description' => 'Advanced wireless mouse with ergonomic design',
                'category_id' => $peripherals->id,
                'price' => 99.99,
                'sku' => 'LOGI-MX3S',
                'quantity' => 50,
                'low_stock_threshold' => 15,
                'manufacturer' => 'Logitech',
                'model' => 'MX Master 3S',
                'warranty' => '2 Years',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Samsung 990 PRO 2TB NVMe SSD',
                'slug' => 'samsung-990-pro-2tb',
                'description' => 'High-performance NVMe SSD for gaming and productivity',
                'category_id' => $components->id,
                'price' => 179.99,
                'sku' => 'SAMSUNG-990PRO-2TB',
                'quantity' => 25,
                'low_stock_threshold' => 8,
                'manufacturer' => 'Samsung',
                'model' => '990 PRO',
                'warranty' => '5 Years',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Keychron K2 Mechanical Keyboard',
                'slug' => 'keychron-k2',
                'description' => 'Wireless mechanical keyboard with RGB backlight',
                'category_id' => $peripherals->id,
                'price' => 79.99,
                'sku' => 'KEYCHRON-K2',
                'quantity' => 40,
                'low_stock_threshold' => 10,
                'manufacturer' => 'Keychron',
                'model' => 'K2',
                'warranty' => '1 Year',
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
