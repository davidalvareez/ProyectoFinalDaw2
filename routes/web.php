<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApuntesController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CRUDAdminController;
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

//Procesos Login // Registro // LogOut
Route::post('login',[UsuarioController::class,'login']);

Route::post('register',[UsuarioController::class,'register']);

Route::get('login',[UsuarioController::class,'loginView']);

Route::get('register',[UsuarioController::class,'registerView']);

Route::get('logout',[UsuarioController::class,'logout']);


//CRUD
Route::get('admin',[CRUDAdminController::class,'adminView']);

Route::post('admin/users',[CRUDAdminController::class,'showUsers']);

Route::post('admin/centros',[CRUDAdminController::class,'showCentros']);

Route::get('admin/cursos/{id}',[CRUDAdminController::class,'showCursos']);

Route::get('admin/asignaturas/{id}',[CRUDAdminController::class,'showAsignaturas']);

Route::get('admin/temas/{id}',[CRUDAdminController::class,'showTemas']);

Route::post('admin/apuntes',[CRUDAdminController::class,'showApuntes']);

Route::post('admin/denuncias',[CRUDAdminController::class,'showDenuncias']);

Route::post('admin/historial',[CRUDAdminController::class,'showHistorial']);

//Mostrar


//Crear


//Actualizar


//Eliminar


//Mapas