<?php

namespace App\Services;

use App\Events\EventoNotificacionGeneral;
use App\Models\ActualizacionModel;
use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;
use App\Models\NotificacionModel;

class EventService
{

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct()
    {
    }

    public function createEventoParaActualizacion(ActualizacionModel $actualizacion)
    {
        $evento = new EventoNotificacionGeneral($actualizacion->titulo, $actualizacion->descripcion, "/actualizaciones", "Bajo", "Baja");
        event($evento);
    }

    public function createEventoFromNotificacion(NotificacionModel $notificacion)
    {
        $evento = new EventoNotificacionGeneral(
            $notificacion->titulo,
            $notificacion->body,
            $notificacion->router,
            $notificacion->alcance,
            $notificacion->prioridad
        );
        event($evento);
    }
}
