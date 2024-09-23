<?php
namespace App\Events;

use App\Models\Gastos;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class GastosAgregado implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $gasto;

    public function __construct(Gastos $gasto)
    {
        $this->gasto = $gasto;
    }

    // Nombre del canal donde se emitirá el evento
    public function broadcastOn()
    {
        return new Channel('gastos-channel');
        //return ['ventas-channel'];

    }

    /*public function broadcastAs()
    {
        return 'venta.creada';
    }*/
}
