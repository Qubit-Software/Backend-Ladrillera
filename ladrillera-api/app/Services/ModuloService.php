<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;

class ModuloService{

    protected $files_service;
    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(FilesService $files_service)
    {
        $this->files_service = $files_service;
    }


}