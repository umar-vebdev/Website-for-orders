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
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);
        return view('front.cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);

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

        Cache::put($cartKey, $cart, now()->addDays(7));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart' => $cart,
                'total_items' => array_sum(array_column($cart, 'quantity')),
                'total_price' => array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)),
            ]);
        }

        return redirect()->route('cart.index');
    }

public function update(Request $request, $id)
{
    $clientId = $request->cookie('client_id');
    $cartKey = 'cart_' . md5($clientId ?? 'guest');
    $cart = Cache::get($cartKey, []);

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
        Cache::put($cartKey, $cart, now()->addDay());
    }

    return redirect()->back();
}

    // Удалить блюдо
    public function remove(Request $request, $id)
    {
        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);

        $dish = Dish::findOrFail($id);

        if(isset($cart[$dish->id])) {
            unset($cart[$dish->id]);
            Cache::put($cartKey, $cart, 60*24);
        }

        return redirect()->back();
    }
    //Очистить корзина
    public function clear(Request $request)
    {
        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');

        Cache::put($cartKey, [], 60*24);

        return redirect()->back()->with('success', 'Корзина очищена!');
    }

    public function addMultiple(Request $request)
    {
        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);

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

        Cache::put($cartKey, $cart, 60 * 24);

        return response()->noContent();
    }

    public function reorder(Request $request, Order $order): \Illuminate\Http\RedirectResponse
    {
        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);

        foreach ($order->items as $item) {
            $dish = $item->dish;
            if (!$dish) continue;

            $qty = (int) $item->quantity;

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

        Cache::put($cartKey, $cart, now()->addDays(7));

        return redirect()->route('cart.index')->with('success', 'Заказ повторен!');
    }

    /**
     * Получить текущее состояние корзины (для AJAX)
     */
    public function getCart(Request $request): \Illuminate\Http\JsonResponse
    {
        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);

        return response()->json([
            'cart' => $cart,
            'total_items' => array_sum(array_column($cart, 'quantity')),
            'total_price' => array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)),
        ]);
    }

    /**
     * AJAX добавление/обновление количества блюда
     */
    public function addAjax(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);

        $dish = Dish::findOrFail($id);
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (isset($cart[$dish->id])) {
            $cart[$dish->id]['quantity'] = $quantity;
        } else {
            $cart[$dish->id] = [
                'name' => $dish->name,
                'price' => $dish->price,
                'quantity' => $quantity,
            ];
        }

        Cache::put($cartKey, $cart, now()->addDays(7));

        return response()->json([
            'success' => true,
            'item' => $cart[$dish->id],
            'total_items' => array_sum(array_column($cart, 'quantity')),
            'total_price' => array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)),
        ]);
    }

    /**
     * Bulk add items from localStorage draft (AJAX, no redirect)
     */
    public function addBulk(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'items'   => ['required', 'array'],
            'items.*' => ['integer', 'min:0'],
        ]);

        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);

        foreach ($request->items as $dishId => $quantity) {
            $qty = (int) $quantity;

            if ($qty <= 0) {
                unset($cart[$dishId]);
                continue;
            }

            try {
                $dish = Dish::where('id', (int) $dishId)
                    ->where(function($q) { $q->where('is_active', true)->orWhereNull('is_active'); })
                    ->firstOrFail();
            } catch (\Throwable $e) {
                continue;
            }

            if (isset($cart[$dish->id])) {
                $cart[$dish->id]['quantity'] += $qty;
            } else {
                $cart[$dish->id] = [
                    'name'     => $dish->name,
                    'price'    => $dish->price,
                    'quantity' => $qty,
                ];
            }
        }

        Cache::put($cartKey, $cart, now()->addDays(7));

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success'    => true,
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Получить количество товаров в корзине (для бейджа в шапке)
     */
    public function count(Request $request): \Illuminate\Http\JsonResponse
    {
        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);

        return response()->json([
            'count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }
}
