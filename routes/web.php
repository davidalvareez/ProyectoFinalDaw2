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
//Indice
Route::get('/', function () {
    return view('index');
});
//About us
Route::get('aboutus', function () {
    return view('aboutus');
});
Route::get('buscador',[ApuntesController::class,'buscador']);

//Procesos Login // Registro // LogOut
Route::post('login',[UsuarioController::class,'login']);

Route::post('register',[UsuarioController::class,'register']);

Route::get('login',[UsuarioController::class,'loginView']);

Route::get('register',[UsuarioController::class,'registerView']);

Route::get('logout',[UsuarioController::class,'logout']);

//Pagina de perfil
Route::get('perfil/{nick_usu}',[UsuarioController::class,'perfil']);

//Pagina de apuntes
//Mis apuntes
Route::get('misApuntes',[ApuntesController::class,'misApuntes']);

Route::post('misApuntes/curso',[ApuntesController::class,'misApuntes_curso']);

Route::post('misApuntes/asignatura',[ApuntesController::class,'misApuntes_asignatura']);

Route::post('misApuntes/subirapunte',[ApuntesController::class,'misApuntes_subirapunte']);

Route::post('misApuntes/apuntes',[ApuntesController::class,'misApuntes_apuntes']);

Route::delete('misApuntes/eliminarapunte/{id}',[ApuntesController::class,'misApuntes_eliminarapunte']);

//Apunte
Route::get('apuntes/{id}',[ApuntesController::class,'apuntes']);
Route::post('apuntes/comentar',[ApuntesController::class,'comentar']);
Route::post('download',[ApuntesController::class,'download']);
//FILTROS

//Pagina buscador, busqueda multiple_of
Route::post('buscador/multiplyfilter',[ApuntesController::class,'multiplyFilter']);

Route::post('buscador/busquedaAvanzada',[ApuntesController::class,'busquedaAvanzada']);

Route::post('buscador/busquedaAvanzada/centro',[ApuntesController::class,'busquedaAvanzadaCentro']);

Route::post('buscador/busquedaAvanzada/curso',[ApuntesController::class,'busquedaAvanzadaCurso']);

//CRUD ADMIN
//Mostrar
Route::get('admin',[CRUDAdminController::class,'adminView']);

Route::post('admin/users',[CRUDAdminController::class,'showUsers']);

Route::post('admin/centros',[CRUDAdminController::class,'showCentros']);

Route::get('admin/cursos/{id}',[CRUDAdminController::class,'showCursos']);

Route::get('admin/asignaturas/{id}',[CRUDAdminController::class,'showAsignaturas']);

Route::get('admin/temas/{id}',[CRUDAdminController::class,'showTemas']);

Route::post('admin/apuntes',[CRUDAdminController::class,'showApuntes']);

Route::post('admin/denuncias',[CRUDAdminController::class,'showDenuncias']);

Route::post('admin/historial',[CRUDAdminController::class,'showHistorial']);

//Eliminar
Route::delete('admin/users/{id}',[CRUDAdminController::class,'eliminarUser']);

Route::delete('admin/apuntes/{id}',[CRUDAdminController::class,'eliminarApunte']);

Route::delete('admin/denuncias/{id}',[CRUDAdminController::class,'eliminarDenuncia']);

Route::delete('admin/historial/{id}',[CRUDAdminController::class,'eliminarHistorial']);

Route::delete('admin/cursos/{id}',[CRUDAdminController::class,'eliminarCurso']);

Route::delete('admin/asignaturas/{id}',[CRUDAdminController::class,'eliminarAsignatura']);

Route::delete('admin/temas/{id}',[CRUDAdminController::class,'eliminarTema']);

//Mostrar
Route::get('moderador',[UsuarioController::class,'moderadorView']);

//Crear


//Actualizar
Route::put('admin/centro',[CRUDAdminController::class,'actualizarCentro']);

Route::put('admin/curso',[CRUDAdminController::class,'actualizarCurso']);

Route::put('admin/asignatura',[CRUDAdminController::class,'actualizarAsignatura']);

Route::put('admin/tema',[CRUDAdminController::class,'actualizarTema']);

Route::put('admin/user',[CRUDAdminController::class,'actualizarUsuario']);

//Mapas