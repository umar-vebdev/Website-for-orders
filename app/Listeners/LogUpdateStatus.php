<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Log;

class LogUpdateStatus
{
    public function handle(OrderStatusUpdated $event): void
    {
        Log::info("Статус заказа #{$event->order->id}: {$event->oldStatus} → {$event->newStatus}");
    }
}
    