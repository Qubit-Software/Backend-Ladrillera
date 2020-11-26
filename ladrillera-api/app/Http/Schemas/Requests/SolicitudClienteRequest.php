<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SolicitudClienteRequest
{

    private $nombre;
    private $telefono;
    private $creado;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }


    public function validateCreate(array $data)
    {
        $rules = [
            'nombre' => 'required|min:1',
            'telefono' =>  'required|max:10',
            'creado' =>  'nullable|max:1',
        ];

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de pedido");
        }
    }

    public static function from_request(Request $request)
    {
        $new_instance = new self();

        $new_instance->nombre = $request->nombre;
        $new_instance->telefono = $request->telefono;
        $new_instance->creado = $request->creado;

        return $new_instance;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getCreado()
    {
        return $this->creado;
    }

    public function setCreado($creado)
    {
        $this->creado = $creado;
    }
}
