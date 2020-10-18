<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
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
    public $timestamps = true;

    //
    public function empleados()
    {
        return $this
            ->belongsToMany(
                'App\Models\Empleado',
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
