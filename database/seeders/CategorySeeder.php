<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Portable computers for work and gaming',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Monitors',
                'slug' => 'monitors',
                'description' => 'Computer displays and screens',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Peripherals',
                'slug' => 'peripherals',
                'description' => 'Keyboards, mice, and other input devices',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Components',
                'slug' => 'components',
                'description' => 'Computer components and parts',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Networking',
                'slug' => 'networking',
                'description' => 'Network equipment and accessories',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Computer accessories and add-ons',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
