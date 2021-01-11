<?php

namespace App\Models;

use DateTime;
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
        "productos",
        "cliente"
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha_cargue'];

    public $timestamps = false;

    /**
     * Get the pedidos for the blog post.
     */
    public function productos()
    {
        return $this->hasMany('App\Models\ProductoPedidoModel', 'id_pedido', 'id');
    }

    /**
     * Get the client of the pedido.
     */
    public function cliente()
    {
        return $this->belongsTo('App\Models\ClienteModel', 'id_cliente');
    }


    /**
     * Get the user's first name.
     *
     * @param  date  $value
     * @return date
     */
    public function getFechaCargueAttribute($value)
    {
        return date('Y-m-d', strtotime($value === NULL ? '' : $value));
    }
    /**
     * Get the user's first name.
     *
     * @param  date  $value
     * @return date
     */
    public function setFechaCargueAttribute($value)
    {
        $string_date = ($value instanceof DateTime) ? $value->format('Y-m-d') :  $value;
        $this->attributes['fecha_cargue'] = date('Y-m-d', strtotime($string_date === NULL ? '' : $string_date));
    }
}
