<?php

namespace App\Services;

use App\Http\Schemas\Requests\DocumentoRequest;
use App\Http\Schemas\Requests\ProductoPedidoRequest;
use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;
use App\Models\PedidoModel;
use App\Models\ProductoPedidoModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductoPedidoService
{

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct()
    {
    }

    public function getAll()
    {
        $documents = DocumentoModel::all();
        return response()->json($documents, 200);
    }

    public function createProductoPedido(ProductoPedidoRequest $productoPedidoRequest, PedidoModel $pedidoModel)
    {
        $data = [
            'id_pedido' => $pedidoModel->id,
            'cantidad' => $productoPedidoRequest->getCantidad(),
            'codigo_producto' => $productoPedidoRequest->getCodigoProducto(),
            'valor_total' => $productoPedidoRequest->getValorTotal(),
            'unidad_medicion' => $productoPedidoRequest->getUnidadMedicion()
        ];
        $new_producto_pedido = new ProductoPedidoModel($data);
        $new_producto_pedido->save();

        return $new_producto_pedido;
    }
}
