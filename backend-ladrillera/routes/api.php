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

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


// Api Routes with implicit route binding, using the api guard
Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'administracion', 'middleware' => ['module:administrador']], function () {
        // echo "Administracion perros";
        Route::resource('empleado', 'Empleado\EmpleadoController');
        Route::resource('usuario', 'Usuario\UsuarioController');
    });
    Route::group(['prefix' => 'ventas', 'middleware' => ['module:administrador']], function () {
        Route::resource('cliente', 'Cliente\ClienteController');
        Route::resource('pedido', 'Pedido\PedidoController');
    });
});
