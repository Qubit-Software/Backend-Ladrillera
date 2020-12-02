<?php

namespace App\Services;

use App\Http\Schemas\Requests\ClienteRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;
use App\Models\EmpleadoModel;

use App\Services\UsuarioService;
use App\Services\UserService;

use App\Http\Schemas\Requests\EmpleadoRequest;
use App\Http\Schemas\Requests\SolicitudClienteRequest;
use App\Models\SolicitudClienteModel;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class SolicitudClienteService
{


    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct()
    {
    }


    public function getAll($creado_flag)
    {
        return SolicitudClienteModel::where("creado", $creado_flag)->get();
    }

    public function getByUniqueColumn($column_name, $column_value)
    {
        return SolicitudClienteModel::where($column_name, $column_value)->firstOrFail();
    }

    public function createSolicitudCliente(SolicitudClienteRequest $solicitud_clienteRequest)
    {
        $data_cliente = [
            "nombre" => $solicitud_clienteRequest->getNombre(),
            "telefono" => $solicitud_clienteRequest->getTelefono(),
            "creado" => is_null($solicitud_clienteRequest->getCreado()) ? 0 : 1,
        ];

        $solicitud_cliente = new SolicitudClienteModel($data_cliente);

        $solicitud_cliente->save();
        return $solicitud_cliente;
    }

    public function updateSolicitudCliente(SolicitudClienteModel $solicitud_cliente, SolicitudClienteRequest $solicitud_clienteRequest)
    {
        $data_cliente = [
            "nombre" => $solicitud_clienteRequest->getNombre(),
            "telefono" => $solicitud_clienteRequest->getTelefono(),
            "creado" => $solicitud_clienteRequest->getCreado(),
        ];

        $solicitud_cliente->update($data_cliente);

        $solicitud_cliente->save();
        return $solicitud_cliente;
    }
}
