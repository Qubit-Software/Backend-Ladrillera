<?php

namespace App\Http\Controllers\Empleado;

use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\UsuarioModel;
use App\Models\EmpleadoModel;
use App\Services\UserService;
use App\Services\UsuarioService;
use App\Services\EmpleadoService;

use App\Http\Schemas\Requests\EmpleadoRequest;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class EmpleadoController extends Controller
{
    use UploadTrait;

    private $empleado_service;
    private $user_service;
    private $usuario_service;
    private $email_service;

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(
        EmpleadoService $empleado_service,
        UserService $user_service,
        UsuarioService $usuario_service,
        EmailService $email_service
    ) {
        $this->empleado_service = $empleado_service;
        $this->user_service = $user_service;
        $this->usuario_service = $usuario_service;
        $this->empleado_service = $empleado_service;
        $this->email_service = $email_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $empleados = $this->empleado_service->getAll();
        return response()->json($empleados, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate required parameters to create all the db tables needed for an Employee--------------------------------------------
            $empleado_request = new EmpleadoRequest();
            $empleado_request->validateRequest($request);

            $empleado_request = EmpleadoRequest::from_request($request);
            $empleado_request->setRandomPassword();


            // Creacion de tablas de apoyo para ese nuevo empleado, la de user para auth y la usuario para 
            // gestion de datos de los usuarios
            $new_user = $this->user_service->createUser(
                $empleado_request->getNombre(),
                $empleado_request->getEmail(),
                $empleado_request->getRandomPassword()
            );

            $new_usuario = $this->usuario_service->createUsuario(
                $new_user,
                $empleado_request->getRandomPassword()
            );

            $new_empleado = $this->empleado_service->createEmpleado(
                $empleado_request,
                $new_usuario
            );
            $this->email_service->sendConfirmationEmail(
                $new_empleado->nombre,
                $new_usuario->correo,
                $empleado_request->getRandomPassword()
            );

            DB::commit();
            return response()->json($new_empleado, 201);
        } catch (ValidationException $ve) {
            DB::rollback();
            throw $ve;
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Error al crear empleado ' . $th);
            throw $th;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empleado = EmpleadoModel::find($id);
        if (is_null($empleado)) {
            return response()->json(['message' => "No se encontro el Empleado"]);
        }
        return response()->json($empleado, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "nombres" => "required|min:1",
            "apellidos" => "required|min:2|max:100",
            "cedula_ciudadania" => "required|digits:10",
            "genero" => "required|min:1",
            "fecha_nacimiento" => "required|date",
            "rol" => "required|string",
            "correo" => "required|string|email|unique:empleados",
            "contraseña" => "required|string",
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $empleado = EmpleadoModel::find($id);
        if (is_null($empleado)) {
            return response()->json(["msg" => $id . " Empleado no encontrado"], 404);
        }
        $empleado->update($request->all());
        return response()->json($empleado, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado = EmpleadoModel::find($id);
        if (is_null($empleado)) {
            return response()->json(["msg" => $id . " no encontrado"], 404);
        }
        $empleado->delete();
        return response()->json(["msg" => $id . " Deleted"], 200);
    }


    public function modules(Request $request)
    {
        $authUser = $request->user();

        $usuario = UsuarioModel::where('correo', $authUser->email)->first();
        $empleado = EmpleadoModel::where('id_usuario', $usuario->id)->first();
        $modules = $empleado->modules()->get();

        return response()->json(['modulos' => $modules], 200);
    }
}
