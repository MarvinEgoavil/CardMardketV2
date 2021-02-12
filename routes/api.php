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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
// return $request->user();
// });

// Ruta para registrar ususario, logearse o recuperar contraseña , Acceso público

Route::post('/login', 'LoginController@login');
Route::post('/recovery', 'LoginController@recovery');
Route::post('/registerUser', 'UserController@store');
Route::get('/questExternal/{name}', 'GameCardController@externalQuest');

//Rutas protegidas por autenticacion, solamente un administrador puede entrar a la ruta

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/gameCard', 'GameCardController@store')->middleware('admin');
    Route::get('/collection', 'CollectionController@store')->middleware('admin');

    Route::post('/sale', 'SaleController@store')->middleware('Particular', 'Profesional');

    Route::get('/gameCard/{name}', 'GameCardController@show')->middleware('Particular', 'Profesional');
});
