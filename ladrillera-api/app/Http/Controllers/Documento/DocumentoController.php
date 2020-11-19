<?php

namespace App\Http\Controllers\Documento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClienteModel;
use App\Models\DocumentoModel;
use App\Services\DocumentoService;

use Illiminate\Support\Str;

use App\Http\Schemas\Requests\DocumentoRequest;

class DocumentoController extends Controller
{
    protected $documento_service;
    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(DocumentoService $documento_service)
    {
        $this->documento_service = $documento_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->documento_service->get_all();
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
        $documentoRequest = new DocumentoRequest();
        $documentoRequest->validateRequest($request);

        $documentoRequest = DocumentoRequest::withData($request->id_cliente, $request->documento, $request->tipo_documento);
        $client  = ClienteModel::findOrFail($documentoRequest->get_id_cliente());
        
        $document = $this->documento_service->create_document($client, $documentoRequest);
        
        $jsonResponse = null;
        if(is_null($document)){
            $jsonResponse = response()->json(["msg"=>"Ocurrio un error en el servidor al guardar el documento "], 500);
        }else{
            $jsonResponse = response()->json(["documento"=>$document,"msg"=> "Documento creado correctamente"], 500);
        }

        return $jsonResponse;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function show(Documento $documento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit(Documento $documento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documento $documento)
    {
        //
    }
}
