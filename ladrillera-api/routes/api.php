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
        Route::get('user', 'AuthController@user');
    });
});


// Api Routes with implicit route binding, using the passport api guard
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user_modules', 'Empleado\EmpleadoController@modules');
    Route::get('notificacion_usuario', 'Notificacion\NotificacionController@notificacion_usuario');
    Route::post('send_notifications', 'Notificacion\NotificacionController@send_notifications');

    Route::apiResource('notificacion', 'Notificacion\NotificacionController');

    Route::group(['prefix' => 'administracion', 'middleware' => ['module:administracion']], function () {
        Route::apiResource('empleado', 'Empleado\EmpleadoController');
        Route::apiResource('usuario', 'Usuario\UsuarioController')->only([
            'index', 'show', "create", "store", "update"
        ]);
        Route::apiResource('modulo', 'Modulo\ModuloController')->only([
            'index', 'show', "create", "store", "update"
        ]);
    });
    Route::group(['prefix' => 'ventas', 'middleware' => ['module:ventas']], function () {
        Route::apiResource('cliente', 'Cliente\ClienteController');
        Route::apiResource('pedido', 'Pedido\PedidoController');
    });
    Route::group(['prefix' => 'contabilidad', 'middleware' => ['module:contabilidad']], function () {
        Route::apiResource('cliente', 'Cliente\ClienteController');
        Route::apiResource('pedido', 'Pedido\PedidoController');
    });
    Route::group(['prefix' => 'despacho', 'middleware' => ['module:despacho']], function () {
        Route::apiResource('cliente', 'Cliente\ClienteController');
        Route::apiResource('pedido', 'Pedido\PedidoController');
    });
});
