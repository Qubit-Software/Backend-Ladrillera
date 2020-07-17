<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoModulo extends Model
{
    protected $table = 'empleados_modulos';
    public $timestamps = false;
    protected $fillable = [
        'id_empleado',
        'id_modulo'
    ];
}
