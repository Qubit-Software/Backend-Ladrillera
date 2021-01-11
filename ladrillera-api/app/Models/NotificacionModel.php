<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionModel extends Model
{
    protected $primaryKey = 'id';
    protected $table = "notificaciones";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "titulo",
        "body",
        "router",
        "alcance",
        "prioridad",
    ];

    protected $guarded = [
        'id'
    ];

    public $timestamps = false;

    //
    public function empleados()
    {
        return $this
            ->belongsToMany(
                'App\Models\EmpleadoModel',
                'notificaciones_empleados',
                'id_notificacion',
                'id_empleado'
            );
    }

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}
