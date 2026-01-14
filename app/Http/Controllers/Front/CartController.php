<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);
        return view('front.cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);

        $dish = Dish::findOrFail($id);

        if(isset($cart[$dish->id])) {
            $cart[$dish->id]['quantity'] = $request->quantity;
        } else {
            $cart[$dish->id] = [
                'name' => $dish->name,
                'price' => $dish->price,
                'quantity' => $request->quantity,
            ];
        }

        Cache::put("cart_$clientId", $cart, 60*24);
        return redirect()->view('cart.index');
    }

public function update(Request $request, $id)
{
    $clientId = $request->cookie('client_id');
    $cart = Cache::get("cart_$clientId", []);

    if (isset($cart[$id])) {
        
        $newQuantity = $request->has('quantity_manual') 
            ? (int)$request->quantity_manual 
            : (int)$request->quantity;

        if ($newQuantity > 0) {
            $cart[$id]['quantity'] = min($newQuantity, 999);
        } else {
            unset($cart[$id]);
        }

        // 3. Сохраняем обновленную корзину в кэш
        Cache::put("cart_$clientId", $cart, now()->addDay());
    }

    return redirect()->back();
}

    // Удалить блюдо
    public function remove(Request $request, $id)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);

        $dish = Dish::findOrFail($id);

        if(isset($cart[$dish->id])) {
            unset($cart[$dish->id]);
            Cache::put("cart_$clientId", $cart, 60*24);
        }

        return redirect()->back();
    }
    //Очистить корзину
    public function clear(Request $request)
    {
        $clientId = $request->cookie('client_id');
        
        \Illuminate\Support\Facades\Cache::put("cart_$clientId", [], 60*24);
    
        return redirect()->back()->with('success', 'Корзина очищена!');
    }

    public function addMultiple(Request $request)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);
    
        foreach ($request->items as $item) {
            $qty = (int) $item['quantity'];
    
            if ($qty <= 0) {
                continue;
            }
    
            $dish = Dish::findOrFail($item['dish_id']);
    
            if (isset($cart[$dish->id])) {
                $cart[$dish->id]['quantity'] += $qty;
            } else {
                $cart[$dish->id] = [
                    'name' => $dish->name,
                    'price' => $dish->price,
                    'quantity' => $qty,
                ];
            }
        }
    
        Cache::put("cart_$clientId", $cart, 60 * 24);
    
        return response()->noContent();
    }

    public function reorder(Request $request, Order $order)
{
    // 1. Получаем идентификатор клиента из куки (как в вашем addMultiple)
    $clientId = $request->cookie('client_id');
    
    // 2. Получаем текущую корзину из кэша
    $cart = Cache::get("cart_$clientId", []);

    // 3. Проходим по товарам старого заказа
    foreach ($order->items as $item) {
        $dish = $item->dish;

        // Пропускаем, если блюдо было удалено из базы
        if (!$dish) continue;

        $qty = (int) $item->quantity;

        // 4. Применяем вашу логику обновления кэша
        if (isset($cart[$dish->id])) {
            $cart[$dish->id]['quantity'] += $qty;
        } else {
            $cart[$dish->id] = [
                'name' => $dish->name,
                'price' => $dish->price,
                'quantity' => $qty,
            ];
        }
    }

    // 5. Сохраняем обновленную корзину в кэш на сутки
    Cache::put("cart_$clientId", $cart, 60 * 24);

    // 6. Редирект в корзину с уведомлением
    return redirect()->route('cart.index')->with('success', 'Заказ повторен!');
}
}
