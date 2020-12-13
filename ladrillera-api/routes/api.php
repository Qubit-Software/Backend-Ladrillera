<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    // Log out and own information
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('users/me', 'AuthController@user');
    });
});


// Api Routes with implicit route binding, using the passport api guard
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('modulos', 'Empleado\EmpleadoController@modules');
    Route::get('notificaciones', 'Notificacion\NotificacionController@notificacion_usuario');
    Route::post('notificaciones', 'Notificacion\NotificacionController@send_notifications');

    // Solicitud cliente
    Route::apiResource('solicitud_clientes', 'SolicitudCliente\SolicitudClienteController');

    // Notificaciones
    Route::apiResource('notificaciones', 'Notificacion\NotificacionController');
    Route::apiResource('actualizaciones', 'ActualizacionController');

    // Administracion
    Route::group(['prefix' => 'administracion', 'middleware' => ['module:Administracion']], function () {
        Route::apiResource('empleados', 'Empleado\EmpleadoController');
        Route::apiResource('usuarios', 'Usuario\UsuarioController')->only([
            'index', 'show', "create", "store", "update"
        ]);
        Route::apiResource('modulos', 'Modulo\ModuloController')->only([
            'index', 'show', "create", "store", "update"
        ]);
    });

    Route::get('clientes/{cc_nit}', 'Cliente\ClienteController@showByCCNit');
    Route::apiResource('clientes', 'Cliente\ClienteController');

    //  Ventas
    Route::group(
        ['prefix' => 'ventas', 'middleware' => ['module:Ventas,Administracion']],
        function () {
            Route::get('pedidos/tipo/cronograma', 'Pedido\PedidoController@cronograma');
            Route::get('pedidos/tipo/fecha/{fecha}', 'Pedido\PedidoController@fecha');
            Route::apiResource('pedidos', 'Pedido\PedidoController');
        }
    );

    //  Contabilidad
    Route::group(['prefix' => 'contabilidad', 'middleware' => ['module:Contabilidad']], function () {
        Route::apiResource('clientes', 'Cliente\ClienteController');
        Route::apiResource('pedidos', 'Pedido\PedidoController');
    });

    //  Despacho
    Route::group(['prefix' => 'despachos', 'middleware' => ['module:Despacho']], function () {
        Route::apiResource('clientes', 'Cliente\ClienteController');
        Route::apiResource('pedidos', 'Pedido\PedidoController');
    });

    // Documentos
    Route::get('documentos/clientes/{cliente}',  'Documento\DocumentoController@showForClient');
    Route::get('documentos/clientes/{cliente}/zip',  'Documento\DocumentoController@showForClientInZip');
    Route::apiResource('documentos', 'Documento\DocumentoController');
});


Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info.ladrillera21@website.com'
    ], 404);
});
