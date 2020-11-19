<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionEmpleadoModel extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'notificaciones_empleados';
    protected $fillable = [
        'id_empleado',
        'id_notificacion'
    ];
    public $timestamps = false;
}
