<?php

namespace App\Services;

use App\Http\Schemas\Requests\DespachoFotografiaRequest;
use App\Http\Schemas\Requests\DocumentoRequest;
use App\Models\DespachoFotografia;
use App\Models\DespachoFotografiaModel;
use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;
use App\Models\PedidoModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DespachoFotografiaService
{
    protected $files_service;

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(FilesService $files_service)
    {
        $this->files_service = $files_service;
    }

    public function createDespachoFotofrafia(DespachoFotografiaRequest $despachoFotografiaRequest, PedidoModel $pedido_model)
    {
        $file_name = Str::upper(strval($despachoFotografiaRequest->getFoto()->getClientOriginalName()));
        $file_name = str_replace(" ", "", $file_name);

        $folder = strval($pedido_model->id);
        $foto = $despachoFotografiaRequest->getFoto();

        $saved_file_path = $this->files_service->savePedidoFotografia(
            $foto,
            $file_name,
            $folder
        );

        $data = [
            'id_pedido' => $despachoFotografiaRequest->getIdPedido(),
            'foto' => $saved_file_path,
        ];

        $despacho_fotografia = new DespachoFotografiaModel($data);
        $despacho_fotografia->save();

        return $despacho_fotografia;
    }

    public function getAll()
    {
        return DespachoFotografiaModel::all();
    }

    public function getById($id)
    {
        return DespachoFotografiaModel::findOrFail($id);
    }
}
