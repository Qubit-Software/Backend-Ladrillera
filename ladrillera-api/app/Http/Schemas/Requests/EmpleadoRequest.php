<?php

namespace App\Http\Schemas\Requests;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class EmpleadoRequest
{

    private $nombre;
    private $apellido;
    private $cedula_ciudadania;
    private $genero;
    private $fecha_nacimiento;
    private $rol;
    private $foto;
    private $email;
    private $modulo_ids;

    // Para pasar cuando se cree el usuario
    private $plain_password;
    private $id_usuario;
    private $id_empleado;

    /**
     * Instantiate a new DocumentoValidator instance.
     */
    public function __construct()
    {
    }

    public function validateRequest($request)
    {
        $rules = [
            "nombre" => "required|min:1",
            "apellido" => "required|min:2|max:100",
            "cedula_ciudadania" => "required|digits:10|unique:empleados",
            "genero" => "required|min:1",
            "fecha_nacimiento" => "required|date_format:Y-m-d",
            "rol" => "required|string",
            'foto' =>  'required||max:10000|mimes:jpeg,png,jpg,gif',
            "email" => "required|string|email|unique:users",
            "modulo_ids" => "required|json"
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de empleado");
        }

        // Processed rules
        $data = [
            'modulo_ids' => json_decode($data['modulo_ids'])
        ];
        $rules = [
            'modulo_ids' => 'array|min:1',
            'modulo_ids.*' => 'exists:modulos,id|distinct'
        ];

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de empleado");
        }
    }



    public function validateUpdateRequest($data, $id)
    {
        $rules = [
            "id_empleado" => "required|exists:empleados,id",
            "nombre" => "required|min:1",
            "apellido" => "required|min:2|max:100",
            "cedula_ciudadania" => [
                "required",
                "digits:10",
                Rule::unique("empleados")->ignore($id, "id"),
            ],
            "genero" => "required|min:1",
            "fecha_nacimiento" => "required|date_format:Y-m-d",
            "rol" => "required|string",
            'foto' =>  'required|mimes:jpeg,png,jpg,gif,tiff,psd,pdf|max:2048',
            "modulo_ids" => "required|json",
            // "email" => [
            //     "required",
            //     "email",
            //     Rule::unique("empleados", "correo")->ignore($id, "id")
            // ],
        ];

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de actualización de empleado");
        }

        // Processed rules
        $data = [
            'modulo_ids' => json_decode($data['modulo_ids'])
        ];
        $rules = [
            'modulo_ids' => 'array|min:1',
            'modulo_ids.*' => 'exists:modulos,id|distinct'
        ];

        $validator = Validator::make($data, $rules);

        $errors =  $validator->errors();
        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "Error al validar la peticion de creación de empleado");
        }
    }

    public static function from_request($request)
    {
        $new_instance = new self();
        $new_instance->nombre = $request->nombre;
        $new_instance->apellido = $request->apellido;
        $new_instance->cedula_ciudadania = $request->cedula_ciudadania;
        $new_instance->genero = $request->genero;
        $new_instance->fecha_nacimiento = $request->fecha_nacimiento;
        $new_instance->rol = $request->rol;
        $new_instance->foto = $request->file('foto');
        $new_instance->email = $request->email;
        $new_instance->modulo_ids = $request->modulo_ids;

        return $new_instance;
    }

    public static function from_update_request($request)
    {
        $new_instance = new self();
        $new_instance->nombre = $request->nombre;
        $new_instance->apellido = $request->apellido;
        $new_instance->cedula_ciudadania = $request->cedula_ciudadania;
        $new_instance->genero = $request->genero;
        $new_instance->fecha_nacimiento = $request->fecha_nacimiento;
        $new_instance->rol = $request->rol;
        $new_instance->foto = $request->file('foto');
        $new_instance->email = $request->email;
        $new_instance->modulo_ids = $request->modulo_ids;
        $new_instance->plain_password = $request->password;

        return $new_instance;
    }



    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function getCedulaCiudadania()
    {
        return $this->cedula_ciudadania;
    }

    public function setCedulaCiudadania($cedula_ciudadania)
    {
        $this->cedula_ciudadania = $cedula_ciudadania;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getModulos()
    {
        return $this->modulo_ids;
    }

    public function setModulos($modulos)
    {
        $this->modulo_ids = $modulos;
    }


    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function getPlainPassword()
    {
        return $this->plain_password;
    }

    public function setRandomPassword()
    {
        $this->plain_password = Str::random(10);
    }

    public function setPasswordVal($plain_password)
    {
        $this->plain_password = $plain_password;
    }

    public function getIdEmpleado()
    {
        return $this->id_empleado;
    }

    public function setIdEmpleado($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }
}
