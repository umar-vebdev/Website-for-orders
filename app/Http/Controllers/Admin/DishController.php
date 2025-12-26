<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Dish;
use App\Services\AdminLogService;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DishController extends Controller
{
    // Список блюд
    public function index()
    {
        $dishes = Dish::all();
        return view('admin.dishes.index', compact('dishes'));
    }

    // Форма создания
    public function create()
    {
        return view('admin.dishes.form');
    }

    // Сохранение нового блюда
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'photo_path' => 'nullable|image',
        ]);

        $path = $request->hasFile('photo_path')
            ? $request->file('photo_path')->store('dishes', 'public')
            : null;

        $dish = Dish::create([
            'name' => $request->name,
            'price' => $request->price,
            'weight' => $request->weight,
            'photo_path' => $path,
        ]);

        AdminLog::create([
            'admin_id' => Auth::id(),
            'admin_name' => Auth::user()->name,
            'action' => 'Добавил блюдо',
            'description' => "{$dish->name} (id: {$dish->id})",
        ]);

        return redirect()->route('admin.dishes')->with('success', 'Блюдо добавлено!');
    }

    // Форма редактирования
    public function edit($id)
    {
        $dish = Dish::findOrFail($id);
        return view('admin.dishes.form', compact('dish'));
    }

    // Обновление блюда
    public function update(Request $request, $id)
    {
        $dish = Dish::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'photo_path' => 'nullable|image',
        ]);

        $path = $dish->photo_path;

        if ($request->hasFile('photo_path')) {
            if ($dish->photo_path) {
                Storage::disk('public')->delete($dish->photo_path);
            }
            $path = $request->file('photo_path')->store('dishes', 'public');
        }

        $dish->update([
            'name' => $request->name,
            'price' => $request->price,
            'weight' => $request->weight,
            'photo_path' => $path,
        ]);

        AdminLog::create([
            'admin_id' => Auth::id(),
            'admin_name' => Auth::user()->name,
            'action' => 'Обновил блюдо',
            'description' => "{$dish->name} (id: {$dish->id})",
        ]);

        return redirect()->route('admin.dishes')->with('success', 'Блюдо обновлено!');
    }

    // Удаление блюда
    public function destroy($id)
    {
        $dish = Dish::findOrFail($id);
        if ($dish->photo_path) {
            Storage::disk('public')->delete($dish->photo_path);
        }
        $dish->delete();

        AdminLog::create([
            'admin_id' => Auth::id(),
            'admin_name' => Auth::user()->name,
            'action' => 'Удалил блюдо',
            'description' => "{$dish->name} (id: {$dish->id})",
        ]);

        return redirect()->route('admin.dishes')->with('success', 'Блюдо удалено!');
    }
}
