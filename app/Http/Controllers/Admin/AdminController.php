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
    public function dashboard(Request $request): \Illuminate\View\View
    {
        $period = $request->string('period')->toString();
        $period = in_array($period, ['today', '7d', '30d', 'all'], true) ? $period : '7d';

        $periodStart = match ($period) {
            'today' => now()->startOfDay(),
            '30d' => now()->subDays(30)->startOfDay(),
            'all' => null,
            default => now()->subDays(7)->startOfDay(),
        };

        $periodLabel = match ($period) {
            'today' => 'сегодня',
            '30d' => 'за 30 дней',
            'all' => 'за всё время',
            default => 'за 7 дней',
        };

        $show = $request->input('show', ['total_orders', 'period_orders', 'period_revenue', 'new_orders']);
        $show = is_array($show) ? $show : [];

        $visiblePanels = [
            'total_orders' => in_array('total_orders', $show, true),
            'period_orders' => in_array('period_orders', $show, true),
            'period_revenue' => in_array('period_revenue', $show, true),
            'new_orders' => in_array('new_orders', $show, true),
        ];

        $ordersTotal = Order::count();
        $ordersInPeriod = $periodStart
            ? Order::where('created_at', '>=', $periodStart)->count()
            : $ordersTotal;

        $revenueInPeriod = $periodStart
            ? Order::where('created_at', '>=', $periodStart)->where('status', 'done')->sum('total_price')
            : Order::where('status', 'done')->sum('total_price');

        $newOrdersCount = Order::where('status', 'new')->count();

        $topDishes = OrderItem::select('dish_id', DB::raw('SUM(quantity) as total_quantity'))
            ->with('dish')
            ->groupBy('dish_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $admins = User::where('is_admin', true)->get();

        return view('admin.dashboard', compact(
            'admins',
            'ordersTotal',
            'ordersInPeriod',
            'revenueInPeriod',
            'newOrdersCount',
            'topDishes',
            'period',
            'periodLabel',
            'visiblePanels'
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
