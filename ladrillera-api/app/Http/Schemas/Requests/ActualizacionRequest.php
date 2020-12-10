<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActualizacionRequest
{

    private $titulo;
    private $descripcion;
    private $fecha;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }


    public function validateCreateRequest($request)
    {
        $rules = [
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'fecha' => 'required|date_format:j/n/Y',
        ];

        $data = $request->all();

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
        $new_instance->descripcion = $request->descripcion;
        $new_instance->fecha = $request->fecha;

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

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
}
