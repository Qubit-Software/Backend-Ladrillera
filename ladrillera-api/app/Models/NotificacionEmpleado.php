<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionEmpleadoModel extends Model
{
    public static $key = 'id';
    protected $primaryKey = 'id';
    protected $table = 'notificaciones_empleados';

    protected $fillable = [
        'id_empleado',
        'id_notificacion',
        'lectura'
    ];

    protected $attributes = array(
        'lectura' => 0,
    );
    public $timestamps = false;
}
