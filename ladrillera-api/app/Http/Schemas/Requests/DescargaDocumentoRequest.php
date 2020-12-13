<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;

class DescargaDocumentoRequest
{

    private $id_cliente;
    private $cc_nit_cliente;
    private $nombre_documento;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }

    public function validateGetDocumentosRequest($data)
    {
        $rules = [
            'cc_nit_cliente' => 'required|numeric|exists:App\Models\ClienteModel,cc_nit',
        ];

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de documento");
        }
    }

    public function validateGetDocumentoRequest($data)
    {
        $rules = [
            'cc_nit_cliente' => 'required|numeric|exists:App\Models\ClienteModel,cc_nit',
            'nombre_documento' => 'required|exists:App\Models\DocumentoModel,nombre',
        ];

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de documento");
        }
    }


    public function fromGetFromRequest($request)
    {
        $new_instance = new self();
        $new_instance->id_cliente = $request->id_cliente ?? null;
        $new_instance->cc_nit_cliente = $request->cc_nit_cliente ?? null;
        $new_instance->nombre_documento = $request->nombre_documento ?? null;

        return $new_instance;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente)
    {
        return $this->id_cliente = $id_cliente;
    }

    public function getCcNitCliente()
    {
        return $this->cc_nit_cliente;
    }

    public function setCcNitCliente($cc_nit_cliente)
    {
        return $this->cc_nit_cliente = $cc_nit_cliente;
    }

    public function getNombreDocumento()
    {
        return $this->nombre_documento;
    }

    public function setNombreDocumento($nombre_documento)
    {
        return $this->nombre_documento = $nombre_documento;
    }
}
