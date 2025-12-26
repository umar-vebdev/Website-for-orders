<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('orders');
    }

    public function broadcastAs(): string
    {
        return 'OrderCreated';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->id,
            'name' => $this->order->name,
            'phone' => $this->order->phone,
            'total_price' => $this->order->total_price,
            'status' => $this->order->status,
        ];
    }
}
