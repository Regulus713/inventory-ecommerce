<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => uniqid() . '@localhost',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'username' => 'test',
            'email' => uniqid() . '@localhost',
            'role' => 'customer',
        ]);
    }
}
