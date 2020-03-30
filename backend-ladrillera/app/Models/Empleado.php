<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $primaryKey = 'id_empleado';
    protected $fillable = [
        "id_empleado",
        "nombre",
        "apellido",
        "cedula_ciudadania",
        "genero",
        "fecha_nacimiento",
        "cargo",
    ];
    public $timestamps = false;
}
