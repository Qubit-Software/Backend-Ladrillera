<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoModel extends Model
{
    public static $key = 'id';
    protected $primaryKey = 'id';
    protected $table = 'empleados';

    protected $fillable = [
        "nombre",
        "apellido",
        "cedula_ciudadania",
        "genero",
        "fecha_nacimiento",
        "rol",
        "correo",
        "foto",
        "id_usuario"
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        "id",
        "nombre",
        "apellido",
        "cedula_ciudadania",
        "genero",
        "fecha_nacimiento",
        "rol",
        "correo",
        "foto",
        "id_usuario"
    ];

    public $timestamps = false;


    public function authorizeModules(array $modules)
    {
        if ($this->hasAnyModule($modules)) {
            return true;
        }

        return false;
    }

    public function hasAnyModule(array $modules)
    {
        if (is_array($modules)) {
            foreach ($modules as $role) {
                if ($this->hasModule($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasModule($modules)) {
                return true;
            }
        }

        return false;
    }

    public function hasModule($module)
    {
        if ($this->modules()->where('nombre', $module)->first()) {
            return true;
        }
        return false;
    }

    public function modules()
    {
        return $this
            ->belongsToMany('App\Models\ModuloModel', 'empleados_modulos', 'id_empleado', 'id_modulo');
    }

    public function getImageAttribute()
    {
        return $this->foto;
    }

    public function notificaciones()
    {
        return $this
            ->belongsToMany(
                'App\Models\NotificacionModel',
                'notificaciones_empleados',
                'id_empleado',
                'id_notificacion'
            );
    }
}
