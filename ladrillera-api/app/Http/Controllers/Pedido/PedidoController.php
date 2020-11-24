<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use App\Http\Schemas\Requests\PedidoRequest;
use App\Http\Schemas\Requests\ProductoPedidoRequest;
use App\Services\ProductoPedidoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    private $productos_pedido_service;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductoPedidoService $productos_pedido_service)
    {
        $this->productos_pedido_service = $productos_pedido_service;
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
            $productos_pedido_request = ProductoPedidoRequest::from_request($request);

            DB::commit();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
