<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;

class DocumentoService{

    protected $filesService;
    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(FilesService $filesService)
    {
        $this->filesService = $filesService;
    }
    
    public function createDocument($client, $documentoRequest){
        DB::beginTransaction();
        try {
            $client_name =  \Str::of(\Str::title($client->apellido))->replace(' ', '') . \Str::of(\Str::title($client->nombre))->replace(' ', '');
            $fileName = $client_name . \Str::title($documentoRequest->get_tipo_documento()) ;
            $folder = $client->cc_nit;
            $documento = $documentoRequest->get_documento();
            $extension = $documento->getClientOriginalExtension();

            $saved_file_path = $this->filesService->saveClientFile($documento, $fileName, $folder);
            
            $data = [
                'file_path'=>$saved_file_path,
                'nombre'=>$fileName .'.'. $extension, 
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