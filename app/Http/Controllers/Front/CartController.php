<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    // Показать корзину
    public function index(Request $request)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);
        return view('front.cart.index', compact('cart'));
    }

    // Добавить блюдо в корзину
    public function add(Request $request, $id)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);

        $dish = Dish::findOrFail($id);

        if(isset($cart[$dish->id])) {
            $cart[$dish->id]['quantity']++;
        } else {
            $cart[$dish->id] = [
                'name' => $dish->name,
                'price' => $dish->price,
                'weight' => $dish->weight,
                'quantity' => 1,
                'photo' => $dish->photo_path
            ];
        }

        Cache::put("cart_$clientId", $cart, 60*24);
        return redirect()->back()->with('success', 'Добавлено в корзину!');
    }

    // Обновить количество
    public function update(Request $request, $id)
    {
        $clientId = $request->cookie('client_id');
        $cart = Cache::get("cart_$clientId", []);

        $dish = Dish::findOrFail($id);
        
        if(isset($cart[$dish->id])) {
            $cart[$dish->id]['quantity'] = $request->quantity;
            Cache::put("cart_$clientId", $cart, 60*24);
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
}
