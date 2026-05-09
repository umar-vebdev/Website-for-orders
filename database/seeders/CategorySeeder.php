<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Самса', 'sort_order' => 1],
            ['name' => 'Выпечка с мясом', 'sort_order' => 2],
            ['name' => 'Сытная выпечка', 'sort_order' => 3],
            ['name' => 'Сладкая выпечка', 'sort_order' => 4],
            ['name' => 'Пироги', 'sort_order' => 5],
            ['name' => 'Хлеб', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name'       => $category['name'],
                    'sort_order' => $category['sort_order'],
                    'is_active'  => true,
                ]
            );
        }
    }
}
