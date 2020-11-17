<?php

namespace App\Http\Controllers\Documento;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;
use App\Models\ClienteModel;
use App\Models\DocumentoModel;
use App\Services\DocumentoService;

use Illiminate\Support\Str;

use App\Http\Schemas\Requests\DocumentoRequest;
use App\Http\Schemas\Responses\ResponseBody;

class DocumentoController extends Controller
{
    protected $filesService;
    protected $documentoService;
    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(DocumentoService $documentoService)
    {
        $this->documentoService = $documentoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = DocumentoModel::all();
        return response()->json($documents, 200);
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
        
        $document = $this->documentoService->createDocument($client, $documentoRequest);
        if(is_null($document)){
            $responseBody = new ResponseBody(null, "Ocurrio un error en el servidor", 500);
            return response()->json($responseBody->getJsonArray(), $responseBody->get_status_code());
        }

        $responseBody = new ResponseBody($document, "Documento creado correctamente", 200);
        return response()->json($responseBody->getJsonArray(), $responseBody->get_status_code());
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
