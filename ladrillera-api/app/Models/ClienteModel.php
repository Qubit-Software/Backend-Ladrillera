<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{

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
    public function documents()
    {
        return $this->hasMany('App\Models\DocumentModel');
    }
}
