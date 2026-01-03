<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    // Список заказов
    public function index(Request $request)
    {
        $clientId = $request->cookie('client_id');

        $orders = Order::where('client_id', $clientId)
                        ->orderBy('id', 'desc')
                        ->get();
        
        return view('front.orders.my_orders', compact('orders'));
    }

    // Детали заказа
    public function show(Request $request, Order $order)
    {
        $clientId = $request->cookie('client_id');

        if($order->client_id !== $clientId) {
            abort(403);
        }

        $order->load('items.dish');

        return view('front.orders.order_detail', compact('order'));
    }

    public function clear(Request $request)
{
    $clientId = $request->cookie('client_id');

    \App\Models\Order::where('client_id', $clientId)->each(function($order) {
        $order->items()->delete();
        $order->delete();
    });

    return redirect()->route('my.orders')->with('success', 'Все заказы удалены.');
}
}