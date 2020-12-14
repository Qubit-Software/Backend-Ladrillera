<?php

namespace App\Http\Controllers;

use App\Http\Schemas\Requests\DespachoFotografiaRequest;
use App\Models\DespachoFotografiaModel;
use App\Models\PedidoModel;
use App\Services\DespachoFotografiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DespachoFotografiaController extends Controller
{
    private $despacho_foto_service;


    public function __construct(DespachoFotografiaService $despacho_foto_service)
    {
        $this->despacho_foto_service = $despacho_foto_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $despacho_fotos = $this->despacho_foto_service->getAll();

        return response()->json($despacho_fotos, 200);
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
            $despacho_foto_req = new DespachoFotografiaRequest();
            $despacho_foto_req->validateCreate($request->all());
            $despacho_foto_req = $despacho_foto_req->getFromRequest($request);

            $pedido = PedidoModel::findOrFail($despacho_foto_req->getIdPedido());
            $despacho_foto = $this->despacho_foto_service->createDespachoFotofrafia($despacho_foto_req, $pedido);
            DB::commit();
            return response()->json($despacho_foto, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DespachoFotografiaModel  $despachoFotografiaModel
     * @return \Illuminate\Http\Response
     */
    public function show(DespachoFotografiaModel $despachoFotografiaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DespachoFotografiaModel  $despachoFotografiaModel
     * @return \Illuminate\Http\Response
     */
    public function edit(DespachoFotografiaModel $despachoFotografiaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DespachoFotografiaModel  $despachoFotografiaModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DespachoFotografiaModel $despachoFotografiaModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DespachoFotografiaModel  $despachoFotografiaModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(DespachoFotografiaModel $despachoFotografiaModel)
    {
        //
    }
}
