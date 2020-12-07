<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use App\Http\Schemas\Requests\PedidoRequest;
use App\Http\Schemas\Requests\ProductoPedidoRequest;
use App\Models\PedidoModel;
use App\Services\PedidoService;
use App\Services\ProductoPedidoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    private $productos_pedido_service;
    private $pedido_service;

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(
        PedidoService $pedido_service,
        ProductoPedidoService $productos_pedido_service
    ) {
        $this->pedido_service = $pedido_service;
        $this->productos_pedido_service = $productos_pedido_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->pedido_service->getAll();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pedido_request = new PedidoRequest();
            $pedido_request->validateCreateRequest($request->all());
            $pedido_request = PedidoRequest::fromRequest($request);
            $productos = $pedido_request->getProductos();

            $productos_pedido_request = new ProductoPedidoRequest();
            $productos_pedido_request->validateCreate($productos);

            $producto_pedido_requests = [];
            foreach ($productos as $indx => $producto) {
                $producto_pedido_request = ProductoPedidoRequest::fromProductoRequest(
                    $producto["codigo_producto"],
                    $producto["unidad_medicion"],
                    $producto["cantidad"],
                    $producto["valor_total"],
                    $producto["iva"],
                    $producto["comentarios"],
                );
                array_push($producto_pedido_requests, $producto_pedido_request);
            }

            $new_pedido = $this->pedido_service->createPedido($pedido_request);
            $new_producto_pedidos = [];
            foreach ($producto_pedido_requests as $indx => $producto_request) {
                $new_producto_pedido = $this->productos_pedido_service->createProductoPedido($producto_request, $new_pedido);
                array_push($new_producto_pedidos, $new_producto_pedido);
            }

            DB::commit();
            return response()->json([
                "pedido" => $new_pedido,
                "productos_pedido" => $new_producto_pedidos
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = $this->pedido_service->getById($id);
        return response()->json($pedido, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $update_pedido_request = new PedidoRequest();
            $update_pedido_request->validateUpdateRequest($request->all());

            $update_pedido_request = $update_pedido_request->fromUpdateRequest($request);

            $pedido_to_update = PedidoModel::findOrFail($id);

            $status_key = intval($update_pedido_request->getEstatus());
            $status_value = Config::get('constants.estatus', 'error')[$status_key];

            $updated = $this->pedido_service->updatePedidoStatus(
                $pedido_to_update,
                $status_value
            );

            DB::commit();

            return response()->json($updated, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedido = PedidoModel::findOrFail($id);
        $this->pedido_service->delete($pedido);
    }
}
