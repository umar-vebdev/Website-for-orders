<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Events\OrderCreated;

class CheckoutController extends Controller
{
    public function showForm(Request $request)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);
        return view('front.orders.order_form', compact('cart'));
    }
    function formatRussianPhone($phone) {
        $digits = preg_replace('/\D+/', '', $phone);
    
        if (strlen($digits) === 11 && $digits[0] === '8') {
            $digits = '7' . substr($digits, 1);
        }
    
        return $digits;
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'description' => 'string|nullable',
        ]);

        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);

        if(empty($cart)) {
            return redirect()->back()->with('error', 'Корзина пуста');
        }

        // Создаем заказ
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'client_id' => $clientId,
            'name' => $request->name,
            'phone' => $this->formatRussianPhone($request->phone),
            'address' => $request->address,
            'total_price' => $total,
            'status' => 'new',
            'description' => $request->description,
        ]);

        event(new OrderCreated($order));

        // Сохраняем позиции
        foreach($cart as $dishId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'dish_id' => $dishId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'weight' => $item['weight'],
            ]);
        }

        Cache::forget("cart_$clientId");

        return redirect()->route('my.orders')->with('success', 'Заказ оформлен!');
    }
}
