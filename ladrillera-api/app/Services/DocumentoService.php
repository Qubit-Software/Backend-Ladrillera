<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;

class DocumentoService{

    protected $files_service;
    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(FilesService $files_service)
    {
        $this->files_service = $files_service;
    }

    public function get_all(){
        $documents = DocumentoModel::all();
        return response()->json($documents, 200);
    }
    public function create_document($client, $documentoRequest){
        DB::beginTransaction();
        try {
            $client_name =  \Str::title($client->apellido) . \Str::title($client->nombre);
            $file_name = $client_name . \Str::title($documentoRequest->get_tipo_documento());
            $file_name = str_replace(" ", "", $file_name);

            $folder = $client->cc_nit;
            $documento = $documentoRequest->get_documento();
            $extension = $documento->getClientOriginalExtension();

            $saved_file_path = $this->files_service->saveClientFile($documento, $file_name, $folder);
            
            $data = [
                'file_path'=>$saved_file_path,
                'nombre'=>$file_name .'.'. $extension, 
                'tipo_documento'=>$documentoRequest->get_tipo_documento(),
                'id_cliente'=>$client->id
            ];
            $documento = new DocumentoModel($data);
            $documento->save();
            DB::commit();
            return $documento;
        } catch (\Throwable $th) {
            \Log::error('Error when saving document '.$th);
            DB::rollback();

        }

    }

}