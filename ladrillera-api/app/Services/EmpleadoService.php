<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;
use App\Models\EmpleadoModel;

use App\Services\UsuarioService;
use App\Services\UserService;

use App\Http\Schemas\Requests\EmpleadoRequest;
use App\Models\UsuarioModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class EmpleadoService
{

    private $files_service;
    private $user_service;
    private $usuario_service;


    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(
        FilesService $files_service,
        UserService $user_service,
        UsuarioService $usuario_service
    ) {
        $this->files_service = $files_service;
        $this->usuario_service = $usuario_service;
        $this->user_service = $user_service;
    }


    public function getAll()
    {
        return EmpleadoModel::all();
    }


    public function createEmpleado(EmpleadoRequest $datos_empleado, UsuarioModel $user)
    {
        $data_empleado = [
            "nombre" => $datos_empleado->getNombre(),
            "apellido" => $datos_empleado->getApellido(),
            "cedula_ciudadania" => $datos_empleado->getCedulaCiudadania(),
            "genero" => $datos_empleado->getGenero(),
            "fecha_nacimiento" => $datos_empleado->getFechaNacimiento(),
            "rol" => $datos_empleado->getRol(),
            "correo" => $datos_empleado->getEmail(),
            "id_usuario" => $user->id
        ];

        // $empleado = new EmpleadoModel(get_object_vars($datos_empleado));
        $empleado = new EmpleadoModel($data_empleado);

        $modulos = json_decode($datos_empleado->getModulos());

        $empleado->save();
        $this->registerEmployeeModules($empleado, $modulos);
        $this->setEmployeeImage($datos_empleado->getFoto(), $empleado);
        $empleado->save();
        return $empleado;
    }

    private function registerEmployeeModules(EmpleadoModel $empleadoRef, $modules)
    {
        if (count($modules) > 0 && !is_null($empleadoRef)) {
            $empleadoRef->modules()->attach($modules);
        }
    }

    private function setEmployeeImage(UploadedFile $foto, EmpleadoModel $empleado)
    {
        // Make a image name based on user name and current timestamps
        // $name = Str::slug($empleado->cedula_ciudadania . $empleado->nombre);
        $name = $empleado->cedula_ciudadania . $empleado->nombre;
        // Define folder path under storage/app/public/uploads/images
        $folder = $empleado->cedula_ciudadania;
        // Make a file path where image will be stored [ folder path + file name + file extension]
        $file_name = $name . '.' . $foto->getClientOriginalExtension();
        $empleado->foto = $file_name;
        // Upload foto
        return $this->files_service->saveEmployeeFile($foto, $file_name, $folder);
    }
}
