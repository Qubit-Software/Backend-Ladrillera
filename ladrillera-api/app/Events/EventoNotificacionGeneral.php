<?php

namespace App\Events;

use App\Models\Notificacion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventoNotificacionGeneral implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $titulo;
    public $body;
    public $router;
    public $alcance;
    public $prioridad;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($titulo, $body, $router, $alcance, $prioridad)
    {
        $this->titulo = $titulo;
        $this->router = $router;
        $this->body = $body;
        $this->alcance = $alcance;
        $this->prioridad = $prioridad;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notificaciones');
    }
}
