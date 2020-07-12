<?php

namespace App\Http\Controllers\Empleado;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Empleado as ModelEmpleado;
use App\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UploadTrait;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $empleados = ModelEmpleado::all();
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
        // Validate required parameters to create all the db tables needed for an Employee--------------------------------------------
        $normalPassword = Str::random(10);
        $rules = [
            "nombres" => "required|min:1",
            "apellidos" => "required|min:2|max:100",
            "cedula_ciudadania" => "required|digits:10",
            "genero" => "required|min:1",
            "fecha_nacimiento" => "required|date_format:Y-m-d",
            "rol" => "required|string",
            'foto' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            "email" => "required|string|email",
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // Fin validacion --------------------------------------------

        // Creacion de tablas de apoyo para ese nuevo empleado, la de user para auth y la usuario para 
        // gestion de datos de los usuarios
        $user = new User();
        $usuario = new Usuario();
        $this->createUserTables($request, $normalPassword, $user, $usuario);
        $datosEmpleado = $request->all();
        $datosEmpleado['correo'] = $datosEmpleado['email'];
        unset($datosEmpleado['email']);
        $datosEmpleado['nombre'] = $datosEmpleado['nombres'];
        unset($datosEmpleado['nombres']);
        $datosEmpleado['apellido'] = $datosEmpleado['apellidos'];
        unset($datosEmpleado['apellidos']);
        $empleado = new ModelEmpleado($datosEmpleado);
        $this->createEmpleado($request, $normalPassword, $usuario, $empleado);
        DB::commit();;
        return response()->json($empleado, 201);
    }

    private function createEmpleado($request, $normalPassword, $usuario, $empleado)
    {
        DB::beginTransaction();
        try {
            if ($request->has('foto')) {
                $image = $request->file('foto');
                // Make a image name based on user name and current timestamps
                $name = Str::slug($request->input('name')) . '_' . time();
                // Define folder path under storage/app/public/uploads/images
                $folder = '/uploads/images/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                // Upload image
                $this->uploadOne($image, $folder, 'public', $name);
                // Set user profile image path in database to filePath
                $empleado->foto = $filePath;
            }
            $empleado->save();
            $usuario->id_empleado = $empleado->id;
            $usuario->save();
            $mailController = new MailController();
            $mailController->sendConfirmEmail($empleado->nombre . " " . $empleado->apellido, $empleado->correo, $normalPassword);
            DB::commit();;
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();;
            $errorCode = $e->errorInfo[1];
            switch ($errorCode) {
                case 1062:
                    return response([
                        'errors' => 'Ya existe el recurso empleado', 'details' => $e->errorInfo
                    ], 409);
                    break;

                default:
                    break;
            }
        }
    }

    private function createUserTables($request, $normalPassword, $user, $usuario)
    {

        DB::beginTransaction();
        try {
            $user = new User([
                'name'     => $request->nombres,
                'email'    => $request->email,
                'password' => bcrypt($normalPassword),
            ]);
            $user->save();
            // Save to Usuario table
            $usuario = new Usuario([
                'nombre' => $request['name'],
                'correo' => $request['email'],
                'contraseña' => bcrypt($normalPassword),
                'auth_user_id' => $user->id,
            ]);
            $usuario->save();
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            switch ($errorCode) {
                case 1062:
                    return response([
                        'errors' => 'Ya existe el recurso Usuario', 'details' => $e->errorInfo
                    ], 409);
                    break;

                default:
                    break;
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empleado = ModelEmpleado::find($id);
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

        $empleado = ModelEmpleado::find($id);
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
        $empleado = ModelEmpleado::find($id);
        if (is_null($empleado)) {
            return response()->json(["msg" => $id . " no encontrado"], 404);
        }
        $empleado->delete();
        return response()->json(["msg" => $id . " Deleted"], 200);
    }


    public function modules(Request $request)
    {

        // $authUser = Auth::user();
        $authUser = $request->user();

        $usuario = Usuario::where('correo', $authUser->email)->first();
        $empleado = Empleado::where('id', $usuario->id_empleado)->first();
        $modules = $empleado->modules()->get();

        return response()->json(['modulos' => $modules], 200);
    }
}
