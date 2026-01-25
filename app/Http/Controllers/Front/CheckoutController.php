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
    public function showForm(Request $request)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Ваша корзина пуста');
        }

        return view('front.orders.order_form', compact('cart'));
    }

    public function store(Request $request)
    {
        // Валидация
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
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
            $order = DB::transaction(function () use ($request, $clientId, $cart) {
                $total = 0;
                foreach ($cart as $item) {
                    $total += $item['price'] * $item['quantity'];
                }

                $order = Order::create([
                    'client_id'   => $clientId,
                    'name'        => $request->name,
                    'phone'       => $request->phone,
                    'address'     => $request->address,
                    'total_price' => $total,
                    'status'      => 'new',
                    'description' => $request->description,
                ]);

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

            event(new \App\Events\OrderCreated($order));

            Cache::forget("cart_$clientId");

            return redirect()->route('menu')->with('success', 'Заказ успешно оформлен!');

        } catch (\Exception $e) {
            Log::error("Order creation failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при сохранении заказа.');
        }
    }
}