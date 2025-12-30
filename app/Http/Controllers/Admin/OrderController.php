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
    public function index() 
    {
        $orders = Order::orderBy('id', 'desc')->get();

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

        $order->status = $request->status;
        $order->save();

        event(new OrderStatusUpdated($order));

        return redirect()->route('admin.orders')->with('success', 'Статус заказа обновлен!');
    }

    public function export(Order $order)
    {
        return Excel::download(new OrderExport($order), 'order_'.$order->id.'.xlsx');
    }

}
