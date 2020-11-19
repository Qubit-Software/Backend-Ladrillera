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

    // Notificaciones
    Route::apiResource('notificaciones', 'Notificacion\NotificacionController');

    // Administracion
    Route::group(['prefix' => 'administracion', 'middleware' => ['module:administracion']], function () {
        Route::apiResource('empleados', 'Empleado\EmpleadoController');
        Route::apiResource('usuarios', 'Usuario\UsuarioController')->only([
            'index', 'show', "create", "store", "update"
        ]);
        Route::apiResource('modulos', 'Modulo\ModuloController')->only([
            'index', 'show', "create", "store", "update"
        ]);
    });
    

    //  Ventas
    Route::group(['prefix' => 'ventas', 'middleware' => ['module:ventas']], function () {
        Route::apiResource('clientes', 'Cliente\ClienteController');
        Route::apiResource('pedidos', 'Pedido\PedidoController');
    });

    //  Contabilidad
    Route::group(['prefix' => 'contabilidad', 'middleware' => ['module:contabilidad']], function () {
        Route::apiResource('clientes', 'Cliente\ClienteController');
        Route::apiResource('pedidos', 'Pedido\PedidoController');
    });

    //  Despacho
    Route::group(['prefix' => 'despachos', 'middleware' => ['module:despacho']], function () {
        Route::apiResource('clientes', 'Cliente\ClienteController');
        Route::apiResource('pedidos', 'Pedido\PedidoController');
    });

    // Documentos
    Route::group(['prefix' => 'documentos'], function () {
        Route::apiResource('/', 'Documento\DocumentoController');
    });
});


Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});