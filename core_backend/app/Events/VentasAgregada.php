<?php
namespace App\Events;

use App\Models\Ventas;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class VentasAgregada implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $venta;

    public function __construct(Ventas $venta)
    {
        $this->venta = $venta;
    }

    // Nombre del canal donde se emitirá el evento
    public function broadcastOn()
    {
        return new Channel('ventas-channel');
        //return ['ventas-channel'];

    }

    /*public function broadcastAs()
    {
        return 'venta.creada';
    }*/
}
