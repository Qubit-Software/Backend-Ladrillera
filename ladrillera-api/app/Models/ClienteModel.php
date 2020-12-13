<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{
    public static $key = 'id';
    protected $table = 'clientes';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_empleado_asociado',
        'nombre',
        'apellido',
        'cc_nit',
        'tipo_cliente',
        'ciudad',
        'correo',
        'telefono',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'nombre',
        'apellido',
        'cc_nit',
        'tipo_cliente',
        'ciudad',
        'correo',
        'telefono',
        'productos',
        'documentos',
    ];

    public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    /**
     * Get the documents for the client.
     */
    public function documentos()
    {
        return $this->hasMany('App\Models\DocumentoModel', 'id_cliente', 'id');
    }

    /**
     * Get the documents for the client.
     */
    public function pedidos()
    {
        return $this->hasMany('App\Models\PedidoModel', 'id_cliente', 'id');
    }
}
