<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TransitoController;
use App\Http\Controllers\api\PredialController;

Route::get('/', function () {
   // return view('welcome');
   return view('vposttrans');//!Se modifico para que funcionara local 20211029
   
});

//!  return redirect('http://www.guadalupe.gob.mx');


Route::get('/test', 'TestController@dbTest');
Route::get('/test2', 'TestController@testDesc');
Route::get('/registrar', 'api\UserController@register');
//Route::post('/ppagomulta', 'api\TransitoController@procesaPago');
Route::post('/ppagomulta', [App\Http\Controllers\api\TransitoController::class, 'procesaPago']);
Route::post('predial/pago/pdf', 'api\PredialController@descargarpdf');
Route::get('/multas/consulta', 'api\TransitoController@consultarMultas');
Route::get('/multas', 'api\TransitoController@consultarMultas');
Route::get('/multas/forma', 'api\TransitoController@consultarForma');
//Route::post('/multas/buscar', 'api\TransitoController@consultarResultado');
//Route::post('/multas/buscar','api\TransitoController@consultarResultado');
Route::post('/multas/buscar', [App\Http\Controllers\api\TransitoController::class, 'consultarResultado']);
Route::post('/predial/buscar', 'api\PredialController@buscar');
Route::get('/predial', 'api\PredialController@consulta');
//Route::post('/predial/consulta', 'api\PredialController@cuenta');
Route::post('/predial/consulta', [App\Http\Controllers\api\PredialController::class, 'cuenta']);
Route::post('/predial/direccion', 'api\PredialController@direccion');
Route::post('/predial/imprimir', 'api\PredialController@cuenta_pdf');
//Route::post('/predial/paynet', 'api\PredialPDF@paynet');
Route::post('/predial/paynet', [App\Http\Controllers\api\PredialPDF::class, 'paynet']);

Route::post('/predial/oxxo', 'api\PredialPDF@oxxo');
Route::post('/predial/azteca', 'api\PredialPDF@azteca');


Route::post('/presupuestos/usuarios_actualizarcuentas', 'api\PresupuestosController@usuarios_actualizarcuentas');
Route::any('/presupuestos/actualizarcuentas', 'api\PresupuestosController@actualizarcuentas');
Route::post('/presupuestos/actualizarsubcuentas', 'api\PresupuestosController@actualizarsubcuentas');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/predcons', function () {
    return view('predial_consulta');
});

Route::get('/transcons', function () {
    return view('transito_consulta');
});

Route::get('/vpostpred', function () {
    return view('vpostpred');
});

Route::get('/defaultb21', [App\Http\Controllers\api\DefaultbController::class, 'fdefaultb']);

Route::get('/dv97m', [App\Http\Controllers\api\Dv97mController::class, 'fpaso0']);
