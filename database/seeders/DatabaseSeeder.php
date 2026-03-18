<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin user
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@shop.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // Regular user
        User::create([
            'name'     => 'John Doe',
            'email'    => 'john@example.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        // Categories
        $categories = [
            ['name' => 'Electronics',   'description' => 'Phones, laptops, gadgets and more'],
            ['name' => 'Clothing',       'description' => 'Fashion for men and women'],
            ['name' => 'Books',          'description' => 'Fiction, non-fiction, textbooks'],
            ['name' => 'Home & Garden',  'description' => 'Furniture, decor, garden tools'],
            ['name' => 'Sports',         'description' => 'Equipment and clothing for all sports'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'description' => $cat['description'],
            ]);
        }

        // Sample products
        $products = [
            ['category' => 'Electronics',  'name' => 'Wireless Headphones',    'price' => 79.99,  'stock' => 50,  'description' => 'High-quality wireless headphones with noise cancellation and 30-hour battery life.'],
            ['category' => 'Electronics',  'name' => 'Smart Watch',             'price' => 199.99, 'stock' => 30,  'description' => 'Track your fitness, receive notifications, and more with this sleek smart watch.'],
            ['category' => 'Electronics',  'name' => 'Bluetooth Speaker',       'price' => 49.99,  'stock' => 75,  'description' => 'Portable waterproof Bluetooth speaker with 360° sound.'],
            ['category' => 'Electronics',  'name' => 'USB-C Hub',               'price' => 34.99,  'stock' => 100, 'description' => '7-in-1 USB-C hub with HDMI, USB 3.0, and SD card reader.'],
            ['category' => 'Clothing',     'name' => 'Classic White T-Shirt',   'price' => 19.99,  'stock' => 200, 'description' => 'Premium cotton classic white t-shirt, available in all sizes.'],
            ['category' => 'Clothing',     'name' => 'Denim Jeans',             'price' => 59.99,  'stock' => 80,  'description' => 'Slim-fit denim jeans made from 100% organic cotton.'],
            ['category' => 'Clothing',     'name' => 'Leather Jacket',          'price' => 149.99, 'stock' => 20,  'description' => 'Genuine leather jacket with modern design.'],
            ['category' => 'Books',        'name' => 'Clean Code',              'price' => 29.99,  'stock' => 60,  'description' => 'A handbook of agile software craftsmanship by Robert C. Martin.'],
            ['category' => 'Books',        'name' => 'Laravel Up & Running',    'price' => 39.99,  'stock' => 40,  'description' => 'A framework for building modern PHP apps with Laravel.'],
            ['category' => 'Books',        'name' => 'The Pragmatic Programmer','price' => 34.99,  'stock' => 55,  'description' => 'Your journey to mastery in software development.'],
            ['category' => 'Home & Garden','name' => 'Ceramic Plant Pot Set',   'price' => 24.99,  'stock' => 90,  'description' => 'Set of 3 minimalist ceramic plant pots in different sizes.'],
            ['category' => 'Home & Garden','name' => 'LED Desk Lamp',           'price' => 44.99,  'stock' => 65,  'description' => 'Eye-care LED desk lamp with adjustable color temperature.'],
            ['category' => 'Sports',       'name' => 'Yoga Mat',                'price' => 29.99,  'stock' => 120, 'description' => 'Non-slip eco-friendly yoga mat, 6mm thick.'],
            ['category' => 'Sports',       'name' => 'Running Shoes',           'price' => 89.99,  'stock' => 45,  'description' => 'Lightweight breathable running shoes with extra cushioning.'],
            ['category' => 'Sports',       'name' => 'Resistance Bands Set',    'price' => 19.99,  'stock' => 150, 'description' => 'Set of 5 resistance bands for strength training and physical therapy.'],
        ];

        $categoryMap = Category::pluck('id', 'name');

        foreach ($products as $p) {
            Product::create([
                'category_id' => $categoryMap[$p['category']],
                'name'        => $p['name'],
                'slug'        => Str::slug($p['name']),
                'description' => $p['description'],
                'price'       => $p['price'],
                'stock'       => $p['stock'],
                'active'      => true,
            ]);
        }
    }
}
