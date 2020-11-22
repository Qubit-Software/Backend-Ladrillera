<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Log;

class ClienteRequest
{

    private $id_empleado;
    private $nombre;
    private $apellido;
    private $cc_nit;
    private $tipo_persona;
    private $ciudad;
    private $correo;
    private $telefono;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }


    public function validateRequest($request)
    {
        $rules = [
            'id_empleado' => 'required|exists:empleados,id',
            "nombre" => "required|min:1",
            "apellido" => "required|min:2|max:100",
            "cc_nit" => "required|digits:10",
            "tipo_persona" => "required",
            "ciudad" => "required|string",
            "correo" => "required|string|email|unique:users",
            'telefono' =>  'required|max:10'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de pedido");
        }
    }

    public static function from_request($request)
    {
        $new_instance = new self();
        $new_instance->id_empleado = $request->id_empleado;

        $new_instance->nombre = $request->nombre;
        $new_instance->apellido = $request->apellido;
        $new_instance->cc_nit = $request->cc_nit;
        $new_instance->tipo_persona = $request->tipo_persona;
        $new_instance->ciudad = $request->rol;
        $new_instance->correo = $request->email;
        $new_instance->telefono = $request->telefono;

        return $new_instance;
    }


    public function getIdEmpleado()
    {
        return $this->id_empleado;
    }

    public function setIdEmpleado($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function getCCNit()
    {
        return $this->cc_nit;
    }

    public function setCCNit($cc_nit)
    {
        $this->cc_nit = $cc_nit;
    }

    public function getTipoPersona()
    {
        return $this->tipo_persona;
    }

    public function setTipoPersona($tipo_persona)
    {
        $this->tipo_persona = $tipo_persona;
    }

    public function getCiudad()
    {
        return $this->ciudad;
    }

    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
}
