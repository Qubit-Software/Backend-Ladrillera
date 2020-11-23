<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoPedidoModel extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'productos_pedidos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pedido',
        'cantidad',
        'codigo_producto',
        'valor_total',
        'unidad_medicion'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public $timestamps = false;
}
