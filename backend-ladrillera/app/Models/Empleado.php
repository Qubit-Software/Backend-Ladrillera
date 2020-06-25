<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        "nombre",
        "apellido",
        "cedula_ciudadania",
        "genero",
        "fecha_nacimiento",
        "rol",
    ];
    public $timestamps = false;

    public function modules()
    {
        return $this
            ->belongsToMany('App\Models\Modulo', 'empleados_modulos', 'id_empleado', 'id_modulo');
    }

    public function authorizeModules($modules)
    {
        if ($this->hasAnyRole($modules)) {
            return true;
        }
        abort(401, 'Esta acción no está autorizada.');
    }
    public function hasAnyModule($modules)
    {
        if (is_array($modules)) {
            foreach ($modules as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($modules)) {
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
}
