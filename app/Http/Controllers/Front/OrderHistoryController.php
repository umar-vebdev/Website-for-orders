<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderHistoryController extends Controller
{
    // Список заказов
    public function index(Request $request)
    {
        $clientId = $request->cookie('client_id');

        $orders = Order::where('client_id', $clientId)
                        ->orderBy('id', 'desc')
                        ->get();

        return view('front.my_orders_list', compact('orders'));
    }

    // Детали заказа
    public function show(Request $request, Order $order)
    {
        $clientId = $request->cookie('client_id');

        // Проверяем, что заказ принадлежит текущему пользователю
        if($order->client_id !== $clientId) {
            abort(403);
        }

        $order->load('items.dish');

        return view('front.my_orders_show', compact('order'));
    }
}