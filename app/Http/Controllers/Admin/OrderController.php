<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dish;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AdminLogService;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\OrderStatusUpdated;

class OrderController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $query = Order::query();

        // Фильтр по статусу
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Поиск по имени, телефону или ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
                if (is_numeric($search)) {
                    $q->orWhere('id', $search);
                }
            });
        }

        // Фильтр по дате от
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // Фильтр по дате до
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->all());

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.dish');
        return view('admin.orders.detail', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,processing,done,cancelled'
        ]);

        $oldStatus = $order->getOriginal('status');
        $newStatus = $request->status;

        $order->status = $newStatus;
        $order->save();

        event(new \App\Events\OrderStatusUpdated($order, $oldStatus, $newStatus));

        return redirect()->route('admin.orders')->with('success', 'Статус заказа обновлен!');
    }


    public function export(Order $order)
    {
        return Excel::download(new OrderExport($order), 'order_' . $order->id . '.xlsx');
    }

    public function destroyAll()
    {
        Order::query()->delete();
        return redirect()->route('admin.orders')->with('success', 'Все заказы удалены.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Заказ удалён.');
    }
}
