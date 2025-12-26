<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Support\Facades\Log;

class LogCreatedOrder
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        // $event->order теперь содержит весь объект заказа
        Log::info('Создан заказ: ' . $event->order->id);
    }
}
