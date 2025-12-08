<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dish;

class DishSeeder extends Seeder
{
    public function run()
    {
        Dish::create([
            'name' => 'Плов',
            'price' => 250,
            'weight' => 300,
            'photo_path' => 'plov.jpg'
        ]);

        Dish::create([
            'name' => 'Борщ',
            'price' => 200,
            'weight' => 400,
            'photo_path' => 'borsh.jpg'
        ]);

        Dish::create([
            'name' => 'Шашлык',
            'price' => 350,
            'weight' => 250,
            'photo_path' => 'shashlik.jpg'
        ]);
    }
}
