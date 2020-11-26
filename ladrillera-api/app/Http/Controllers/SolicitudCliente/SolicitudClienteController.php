<?php

namespace App\Http\Controllers\SolicitudCliente;

use App\Http\Controllers\Controller;
use App\Http\Schemas\Requests\SolicitudClienteRequest;
use App\Models\SolicitudClienteModel;
use App\Services\SolicitudClienteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudClienteController extends Controller
{
    private $solicitud_cliente_service;

    public function __construct(SolicitudClienteService $solicitud_cliente_service)
    {
        $this->solicitud_cliente_service = $solicitud_cliente_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->solicitud_cliente_service->getAll();
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
        //
        DB::beginTransaction();
        try {
            $solicitud_cliente_request = new SolicitudClienteRequest();
            $solicitud_cliente_request->validateCreate($request->all());

            $solicitud_cliente_request = SolicitudClienteRequest::from_request($request);
            $solicitud_cliente = $this->solicitud_cliente_service->createSolicitudCliente($solicitud_cliente_request);

            DB::commit();
            return response()->json([$solicitud_cliente], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SolicitudClienteModel  $solicitudClienteModel
     * @return \Illuminate\Http\Response
     */
    public function show(SolicitudClienteModel $solicitudClienteModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SolicitudClienteModel  $solicitudClienteModel
     * @return \Illuminate\Http\Response
     */
    public function edit(SolicitudClienteModel $solicitudClienteModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SolicitudClienteModel  $solicitudClienteModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SolicitudClienteModel $solicitudClienteModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SolicitudClienteModel  $solicitudClienteModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(SolicitudClienteModel $solicitudClienteModel)
    {
        //
    }
}
