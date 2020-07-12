<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado_Modulo extends Model
{
    protected $table = 'empleados_modulos';
    public $timestamps = false;
    protected $fillable = [
        'id_empleado',
        'id_modulo'
    ];
}
