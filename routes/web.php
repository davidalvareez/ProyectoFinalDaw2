<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApuntesController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\UsuarioController;
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
//Enlaces a paginas
Route::get('/', function () {
    return view('index');
});
Route::get('buscador',[ApuntesController::class,'buscador']);
//Provisional es para la vista login
Route::get('login',[UsuarioController::class,'loginView']);
Route::get('register',[UsuarioController::class,'registerView']);
//Procesos login + registro
Route::post('login',[UsuarioController::class,'login']);
Route::post('register',[UsuarioController::class,'register']);
//Logout
Route::get('logout',[UsuarioController::class,'logout']);
