<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuloModel extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'modulos';
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

    public function empleados()
    {
        return $this
            ->belongsToMany('App\Models\EmpleadoModel', 'empleados_modulos', 'id_modulo', 'id_empleado');
    }
}
