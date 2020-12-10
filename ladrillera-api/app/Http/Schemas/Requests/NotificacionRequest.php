<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class NotificacionRequest
{

    private $titulo;
    private $body;
    private $router;
    private $alcance;
    private $prioridad;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }


    public function validateCreateRequest(array $data)
    {
        $rules = [
            "user_id" => "sometimes|min:1",
            "titulo" => "required|string|min:10",
            "body" => "required|string|min:10",
            "router" => "required|string",
            "alcance" => "required|string",
            "prioridad" => "required|min:1"
        ];

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de pedido");
        }
    }

    public function validateUpdateRequest(array $data)
    {
        $rules = [
            'id_pedido' => 'required|exists:pedidos,id',
            'estatus' => [
                'required',
                'numeric',
                Rule::in(array_keys(Config::get('constants.estatus')))
            ],
        ];

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de pedido");
        }
    }

    public static function fromRequest(Request $request)
    {
        $new_instance = new self();
        $new_instance->titulo = $request->titulo;
        $new_instance->body = $request->body;
        $new_instance->router = $request->router;
        $new_instance->alcance = $request->alcance;
        $new_instance->prioridad = $request->prioridad;

        return $new_instance;
    }

    public static function fromUpdateRequest(Request $request)
    {
        $new_instance = new self();
        $new_instance->estatus = $request->estatus;
        $new_instance->id_pedido = $request->id_pedido;

        return $new_instance;
    }


    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    public function getAlcance()
    {
        return $this->alcance;
    }

    public function setAlcance($alcance)
    {
        $this->alcance = $alcance;
    }

    public function getPrioridad()
    {
        return $this->prioridad;
    }

    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
    }
}
