<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Тестовый клиент
        $clientId = Str::uuid();

        // Создаём заказ
        $order = Order::create([
            'client_id' => $clientId,
            'name' => 'Иван Иванов',
            'phone' => '+79991234567',
            'address' => 'г. Москва, ул. Тестовая, д.1',
            'total_price' => 700,
            'status' => 'new'
        ]);

        // Позиции заказа
        OrderItem::create([
            'order_id' => $order->id,
            'dish_id' => 2,
            'quantity' => 2,
            'price' => 250,
            'weight' => 300
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'dish_id' => 2,
            'quantity' => 1,
            'price' => 200,
            'weight' => 400
        ]);
    }
}
