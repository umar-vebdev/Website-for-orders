<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dish;

class DishController extends Controller
{
    // Список всех блюд
    public function index()
    {
        $dishes = Dish::all();
        return view('admin.dishes.index', compact('dishes'));
    }

    // Форма добавления нового блюда
    public function create()
    {
        return view('admin.dishes.create');
    }

    // Сохранение нового блюда
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'photo_path' => 'nullable|image'
        ]);

        $path = $request->file('photo_path') ? $request->file('photo_path')->store('dishes', 'public') : null;

        Dish::create([
            'name' => $request->name,
            'price' => $request->price,
            'weight' => $request->weight,
            'photo_path' => $path
        ]);

        return redirect()->route('admin.dishes')->with('success', 'Блюдо добавлено!');
    }

    // Форма редактирования
    public function edit(Dish $dish)
    {
        return view('admin.dishes.edit', compact('dish'));
    }

    // Обновление блюда
    public function update(Request $request, Dish $dish)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'photo_path' => 'nullable|image'
        ]);

        $path = $request->file('photo_path') ? $request->file('photo_path')->store('dishes', 'public') : $dish->photo_path;

        $dish->update([
            'name' => $request->name,
            'price' => $request->price,
            'weight' => $request->weight,
            'photo_path' => $path
        ]);

        return redirect()->route('admin.dishes')->with('success', 'Блюдо обновлено!');
    }

    // Удаление блюда
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return redirect()->route('admin.dishes')->with('success', 'Блюдо удалено!');
    }
}
