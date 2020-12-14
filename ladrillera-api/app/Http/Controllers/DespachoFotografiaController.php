<?php

namespace App\Http\Controllers;

use App\Http\Schemas\Requests\DespachoFotografiaRequest;
use App\Http\Schemas\Requests\DocumentoRequestType;
use App\Models\DespachoFotografiaModel;
use App\Models\PedidoModel;
use App\Services\DespachoFotografiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DespachoFotografiaController extends Controller
{
    private $despacho_foto_service;


    public function __construct(DespachoFotografiaService $despacho_foto_service)
    {
        $this->despacho_foto_service = $despacho_foto_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $despacho_fotos = $this->despacho_foto_service->getAll();

        return response()->json($despacho_fotos, 200);
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
            $despacho_foto_req = new DespachoFotografiaRequest();
            $despacho_foto_req->validateCreate($request->all());
            $despacho_foto_req = $despacho_foto_req->getFromRequest($request);

            $pedido = PedidoModel::findOrFail($despacho_foto_req->getIdPedido());
            $despacho_foto = $this->despacho_foto_service->createDespachoFotofrafia($despacho_foto_req, $pedido);
            DB::commit();
            return response()->json($despacho_foto, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DespachoFotografiaModel  $fotografia
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DespachoFotografiaModel $fotografia)
    {
        $type = strtoupper($request->query("type", DocumentoRequestType::INFO));
        $resp_despacho_foto = null;
        switch ($type) {
            case DocumentoRequestType::INFO:
                $resp_despacho_foto = $fotografia;
                break;
            case DocumentoRequestType::DOWNLOAD:
                $file_path = $this->despacho_foto_service->getFotoPath($fotografia->foto);
                $resp_despacho_foto = Storage::disk('s3')->download($file_path);
                break;
            case DocumentoRequestType::LINK:
                $temp_url = $this->despacho_foto_service->getFotoTempUrl($fotografia->foto);
                $resp_despacho_foto = response()->json(["temp_url" => $temp_url], 200);
                break;
            case DocumentoRequestType::DISPLAY:
                // Or redirect https://laracasts.com/discuss/channels/laravel/file-response-from-s3
                $file_path = $this->despacho_foto_service->getFotoPath($fotografia->foto);
                $file =  Storage::disk('s3')->get($file_path);
                $fotoname = basename($fotografia->foto);
                $headers = [
                    'Content-Type' => 'image/jpeg',
                    'Content-Description' => 'File Transfer',
                    'Content-Disposition' => "attachment; filename={$fotoname}",
                    'filename' => $fotoname
                ];
                $resp_despacho_foto = response()->make($file, 200, $headers);
                break;
            default:
                $resp_despacho_foto = $fotografia;
                break;
        }
        return $resp_despacho_foto;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DespachoFotografiaModel  $despachoFotografiaModel
     * @return \Illuminate\Http\Response
     */
    public function edit(DespachoFotografiaModel $despachoFotografiaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DespachoFotografiaModel  $despachoFotografiaModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DespachoFotografiaModel $despachoFotografiaModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DespachoFotografiaModel  $despachoFotografiaModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(DespachoFotografiaModel $despachoFotografiaModel)
    {
        //
    }
}
