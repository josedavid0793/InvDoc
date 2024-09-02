<?php
namespace App\Events;

use App\Models\Producto;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ProductoAgregado implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $producto;

    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function broadcastOn()
    {
        return new Channel('productos');
    }
}
