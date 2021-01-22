<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ClienteRequest
{

    private $id_empleado_asociado;
    private $nombre;
    private $apellido;
    private $cc_nit;
    private $tipo_cliente;
    private $ciudad;
    private $correo;
    private $telefono;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }


    public function validateCreateRequest($request)
    {
        $rules = [
            'id_empleado_asociado' => 'sometimes|exists:empleados,id',
            'nombre' => 'required|min:1',
            'apellido' => 'required|min:2|max:100',
            'cc_nit' => 'required|string|unique:clientes',
            'tipo_cliente' => 'required',
            'ciudad' => 'required|string',
            'correo' => 'required|string|email|unique:clientes',
            'telefono' =>  'required|string|unique:clientes'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de pedido");
        }
    }

    public function validateUpdateRequest($request, $cliend_id)
    {
        $rules = [
            'id_empleado_asociado' => 'sometimes|exists:empleados,id',
            'nombre' => 'required|min:1',
            'apellido' => 'required|min:2|max:100',
            'cc_nit' => [
                'required',
                'string',
                Rule::unique("clientes")->ignore($cliend_id, "id"),
            ],
            'tipo_cliente' => 'required',
            'ciudad' => 'required|string',
            'correo' => 'required|string|email',
            'telefono' =>  [
                'required',
                'string',
                Rule::unique("clientes", "telefono")->ignore($cliend_id, "id"),
            ],
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de pedido");
        }
    }


    public static function from_request(Request $request)
    {
        $new_instance = new self();
        $new_instance->id_empleado_asociado = ($request->has('id_empleado_asociado')) ? $request->id_empleado_asociado : NULL;

        $new_instance->nombre = $request->nombre;
        $new_instance->apellido = $request->apellido;
        $new_instance->cc_nit = $request->cc_nit;
        $new_instance->tipo_cliente = $request->tipo_cliente;
        $new_instance->ciudad = $request->ciudad;
        $new_instance->correo = $request->correo;
        $new_instance->telefono = $request->telefono;

        return $new_instance;
    }


    public function getIdEmpleado()
    {
        return $this->id_empleado_asociado;
    }

    public function setIdEmpleado($id_empleado)
    {
        $this->id_empleado_asociado = $id_empleado;
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

    public function getTipoCliente()
    {
        return $this->tipo_cliente;
    }

    public function setTipoCliente($tipo_cliente)
    {
        $this->tipo_cliente = $tipo_cliente;
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
