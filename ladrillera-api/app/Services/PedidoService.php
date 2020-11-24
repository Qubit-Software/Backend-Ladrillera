<?php

namespace App\Services;

use App\Http\Schemas\Requests\PedidoRequest;
use App\Models\PedidoModel;
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
        $data = [
            "id_cliente" => $pedidoRequest->getIdCliente(),
            "fecha_cargue" => $pedidoRequest->getFechaCargue(),
            "total" => $pedidoRequest->getTotal(),
            "estatus" => $pedidoRequest->getEstatus()
        ];
        $new_pedido = new PedidoModel($data);
        $new_pedido->save();
        return $new_pedido;
    }
}
