<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PedidoRequest
{

    private $id_cliente;
    private $fecha_cargue;
    private $total;
    private $estatus;

    // Associated products
    private $productos;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }


    public function validateCreateRequest(array $data)
    {
        $rules = [
            'id_cliente' => 'required|exists:clientes,id',
            'fecha_cargue' => 'required|date_format:d/m/Y',
            'total' => 'nullable|min:2|max:100',
            'estatus' => 'nullable',
            'productos' => 'required|array'
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
        $new_instance->id_cliente = $request->id_cliente;
        $new_instance->fecha_cargue = $request->fecha_cargue;
        $new_instance->total = $request->total;
        $new_instance->estatus = $request->estatus;
        $new_instance->productos = $request->productos;

        return $new_instance;
    }


    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function getFechaCargue()
    {
        return $this->fecha_cargue;
    }

    public function setFechaCargue($fecha_cargue)
    {
        $this->fecha_cargue = $fecha_cargue;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;
    }

    public function getProductos()
    {
        return $this->productos;
    }

    public function setProductos($productos)
    {
        $this->productos = $productos;
    }
}
