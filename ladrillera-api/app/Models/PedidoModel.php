<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoModel extends Model
{
    public static $key = 'id';
    protected $primaryKey = 'id';
    protected $table = 'pedidos';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id_cliente",
        "fecha_cargue",
        "total",
        "estatus",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        "id",
        "id_cliente",
        "fecha_cargue",
        "total",
        "estatus",
        "productos"
    ];

    public $timestamps = false;

    /**
     * Get the pedidos for the blog post.
     */
    public function productos()
    {
        return $this->hasMany('App\Models\ProductoPedidoModel', 'id_pedido', 'id');
    }
}
