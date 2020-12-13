<?php

namespace App\Http\Controllers\Documento;

use App\Http\Controllers\Controller;
use App\Http\Schemas\Requests\DescargaDocumentoRequest;
use Illuminate\Http\Request;
use App\Models\ClienteModel;
use App\Services\DocumentoService;


use App\Http\Schemas\Requests\DocumentoRequest;
use App\Http\Schemas\Requests\DocumentoRequestType;
use App\Models\DocumentoModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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
        return $this->documento_service->getAll();
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
            $documentoRequest = new DocumentoRequest();
            $documentoRequest->validateRequest($request);

            $documentoRequest = DocumentoRequest::withData($request->id_cliente, $request->documento, $request->tipo_documento);
            $client  = ClienteModel::findOrFail($documentoRequest->getIdCliente());

            $document = $this->documento_service->createDocument($client, $documentoRequest);

            $jsonResponse = null;
            if (is_null($document)) {
                $jsonResponse = response()->json(["msg" => "Ocurrio un error en el servidor al guardar el documento "], 500);
            } else {
                $jsonResponse = response()->json(["documento" => $document, "msg" => "Documento creado correctamente"], 200);
            }

            DB::commit();
            return $jsonResponse;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Display the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DocumentoModel $documento)
    {
        $type = strtoupper($request->query("type", DocumentoRequestType::INFO));
        $resp_documento = null;
        switch ($type) {
            case DocumentoRequestType::INFO:
                $resp_documento = $documento;
                break;
            case DocumentoRequestType::DOWNLOAD:
                $file_path = $this->documento_service->getClientDocumentPath($documento->file_path);
                $resp_documento = Storage::disk('s3')->download($file_path);
                break;
            case DocumentoRequestType::LINK:
                $temp_url = $this->documento_service->getClientDocumentTempUrl($documento->file_path);
                $resp_documento = response()->json(["temp_url" => $temp_url], 200);
                break;
            case DocumentoRequestType::DISPLAY:
                // Or redirect https://laracasts.com/discuss/channels/laravel/file-response-from-s3
                $file_path = $this->documento_service->getClientDocumentPath($documento->file_path);
                $file =  Storage::disk('s3')->get($file_path);
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Description' => 'File Transfer',
                    'Content-Disposition' => "attachment; filename={$documento->nombre}",
                    'filename' => $documento->nombre
                ];
                $resp_documento = response()->make($file, 200, $headers);
                break;
            default:
                $resp_documento = $documento;
                break;
        }
        return $resp_documento;
    }

    /**
     * Display the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showForClient(Request $request, ClienteModel $cliente)
    {
        $documentos = DocumentoModel::where('id_cliente', $cliente->id)->get();
        return response()->json($documentos, 200);
    }

    /**
     * Downlaods a zip that contains the files for the client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showForClientInZip(Request $request, ClienteModel $cliente)
    {
        $documentos = DocumentoModel::where('id_cliente', $cliente->id)->get();
        $zip = new ZipArchive;
        $fileName = $cliente->cc_nit . '.zip';
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            foreach ($documentos as $key => $documento) {
                $file_to_add_path = $this->documento_service->getClientDocumentPath($documento->file_path);
                $relativeNameInZipFile = basename($documento->nombre);
                $zip->addFile($file_to_add_path, $relativeNameInZipFile);
            }
            $zip->close();
        }
        $headers = array('Content-Type: application/zip', 'Content-Length: ' . filesize($fileName));
        ob_end_clean();
        return response()->download(public_path($fileName), $fileName, $headers);
        // return response()->download(public_path($fileName), $fileName, $headers)->deleteFileAfterSend(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit()
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
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    public function getDocumentsForCliente(Request $request)
    {
        try {
            $descarga_documento_request = new DescargaDocumentoRequest();
            $descarga_documento_request->validateGetDocumentosRequest($request->all());
            $descarga_documento_request = $descarga_documento_request->fromGetFromRequest($request);

            $documents = $this->documento_service->getDocumentsForDownloadByCCNIT($descarga_documento_request->getCcNitCliente());

            return response()->json($documents, 200);
        } catch (\Throwable $th) {
            Log::error('Ocurrio error al obtener los documentos de un cliente ' . $th->getMessage());
            throw $th;
        }
    }

    public function getDocumentForCliente(Request $request)
    {
        try {
            $descarga_documento_request = new DescargaDocumentoRequest();
            $descarga_documento_request->validateGetDocumentoRequest($request->all());
            $descarga_documento_request = $descarga_documento_request->fromGetFromRequest($request);

            $document = $this->documento_service->getClientDocumentForDownload($descarga_documento_request->getCcNitCliente());

            return response()->json($document, 200);
        } catch (\Throwable $th) {
            Log::error('Ocurrio error al obtener los documentos de un cliente ' . $th->getMessage());
            throw $th;
        }
    }
}
