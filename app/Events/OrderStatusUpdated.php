<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Создаем экземпляр события.
     */
    public function __construct(public $order,
                                public $oldStatus,
                                public $newStatus)
    {}

    /**
     * Канал, на который отправляем данные.
     * Делаем его публичным (Channel), чтобы не настраивать auth.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('order.' . $this->order->id);
    }

    /**
     * Имя события в JavaScript.
     */
    public function broadcastAs(): string
    {
        return 'StatusUpdated';
    }

    /**
     * Данные, которые улетят в WebSocket.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->id,
            'status' => $this->order->status,
            'status_label' => Order::getStatuses()[$this->order->status] ?? $this->order->status,
        ];
    }
}
