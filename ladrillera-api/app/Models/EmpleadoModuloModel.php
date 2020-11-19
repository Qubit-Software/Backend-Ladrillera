<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoModuloModel extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'empleados_modulos';
    public $timestamps = false;
    protected $fillable = [
        'id_empleado',
        'id_modulo'
    ];
}
