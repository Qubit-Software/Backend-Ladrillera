<?php

namespace App\Http\Controllers\Notificacion;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Models\Notificacion;
use App\Models\Usuario;
use App\Models\NotificacionUsuario;
use Dotenv\Result\Success;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $notificaciones = Notificacion::all();
        return response()->json($notificaciones, 200);
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

        $rules = [
            "user_id" => "required|min:1",
            "titulo" => "required|string|min:10",
            "body" => "required|string|min:10",
            "router" => "required|string",
            "alcance" => "required|string",
            "priodirdad" => "required|min:1"
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $notificacion = new Notificacion($request->except(['user_id']));
        $notificacion->save();

        $user = Usuario::find($request->input("user_id"));
        $user->notificaciones()->attach([$notificacion->id]);
        return response()->json(['msg' => "Se creara una notifiacion para el usuario " . $user->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function notificacion_usuario(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = Usuario::find($user_id)->first();
        return response()->json($user->notificaciones()->get());
    }

    public function send_notifications(Request $request)
    {

        $modules = $request->input('module_names');
        $notificacion = new Notificacion($request->except(['module_names']));
        $notificacion->save();

        if ($this->sendNotificationToModules($modules, $notificacion)) {
            return response()->json($notificacion, 200);
        }
        return response()->json(['msg' => "Ocurrio un error al enviar las notifiaciones"], 500);
    }

    public function sendNotificationToModules($modules, Notificacion $notificacion)
    {
        $success = false;
        $modulos = [];
        // Pushed every module model into a list to latter get every user
        foreach ($modules as $key => $value) {
            $temp_module = Modulo::where("nombre", '=', $value)->first();
            if (!is_null($temp_module)) {
                array_push($modulos, $temp_module);
            }
        }
        // echo "Cantidad " . count($modulos);
        // Gets all the employees asociated with a module
        $empleados = [];
        foreach ($modulos as $key => $modulo) {
            array_push($empleados, ...$modulo->empleados()->get());
        }

        // Gets an array of unique employees and attach to them the notification
        $empleados = array_unique($empleados);
        $success = count($empleados) > 0;
        foreach ($empleados as $key => $empleado) {
            $empleado->notificaciones()->attach([$notificacion->id]);
        }

        return $success;
    }
}
