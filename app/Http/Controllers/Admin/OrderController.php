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
    public function index(Request $request)
{
    // Создаем базовый запрос к модели Order
    $query = \App\Models\Order::query();

    // Если в ссылке передан статус (например, ?status=new), фильтруем
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Получаем заказы, сортируя их: сначала новые/последние
    // Используем paginate, если заказов будет много (например, по 20 на страницу)
    $orders = $query->orderBy('created_at', 'desc')->get();

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
        return Excel::download(new OrderExport($order), 'order_'.$order->id.'.xlsx');
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
