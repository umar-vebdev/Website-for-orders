<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dish;

class MenuController extends Controller
{
    public function dishes() {
        $dishes = Dish::all();
        return view('front.menu.index', compact('dishes'));
    }
}
