<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dish;

class OrderController extends Controller
{
    public function index() 
    {
        $orders = Order::all()
        ->orderBy('id', 'desc')
        ->get();

        return view('admin.orders.index', compact('$orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.dish');
        return view('admin.orders.detail', compact('$order'));
    }

    public function updateStatus(Request $request, Order $order, $id)
    {
        $request->validate([
            'status' => 'required|in:new,processing,completed,canceled'
        ]);

        $order = Order::findOrFail($id);  
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Статус заказа обновлен!');
    }
}
