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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->middleware('auth:api');


// Api Routes with implicit route binding, using the api guard
Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('administracion')->group(function () {
        // echo "Administracion perros";
        Route::resource('empleado', 'Empleado\EmpleadoController');
        Route::resource('usuario', 'Usuario\UsuarioController');
    });

    Route::prefix('ventas')->group(function () {
        Route::resource('cliente', 'Cliente\ClienteController');
        Route::resource('pedido', 'Pedido\PedidoController');
    });

    Route::prefix('contabilidad')->group(function () {
    });
});
