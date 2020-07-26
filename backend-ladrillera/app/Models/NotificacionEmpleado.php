<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionEmpleado extends Model
{
    protected $table = 'notificaciones_empleados';
    protected $fillable = [
        'id_empleado',
        'id_notificacion'
    ];
    public $timestamps = false;
}
