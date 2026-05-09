<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(): \Illuminate\View\View
    {
        $today = now()->startOfDay();
        $weekAgo = now()->subDays(7)->startOfDay();

        // Метрики заказов
        $ordersToday = Order::whereDate('created_at', $today)->count();
        $ordersWeek = Order::where('created_at', '>=', $weekAgo)->count();

        // Выручка (только выполненные заказы)
        $revenueToday = Order::whereDate('created_at', $today)
            ->where('status', 'done')
            ->sum('total_price');
        $revenueWeek = Order::where('created_at', '>=', $weekAgo)
            ->where('status', 'done')
            ->sum('total_price');

        // Новые заказы
        $newOrdersCount = Order::where('status', 'new')->count();

        // Топ-5 блюд
        $topDishes = OrderItem::select('dish_id', DB::raw('SUM(quantity) as total_quantity'))
            ->with('dish')
            ->groupBy('dish_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $admins = User::where('is_admin', true)->get();

        return view('admin.dashboard', compact(
            'admins',
            'ordersToday',
            'ordersWeek',
            'revenueToday',
            'revenueWeek',
            'newOrdersCount',
            'topDishes'
        ));
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Нельзя удалить самого себя.');
        }

        $user->delete();

        return back()->with('success', 'Админ удалён.');
    }
}
