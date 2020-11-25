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
        return PedidoModel::with('productos')->get();
    }

    public function getById($id)
    {
        return PedidoModel::with('productos')->findOrFail($id);
    }

    public function createPedido(PedidoRequest $pedidoRequest)
    {
        $date = date_create_from_format('d/m/Y', $pedidoRequest->getFechaCargue());

        $default_status = Config::get('constants.default.estatus');
        $status = (is_null($pedidoRequest->getEstatus()) ? $default_status : $pedidoRequest->getEstatus());
        $data = [
            "id_cliente" => $pedidoRequest->getIdCliente(),
            "fecha_cargue" => $date,
            "total" => $pedidoRequest->getTotal(),
            "estatus" => $status
        ];
        $new_pedido = new PedidoModel($data);
        $new_pedido->save();
        return $new_pedido;
    }

    public function updatePedidoStatus(PedidoModel $to_update, $estatus)
    {
        $to_update->estatus = $estatus;
        $to_update->save();
        return $to_update;
    }
}
