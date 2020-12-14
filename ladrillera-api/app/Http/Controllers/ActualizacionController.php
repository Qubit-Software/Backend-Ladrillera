<?php

namespace App\Http\Controllers;

use App\Http\Schemas\Requests\ActualizacionRequest;
use App\Models\ActualizacionModel;
use App\Services\ActualizacionService;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActualizacionController extends Controller
{
    private $actualizacion_service;
    private $notificacion_service;

    /**
     * Instantiate a new ActualizacionController instance.
     */
    public function __construct(
        ActualizacionService $actualizacion_service,
        EventService $notificacion_service
    ) {
        $this->actualizacion_service = $actualizacion_service;
        $this->notificacion_service = $notificacion_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actualizaciones = $this->actualizacion_service->getAll();
        return response()->json($actualizaciones, 200);
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
            $actualizacion_request = new ActualizacionRequest();
            $actualizacion_request->validateCreateRequest($request);

            $actualizacion_request = ActualizacionRequest::fromRequest($request);

            $actualizacion = $this->actualizacion_service->createActualizacion($actualizacion_request);
            $this->notificacion_service->createEventoParaActualizacion($actualizacion);
            DB::commit();
            return response()->json($actualizacion, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActualizacionModel  $actualizacione
     * @return \Illuminate\Http\Response
     */
    public function show(ActualizacionModel $actualizacione)
    {
        return response()->json($actualizacione, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActualizacionModel  $actualizacionModel
     * @return \Illuminate\Http\Response
     */
    public function edit(ActualizacionModel $actualizacionModel, Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActualizacionModel  $actualizacione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActualizacionModel $actualizacione)
    {
        DB::beginTransaction();
        try {
            $actualizacion_request = new ActualizacionRequest();
            $actualizacion_request->validateCreateRequest($request);

            $actualizacion_request = ActualizacionRequest::fromRequest($request);

            $actualizacion = $this->actualizacion_service
                ->updateActualizacion($actualizacione, $actualizacion_request);
            $this->notificacion_service->createEventoParaActualizacion($actualizacion);
            DB::commit();
            return response()->json($actualizacion, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActualizacionModel  $actualizacionModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActualizacionModel $actualizacionModel)
    {
        //
    }
}
