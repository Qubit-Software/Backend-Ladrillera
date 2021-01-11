<?php

namespace App\Services;

use App\Events\EventoNotificacionGeneral;
use App\Http\Schemas\Requests\NotificacionRequest;
use App\Models\ActualizacionModel;
use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;
use App\Models\NotificacionModel;

class NotificacionService
{

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct()
    {
    }

    public function create(NotificacionRequest $notificacion_request)
    {
        $data = [
            "titulo" => $notificacion_request->getTitulo(),
            "body" => $notificacion_request->getBody(),
            "router" => $notificacion_request->getRouter(),
            "alcance" => $notificacion_request->getAlcance(),
            "prioridad" => $notificacion_request->getPrioridad(),
        ];
        $notificacion = new NotificacionModel($data);
        $notificacion->save();
        return $notificacion;
    }
}
