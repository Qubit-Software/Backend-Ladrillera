<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Schemas\Requests\ClienteRequest;
use App\Models\ClienteModel;
use App\Models\EmpleadoModel;
use App\Services\ClienteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    private $cliente_service;
    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(ClienteService $cliente_service)
    {
        $this->cliente_service = $cliente_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->cliente_service->getAll();
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
            $cliente_request = new ClienteRequest();
            $cliente_request->validateCreateRequest($request);
            $cliente_request = ClienteRequest::from_request($request);


            $empleado = NULL;
            $empleado_id = $cliente_request->getIdEmpleado();
            if (!is_null($empleado_id)) {
                $empleado = EmpleadoModel::findOrFail($empleado_id);
            }

            $new_client = $this->cliente_service->createCliente($cliente_request, $empleado);
            DB::commit();
            return $new_client;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByCCNit(Request $request)
    {
        $identifier_kind = $request->query('unique_column', 'id');
        $cliente = $this->cliente_service->getByUniqueColumn($identifier_kind, $request->cc_nit);
        return response()->json($cliente, 200);
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
            $client_to_update = ClienteModel::findOrFail($id);

            $cliente_request = new ClienteRequest();
            $cliente_request->validateUpdateRequest($request, $client_to_update->id);
            $cliente_request = ClienteRequest::from_request($request);


            $empleado = NULL;
            $empleado_id = $cliente_request->getIdEmpleado();
            if (!is_null($empleado_id)) {
                $empleado = EmpleadoModel::findOrFail($empleado_id);
            }

            $new_client = $this->cliente_service->updateCliente(
                $client_to_update,
                $cliente_request,
                $empleado
            );
            DB::commit();
            return $new_client;
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
        //
    }
}
