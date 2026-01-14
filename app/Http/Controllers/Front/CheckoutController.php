<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Показ формы оформления заказа
     */
    public function showForm(Request $request)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Ваша корзина пуста');
        }

        return view('front.orders.order_form', compact('cart'));
    }

    /**
     * Сохранение заказа
     */
    public function store(Request $request)
    {
        // 1. Валидация
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'description' => 'nullable|string',
        ]);

        $clientId = $request->cookie('client_id');

        if (!$clientId) {
            return redirect()->back()->with('error', 'Ошибка сессии. Обновите страницу.');
        }

        $cart = Cache::get("cart_$clientId", []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Корзина пуста');
        }

        try {
            // 2. Используем транзакцию для надежности
            $order = DB::transaction(function () use ($request, $clientId, $cart) {
                
                // Считаем итоговую сумму
                $total = 0;
                foreach ($cart as $item) {
                    $total += $item['price'] * $item['quantity'];
                }

                // Создаем заказ
                $order = Order::create([
                    'client_id'   => $clientId,
                    'name'        => $request->name,
                    'phone'       => $request->phone,
                    'address'     => $request->address,
                    'total_price' => $total,
                    'status'      => 'new',
                    'description' => $request->description,
                ]);

                // Создаем позиции заказа
                foreach ($cart as $dishId => $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'dish_id'  => $dishId,
                        'quantity' => $item['quantity'],
                        'price'    => $item['price'],
                    ]);
                }

                return $order;
            });

            // 3. Отправляем событие
            event(new \App\Events\OrderCreated($order));

            // 4. ОЧИСТКА КОРЗИНЫ
            Cache::forget("cart_$clientId");

            // 5. ПЕРЕНАПРАВЛЕНИЕ В МЕНЮ
            return redirect()->route('menu')->with('success', 'Заказ успешно оформлен!');

        } catch (\Exception $e) {
            // Логируем ошибку, если что-то пошло не так
            Log::error("Order creation failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Произошла ошибка при сохранении заказа.');
        }
    }
}