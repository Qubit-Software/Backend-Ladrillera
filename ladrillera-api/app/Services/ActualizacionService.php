<?php

namespace App\Services;

use App\Http\Schemas\Requests\ActualizacionRequest;
use App\Models\ActualizacionModel;

class ActualizacionService
{

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct()
    {
    }


    public function getAll()
    {
        return ActualizacionModel::all();
    }

    public function getById($id)
    {
        return ActualizacionModel::findOrFail($id);
    }

    public function createActualizacion(ActualizacionRequest $actualizacionRequest)
    {
        $date = date_create_from_format('j/n/Y', $actualizacionRequest->getFecha());

        $data = [
            "titulo" => $actualizacionRequest->getTitulo(),
            "descripcion" => $actualizacionRequest->getDescripcion(),
            "fecha" => $date,
        ];
        $actualizacion = new ActualizacionModel($data);
        $actualizacion->save();
        return $actualizacion;
    }

    public function updateActualizacion(ActualizacionModel $actualizacion, ActualizacionRequest $actualizacionRequest)
    {
        $date = date_create_from_format('j/n/Y', $actualizacionRequest->getFecha());

        $data = [
            "titulo" => $actualizacionRequest->getTitulo(),
            "descripcion" => $actualizacionRequest->getDescripcion(),
            "fecha" => $date,
        ];
        $actualizacion->update($data);
        $actualizacion->save();
        return $actualizacion;
    }

    public function delete(ActualizacionModel $actualizacionModel)
    {
        $actualizacionModel->delete();
    }
}
