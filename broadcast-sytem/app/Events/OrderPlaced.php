<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('items');
    }

    public function broadcastOn(): array
    {
        return [
            // new PrivateChannel('admin.orders'),
             new Channel('admin.orders'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'OrderPlaced';
    }

    public function broadcastWith(): array
    {
        return [
            'id'             => $this->order->id,
            'customer_name'  => $this->order->customer_name,
            'total_amount'   => $this->order->total_amount,
            'status'         => $this->order->status,
            'items'          => $this->order->items,
            'created_at'     => $this->order->created_at->format('d M Y, h:i A'),
        ];
    }
}
