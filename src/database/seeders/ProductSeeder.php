<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Minimal Black T-Shirt',
                'category_name' => 'Men',
                'price' => 1299.99,
                'image' => '/images/1.png',
                'description' => 'Essential minimalist cotton t-shirt in classic white. Soft fabric for all-day comfort.'
            ],
            [
                'name' => 'Oversized Cotton Sweater',
                'category_name' => 'Women',
                'price' => 79.99,
                'image' => '/images/2.png',
                'description' => 'Relaxed fit wool blend sweater perfect for layering seasonal looks.'
            ],
            [
                'name' => 'Tailored Black Pants',
                'category_name' => 'Men',
                'price' => 89.99,
                'image' => '/images/3.png',
                'description' => 'Slim-fit dress pants crafted from sustainable wool with sharp pressed edges.'
            ],
            [
                'name' => 'Vintage Denim Jacket',
                'category_name' => 'Women',
                'price' => 119.99,
                'image' => '/images/4.png',
                'description' => 'Authentic indigo denim jacket with minimalist design and premium materials.'
            ],
            [
                'name' => 'Silk Collar Shirt',
                'category_name' => 'Men',
                'price' => 69.99,
                'image' => '/images/5.png',
                'description' => 'Elegant button-down shirt with silk collar detailing and smooth fabric.'
            ],
            [
                'name' => 'Structured Blazer',
                'category_name' => 'Women',
                'price' => 199.99,
                'image' => '/images/6.png',
                'description' => 'Tailored blazer with clean lines and modern silhouette for versatile styling.'
            ],
            [
                'name' => 'Mid-Rise Jeans',
                'category_name' => 'Men',
                'price' => 89.99,
                'image' => '/images/7.png',
                'description' => 'Classic straight-leg jeans with signature minimalist detailing.'
            ],
            [
                'name' => 'Cashmere Scarf',
                'category_name' => 'Women',
                'price' => 129.99,
                'image' => '/images/8.png',
                'description' => 'Soft cashmere scarf in neutral tones, perfect for sophisticated layering.'
            ],
            [
                'name' => 'Linen Summer Shirt',
                'category_name' => 'Men',
                'price' => 59.99,
                'image' => '/images/9.png',
                'description' => 'Lightweight linen shirt designed for breathability and modern comfort.'
            ],
            [
                'name' => 'Structured tote',
                'category_name' => 'Women',
                'price' => 49.99,
                'image' => '/images/10.png',
                'description' => 'Minimalist leather tote with clean lines and durable construction.'
            ],
            [
                'name' => 'Wide-Leg Trouser',
                'category_name' => 'Women',
                'price' => 94.99,
                'image' => '/images/11.png',
                'description' => 'High-waisted wide-leg trousers with sophisticated tailoring.'
            ],
            [
                'name' => 'Knit Cardigan',
                'category_name' => 'Men',
                'price' => 79.99,
                'image' => '/images/12.png',
                'description' => 'Fine gauge knit cardigan with subtle texture and comfortable fit.'
            ],
            [
                'name' => 'Leather Sneakers',
                'category_name' => 'Women',
                'price' => 159.99,
                'image' => '/images/13.png',
                'description' => 'Minimalist leather sneakers with clean design and premium comfort.'
            ],
            [
                'name' => 'Oversize Dress',
                'category_name' => 'Women',
                'price' => 84.99,
                'image' => '/images/14.png',
                'description' => 'Relaxed fit midi dress with contemporary cut and soft fabric.'
            ],
            [
                'name' => 'Belt with Minimal Buckle',
                'category_name' => 'Men',
                'price' => 39.99,
                'image' => '/images/15.png',
                'description' => 'Signature leather belt with minimalist hardware and clean design.'
            ],
            [
                'name' => 'Wool Blend Coat',
                'category_name' => 'Women',
                'price' => 249.99,
                'image' => '/images/16.png',
                'description' => 'Structured wool coat with modern silhouette and timeless appeal.'
            ]
        ];

        // Map category names to IDs (assuming seeding order)
        $categories = [
            'Men' => 1,
            'Women' => 2
        ];

        foreach ($products as $productData) {
            Product::create([
                'category_id' => $categories[$productData['category_name']],
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'image' => $productData['image'],
                'stock_quantity' => rand(5, 50), // Random stock between 5-50
                'is_active' => true
            ]);
        }
    }
}
