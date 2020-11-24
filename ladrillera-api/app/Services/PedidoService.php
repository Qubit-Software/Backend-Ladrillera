<?php

namespace App\Services;

use App\Http\Schemas\Requests\PedidoRequest;
use App\Models\PedidoModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PedidoService
{

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct()
    {
    }


    public function getAll()
    {
        return PedidoModel::all();
    }

    public function createPedido(PedidoRequest $pedidoRequest)
    {
        $time = strtotime($pedidoRequest->getFechaCargue());
        $fecha_cargue = date('Y-m-d', $time);

        $default_status = Config::get('constants.default.estatus');
        $status = (is_null($pedidoRequest->getEstatus()) ? $default_status : $pedidoRequest->getEstatus());
        $data = [
            "id_cliente" => $pedidoRequest->getIdCliente(),
            "fecha_cargue" => $fecha_cargue,
            "total" => $pedidoRequest->getTotal(),
            "estatus" => $status
        ];
        $new_pedido = new PedidoModel($data);
        $new_pedido->save();
        return $new_pedido;
    }
}
