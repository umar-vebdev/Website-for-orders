<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dish;

class MenuController extends Controller
{
    public function dishes(Request $request)
{
    $query = \App\Models\Dish::query();

    // Фильтрация по категории, если она выбрана
    if ($request->has('category')) {
        $query->where('category', $request->category);
    }

    // Получаем блюда с пагинацией
    $dishes = $query->orderBy('id', 'asc')->paginate(10); 

    return view('front.menu.index', compact('dishes'));
}
}
