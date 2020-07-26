<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    protected $guarded = [
        'id'
    ];
    public $timestamps = false;

    //
    public function empleados()
    {
        return $this
            ->belongsToMany('App\Models\Empleado', 'empleados_modulos', 'id_modulo', 'id_empleado');
    }
}
