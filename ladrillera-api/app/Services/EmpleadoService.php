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


    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(FilesService $files_service)
    {
        $this->files_service = $files_service;
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


    public function updateEmpleado(EmpleadoModel $empleado_to_update, EmpleadoRequest $request_data)
    {
        $data_empleado = [
            "nombre" => $request_data->getNombre(),
            "apellido" => $request_data->getApellido(),
            "cedula_ciudadania" => $request_data->getCedulaCiudadania(),
            "genero" => $request_data->getGenero(),
            "fecha_nacimiento" => $request_data->getFechaNacimiento(),
            "rol" => $request_data->getRol()
        ];

        $empleado_to_update->update($data_empleado);

        $modulos = json_decode($request_data->getModulos());

        $empleado_to_update->save();
        $this->registerEmployeeModules($empleado_to_update, $modulos);
        $this->setEmployeeImage($request_data->getFoto(), $empleado_to_update);
        $empleado_to_update->save();
        return $empleado_to_update;
    }

    private function getId($module)
    {
        return $module->id;
    }

    private function registerEmployeeModules(EmpleadoModel $empleado_ref, $modules)
    {
        if (count($modules) > 0 && !is_null($empleado_ref)) {
            $existing = array_map(array($this, 'getId'), iterator_to_array($empleado_ref->modules()->get()));
            $new_ids = array_diff($modules, $existing);
            $empleado_ref->modules()->attach($new_ids);
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
