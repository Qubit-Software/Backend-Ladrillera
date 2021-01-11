<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'id',
        'nombre',
        'apellido',
        'cc_nit',
        'tipo_cliente',
        'ciudad',
        'correo',
        'telefono',
        'productos',
        'documentos',
        'empleado_asociado'
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

    /**
     * 
     * Gets the employee who associated the client to the compañu
     * @return HasOne 
     */
    public function empleado_asociado()
    {
        return $this->hasOne('App\Models\EmpleadoModel', 'id');
    }
}
