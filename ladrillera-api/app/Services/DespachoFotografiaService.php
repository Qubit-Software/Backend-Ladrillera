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
    const CLIENT_FOTO_TEMP_URL_DURATION = 1440;
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
        $file_name = Str::upper(pathinfo($despachoFotografiaRequest->getFoto()->getClientOriginalName())["filename"]);
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

    public function getByIdPedido($id_pedido)
    {
        return DespachoFotografiaModel::where('id_pedido', $id_pedido)->get();
    }


    public function getFotoForDownload($filename)
    {
        return $this->files_service->getFotoFromPedidosDirectory($filename);
    }

    public function getFotoPath($filename)
    {
        $path =  Storage::disk("pedidos")->path($filename);
        return $path;
    }

    public function getFotoTempUrl($filename)
    {
        $disk = Storage::disk('pedidos');
        $temp_url = $disk->temporaryUrl($filename,  Carbon::now()->addMinutes($this::CLIENT_FOTO_TEMP_URL_DURATION));
        return $temp_url;
    }
}
