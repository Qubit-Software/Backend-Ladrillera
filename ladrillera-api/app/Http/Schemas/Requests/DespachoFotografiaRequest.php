<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;

class DespachoFotografiaRequest
{

    private $id_pedido;
    private $foto;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }

    public function validateCreate($data)
    {
        $rules = [
            'id_pedido' => 'required|exists:App\Models\PedidoModel,id',
            'foto' => 'required|max:10000|mimes:png,jpeg,jpg',
        ];

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de documento");
        }
    }


    public function getFromRequest(Request $request)
    {
        $new_instance = new self();
        $new_instance->id_pedido = $request->id_pedido ?? null;
        $new_instance->foto = $request->foto ?? null;

        return $new_instance;
    }

    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    public function setIdPedido($id_pedido)
    {
        return $this->id_pedido = $id_pedido;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        return $this->foto = $foto;
    }
}
