<?php

namespace App\Services;

use App\Http\Schemas\Requests\ClienteRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


use App\Models\DocumentoModel;
use App\Models\EmpleadoModel;

use App\Services\UsuarioService;
use App\Services\UserService;

use App\Http\Schemas\Requests\EmpleadoRequest;
use App\Models\ClienteModel;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ClienteService
{


    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct()
    {
    }


    public function getAll()
    {
        return ClienteModel::with('empleado_asociado')->get();
    }

    public function getByUniqueColumn($column_name, $column_value)
    {
        return ClienteModel::where($column_name, $column_value)->firstOrFail();
    }

    public function createCliente(ClienteRequest $cliente_data, EmpleadoModel $empleado = NULL)
    {
        $data_cliente = [
            "id_empleado_asociado" => (is_null($empleado)) ? null : $empleado->id,
            "nombre" => $cliente_data->getNombre(),
            "apellido" => $cliente_data->getApellido(),
            "cc_nit" => $cliente_data->getCCNit(),
            "tipo_cliente" => $cliente_data->getTipoCliente(),
            "ciudad" => $cliente_data->getCiudad(),
            "correo" => $cliente_data->getCorreo(),
            "telefono" => $cliente_data->getTelefono(),
        ];

        $cliente = new ClienteModel($data_cliente);

        $cliente->save();
        return $cliente;
    }

    public function updateCliente(ClienteModel $to_update, ClienteRequest $cliente_data, EmpleadoModel $empleado = NULL)
    {
        $data_cliente = [
            "id_empleado_asociado" => (is_null($empleado)) ? null : $empleado->id,
            "nombre" => $cliente_data->getNombre(),
            "apellido" => $cliente_data->getApellido(),
            "cc_nit" => $cliente_data->getCCNit(),
            "tipo_cliente" => $cliente_data->getTipoCliente(),
            "ciudad" => $cliente_data->getCiudad(),
            "correo" => $cliente_data->getCorreo(),
            "telefono" => $cliente_data->getTelefono(),
        ];

        $to_update->id_empleado_asociado = $data_cliente['id_empleado_asociado'];
        $to_update->nombre = $data_cliente['nombre'];
        $to_update->apellido = $data_cliente['apellido'];
        $to_update->cc_nit = $data_cliente['cc_nit'];
        $to_update->tipo_cliente = $data_cliente['tipo_cliente'];
        $to_update->ciudad = $data_cliente['ciudad'];
        $to_update->correo = $data_cliente['correo'];
        $to_update->telefono = $data_cliente['telefono'];

        $to_update->save();
        return $to_update;
    }

    public function delete(ClienteModel $cliente)
    {
        $cliente->delete();
    }
}
