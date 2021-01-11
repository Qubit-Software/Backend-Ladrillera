<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;

class DocumentoRequest
{

    private $id_cliente;
    private $documento;
    private $tipo_documento;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }


    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public static function withData($id_cliente, $documento, $tipo_documento)
    {
        $new_instance = new self();
        $new_instance->id_cliente = $id_cliente;
        $new_instance->documento = $documento;
        $new_instance->tipo_documento = $tipo_documento;

        return $new_instance;
    }


    public function validateRequest($request)
    {
        $rules = [
            "id_cliente" => "required|numeric|exists:App\Models\ClienteModel,id",
            'documento' => 'required|max:10000|mimes:doc,docx,pdf,png,jpeg',
            'tipo_documento' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de documento");
        }
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function getTipoDocumento()
    {
        return $this->tipo_documento;
    }
}
