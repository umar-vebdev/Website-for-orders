<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckoutController extends Controller
{
    public function showForm(Request $request)
    {
        $clientId = $request->cookie('client_id') ?? $request->cookies->get('client_id');

        if (!$clientId) {
             Log::error('Checkout failed: client_id is missing.');
             return redirect()->back()->with('error', 'Ошибка идентификации сессии. Пожалуйста, обновите страницу.');
        }
        $cartKey = 'cart_' . md5($clientId);
        $cart = Cache::get($cartKey, []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Ваша корзина пуста');
        }

        return view('front.orders.order_form', compact('cart'));
    }

    public function store(OrderRequest $request): \Illuminate\Http\RedirectResponse
    {
        $clientId = $request->cookie('client_id') ?? $request->cookies->get('client_id');

        if (!$clientId) {
            Log::error('Checkout store failed: client_id is missing.');
            return redirect()->back()->with('error', 'Ошибка сессии. Обновите страницу.');
        }

        $cartKey = 'cart_' . md5($clientId);
        $cart = Cache::get($cartKey, []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Корзина пуста');
        }

        try {
            $order = DB::transaction(function () use ($request, $clientId, $cart) {
                $total = 0;
                foreach ($cart as $item) {
                    $total += $item['price'] * $item['quantity'];
                }

                $order = Order::create([
                    'client_id'   => md5($clientId),
                    'name'        => $request->name,
                    'phone'       => $request->phone,
                    'address'     => $request->address,
                    'total_price' => $total,
                    'status'      => 'new',
                    'description' => $request->description,
                ]);

                foreach ($cart as $dishId => $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'dish_id'  => $dishId,
                        'quantity' => $item['quantity'],
                        'price'    => $item['price'],
                    ]);
                }

                return $order;
            });

            $cartKey = 'cart_' . md5($clientId);
            Cache::forget($cartKey);

            try {
                event(new \App\Events\OrderCreated($order));
            } catch (Throwable $eventException) {
                Log::warning('Order created, but broadcasting failed.', [
                    'order_id' => $order->id,
                    'message' => $eventException->getMessage(),
                ]);
            }

            return redirect()->route('order.thank-you', $order);
        } catch (Throwable $e) {
            Log::error('Order creation failed.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Ошибка при сохранении заказа.');
        }
    }

    /**
     * Страница "Спасибо за заказ"
     */
    public function thankYou(Request $request, Order $order): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        $clientId = $request->cookie('client_id') ?? $request->cookies->get('client_id');

        // Защита: только владелец заказа может видеть страницу
        if ($order->client_id !== md5($clientId)) {
            abort(403);
        }

        $order->load('items.dish');

        return view('front.orders.thank-you', compact('order'));
    }
}
