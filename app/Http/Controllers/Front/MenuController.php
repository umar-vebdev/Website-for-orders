<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dish;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function dishes(Request $request): \Illuminate\View\View
    {
        $query = Dish::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $dishes = $query->orderBy('id', 'asc')->paginate(10);

        // Получаем корзину для восстановления счетчиков
        $clientId = $request->cookie('client_id');
        $cartKey = 'cart_' . md5($clientId ?? 'guest');
        $cart = Cache::get($cartKey, []);

        $categories = Dish::distinct()->pluck('category')->filter()->values();
        $currentCategory = $request->query('category');

        return view('front.menu.index', compact('dishes', 'cart', 'categories', 'currentCategory'));
    }
}
