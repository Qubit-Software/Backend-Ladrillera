<?php

namespace App\Services;

use App\Http\Schemas\Requests\DocumentoRequest;
use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentoService
{
    const CLIENT_FILE_TEMP_URL_DURATION = 1440;
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
        return DocumentoModel::all();
    }

    public function getById($id)
    {
        return DocumentoModel::findOrFail($id);
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

    public function getDocumentsForDownloadByCCNIT($cc_nit)
    {
        return $this->files_service->getFilesFromClientsDirectory($cc_nit);
    }

    public function getClientDocumentForDownload($filename)
    {
        return $this->files_service->getFileFromClientsDirectory($filename);
    }

    public function getClientDocumentPath($filename)
    {
        $path =  Storage::disk("clients")->path($filename);
        return $path;
    }

    public function getClientDocumentTempUrl($filename)
    {
        $disk = Storage::disk('clients');
        $temp_url = $disk->temporaryUrl($filename,  Carbon::now()->addMinutes($this::CLIENT_FILE_TEMP_URL_DURATION));
        return $temp_url;
    }
}
