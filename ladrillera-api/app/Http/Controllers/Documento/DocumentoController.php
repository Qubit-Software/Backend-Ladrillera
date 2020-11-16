<?php

namespace App\Http\Controllers\Documento;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illiminate\Support\Str;
use App\Models\ClienteModel;
use App\Services\FilesService;
use App\Models\DocumentoModel;

class DocumentoController extends Controller
{
    protected $filesService;

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(FilesService $filesService)
    {
        $this->filesService = $filesService;
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
        $rules = [
            "id_cliente"=> "required|numeric|min:0",
            // 'file' => 'required|max:10000|mimes:doc,docx' //a required, max 10000kb, doc or docx file
            'archivo' => 'required|max:10000|mimes:doc,docx,pdf', //a required, max 10000kb, doc or docx file
            'tipo_archivo' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $client  = ClienteModel::find($id);
        $client_name =  Str::title($client->apellido). Str::title($client->nombre);
        $fileName = $client_name . Str::title($request->tipo_documento) ;
        $folder = $client_name;

        $this->filesService->saveClientFile($request->archivo, $fileName, $folder);

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
