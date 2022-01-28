<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

/*Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/',[HomeController::class,'index']);

Route::get('/registrar',[HomeController::class,'registrar']);
Route::post('/registrar/getProvincias',[HomeController::class,'getProvincias']);
Route::post('/registrar/getDistritos',[HomeController::class,'getDistritos']);


Route::post('/registrar/verificar-dni',[HomeController::class,'verificarDNI']);
Route::post('/registrar/guardar',[HomeController::class,'guardar']);

