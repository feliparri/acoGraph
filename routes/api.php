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

// apis recepcion
Route::middleware('auth:api')->post('/getResumenLote','ControllerReports@getResumenLote');
Route::middleware('auth:api')->post('/getPieChartData','ControllerReports@getPieChartData');
Route::middleware('auth:api')->post('/getPieChartDataByCodVariedad','ControllerReports@getPieChartDataByCodVariedad');
Route::middleware('auth:api')->post('/getPieChartDataByCodVariedadInv','ControllerReports@getPieChartDataByCodVariedadInv');
Route::middleware('auth:api')->post('/getPieChartDataByCodVariedadGrpProductor','ControllerReports@getPieChartDataByCodVariedadGrpProductor');
Route::middleware('auth:api')->post('/getPieChartDataByCodVariedadInvGrpProductor','ControllerReports@getPieChartDataByCodVariedadInvGrpProductor');
Route::middleware('auth:api')->post('/getPieChartDataByPesoMes','ControllerReports@getPieChartDataByPesoMes');
Route::middleware('auth:api')->post('/getDataCosolidadoProcesosByFilters','ControllerReports@getDataCosolidadoProcesosByFilters');
Route::middleware('auth:api')->post('/getVariedades','ControllerReports@getVariedades');
Route::middleware('auth:api')->post('/getProductores','ControllerReports@getProductores');

//apis procesos
Route::middleware('auth:api')->post('/getResumenProcesos','ControllerProcesos@getResumenProcesos');
Route::middleware('auth:api')->post('/getReporteProcesos','ControllerProcesos@getReporteProcesos');
Route::middleware('auth:api')->post('/getChartProcesosRendimiento','ControllerProcesos@getChartProcesosRendimiento');


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
