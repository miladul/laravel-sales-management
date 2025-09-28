<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop',
            'price' => 999.99,
            'description' => 'High-performance laptop',
        ]);

        Product::create([
            'name' => 'Smartphone',
            'price' => 499.99,
            'description' => 'Latest model smartphone',
        ]);

        Product::create([
            'name' => 'iPhone 17',
            'price' => 180000.00,
            'description' => 'Latest model smartphone',
        ]);

        Product::create([
            'name' => 'iPhone 17 pro max',
            'price' => 220000.00,
            'description' => 'Latest model smartphone',
        ]);
    }
}
