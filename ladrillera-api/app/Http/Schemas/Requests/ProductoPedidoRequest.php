<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProductoPedidoRequest
{

    private $id_empleado;
    private $id_cliente;
    private $fecha_cargue;
    private $total;
    private $estatus;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }


    public function validateCreate(array $data)
    {
        $rules = [
            '*.id_pedido' => 'sometimes|exists:App\Models\PedidoModel,id',
            '*.cantidad' => 'required|numeric|min:1',
            '*.codigo_producto' => [
                'required',
                Rule::in(array_keys(Config::get('constants.productos')))
            ],
            '*.valor_total' => 'nullable|numeric',
            '*.unidad_medicion' => 'required|string'
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
