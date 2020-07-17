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

Route::post('/login','AuthController@login');
Route::post('/register','AuthController@register');
Route::middleware('auth:api')->post('/logout','AuthController@logout');

Route::middleware('auth:api')->post('/getResumenLote','ControllerReports@getResumenLote');
//Route::get('/getResumenLote','ControllerReports@getResumenLote');


//test foo
Route::get('foo', function () {
    return 'Hello World';
});

//basic route
#users
Route::get('/users', 'UsersController@index');
#productos
Route::get('/products', 'ProductsController@index');
