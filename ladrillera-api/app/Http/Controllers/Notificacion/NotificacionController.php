<?php

namespace App\Http\Controllers\Notificacion;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Schemas\Requests\NotificacionRequest;
use Illuminate\Http\Request;
use Dotenv\Result\Success;
use App\Models\ModuloModel;
use App\Models\NotificacionModel;
use App\Models\NotificacionUsuarioModel;
use App\Models\UsuarioModel;
use App\Services\EventService;
use App\Services\NotificacionService;

class NotificacionController extends Controller
{
    private $notificacion_service;
    private $event_service;
    /**
     * Instantiate a new NotificacionController instance.
     */
    public function __construct(
        NotificacionService $notificacion_service,
        EventService $event_service
    ) {
        $this->notificacion_service = $notificacion_service;
        $this->event_service = $event_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $notificaciones = NotificacionModel::all();
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
        $notificacion_request = new NotificacionRequest();
        $notificacion_request->validateCreateRequest($request->all());
        $notificacion_request = NotificacionRequest::fromRequest($request);

        $notificacion = $this->notificacion_service->create($notificacion_request);
        $this->event_service->createEventoFromNotificacion($notificacion);

        return response()->json($notificacion, 201);
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
        $user = UsuarioModel::find($user_id)->first();
        return response()->json($user->notificaciones()->get());
    }

    public function send_notifications(Request $request)
    {

        $modules = $request->input('module_names');
        $notificacion = new NotificacionModel($request->except(['module_names']));
        $notificacion->save();

        if ($this->sendNotificationToModules($modules, $notificacion)) {
            return response()->json($notificacion, 200);
        }
        return response()->json(['msg' => "Ocurrio un error al enviar las notifiaciones"], 500);
    }

    public function sendNotificationToModules($modules, NotificacionModel $notificacion)
    {
        $success = false;
        $modulos = [];
        // Pushed every module model into a list to latter get every user
        foreach ($modules as $key => $value) {
            $temp_module = ModuloModel::where("nombre", '=', $value)->first();
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
