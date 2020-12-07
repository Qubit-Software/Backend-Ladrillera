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

    private $id_pedido;
    private $cantidad;
    private $codigo_producto;
    private $valor_total;
    private $unidad_medicion;
    private $comentarios;
    private $iva;

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
                'distinct',
                Rule::in(array_keys(Config::get('constants.productos')))
            ],
            '*.valor_total' => 'required|numeric',
            '*.unidad_medicion' => 'required|string',
            '*.iva' => 'required|numeric',
            '*.comentarios' => 'nullable|string'
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

        $new_instance->cantidad = $request->cantidad;
        $new_instance->codigo_producto = $request->codigo_producto;
        $new_instance->unidad_medicion = $request->unidad_medicion;
        $new_instance->valor_total = $request->valor_total;
        $new_instance->iva = $request->iva;
        $new_instance->comentarios = $request->comentarios;

        return $new_instance;
    }

    public static function fromProductoRequest(
        $codigo_producto,
        $unidad_medicion,
        $cantidad,
        $valor_total,
        $iva,
        $comentarios
    ) {
        $new_instance = new self();

        $new_instance->cantidad = $cantidad;
        $new_instance->codigo_producto = $codigo_producto;
        $new_instance->unidad_medicion = $unidad_medicion;
        $new_instance->valor_total = $valor_total;
        $new_instance->iva = $iva;
        $new_instance->comentarios = $comentarios;

        return $new_instance;
    }

    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    public function setIdPedido($id_pedido)
    {
        $this->id_pedido = $id_pedido;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getCodigoProducto()
    {
        return $this->codigo_producto;
    }

    public function setCodigoProducto($codigo_producto)
    {
        $this->codigo_producto = $codigo_producto;
    }

    public function getValorTotal()
    {
        return $this->valor_total;
    }

    public function setValorTotal($valor_total)
    {
        $this->valor_total = $valor_total;
    }

    public function getUnidadMedicion()
    {
        return $this->unidad_medicion;
    }

    public function setUnidadMedicion($unidad_medicion)
    {
        $this->unidad_medicion = $unidad_medicion;
    }

    public function getIva()
    {
        return $this->iva;
    }

    public function setIva($iva)
    {
        $this->iva = $iva;
    }

    public function getComentarios()
    {
        return $this->comentarios;
    }

    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;
    }
}
