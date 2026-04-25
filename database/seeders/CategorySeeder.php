<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Lantai',
                'slug'        => 'lantai',
                'description' => 'Keramik untuk lantai rumah, gedung, dan bangunan',
                'icon'        => '🏠',
            ],
            [
                'name'        => 'Dinding',
                'slug'        => 'dinding',
                'description' => 'Keramik untuk dinding dalam dan luar ruangan',
                'icon'        => '🧱',
            ],
            [
                'name'        => 'Kamar Mandi',
                'slug'        => 'kamar-mandi',
                'description' => 'Keramik khusus kamar mandi dan toilet',
                'icon'        => '🚿',
            ],
            [
                'name'        => 'Dapur',
                'slug'        => 'dapur',
                'description' => 'Keramik untuk area dapur dan backsplash',
                'icon'        => '🍳',
            ],
            [
                'name'        => 'Teras',
                'slug'        => 'teras',
                'description' => 'Keramik untuk teras, carport, dan area outdoor',
                'icon'        => '🌿',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}