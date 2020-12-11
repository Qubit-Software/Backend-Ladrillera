<?php

namespace App\Services;

use App\Http\Schemas\Requests\DocumentoRequest;
use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DocumentoService
{

    protected $files_service;

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(FilesService $files_service)
    {
        $this->files_service = $files_service;
    }

    public function getAll()
    {
        $documents = DocumentoModel::all();
        return response()->json($documents, 200);
    }

    public function createDocument($client, DocumentoRequest $documentoRequest)
    {
        $client_name =  Str::title($client->apellido) . Str::title($client->nombre);
        $file_name = $client_name . Str::title($documentoRequest->getTipoDocumento());
        $file_name = str_replace(" ", "", $file_name);

        $folder = $client->cc_nit;
        $documento = $documentoRequest->getDocumento();
        $extension = $documento->getClientOriginalExtension();

        $saved_file_path = $this->files_service->saveClientFile($documento, $file_name, $folder);

        $data = [
            'file_path' => $saved_file_path,
            'nombre' => $file_name . '.' . $extension,
            'tipo_documento' => $documentoRequest->getTipoDocumento(),
            'id_cliente' => $client->id
        ];
        $documento = new DocumentoModel($data);
        $documento->save();
        return $documento;
    }
}
