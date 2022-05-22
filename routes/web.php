<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApuntesController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CRUDAdminController;
use App\Http\Controllers\moderadorController;
use App\Http\Controllers\ChatController;
use App\Http\Livewire\ChatWith;
use App\Http\Livewire\Contacts;

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

//TERMINOS Y CONDICIONES
    Route::get('terminos', function () {
        return view('terminos');
    });

//POLITICA DE PRIVACIDAD
    Route::get('privacidad', function () {
        return view('privacidad');
    });
//VALIDAR CORREO REGISTRO
    Route::get('validarcorreo', function () {
        return view('validarcorreo');
    });

    Route::post('validarCorreoUser', [UsuarioController::class,'validarUsuario']);

//VALIDAR CAMBIO CONTRASEÑA
    Route::get('cambiarPass',[UsuarioController::class,'validarContraseñaView']);

    Route::post('mailcambiarPass',[UsuarioController::class,'MAILvalidarContraseña']);

    Route::post('restablecerContraUser',[UsuarioController::class,'validarCambioContraseña']);

//Indice
    Route::get('/', function () {
        return view('index');
    });

//About us
    Route::get('about-us', function () {
        return view('aboutus');
    });

//Procesos Login // Registro // LogOut
    Route::post('login',[UsuarioController::class,'login']);

    Route::post('register',[UsuarioController::class,'register']);

    Route::post('registerProfe',[UsuarioController::class,'registerProfe']);

    Route::get('login',[UsuarioController::class,'loginView']);

    Route::get('register',[UsuarioController::class,'registerView']);

    Route::get('logout',[UsuarioController::class,'logout']);

//Pagina de perfil
    Route::get('perfil/{nick_usu}',[UsuarioController::class,'perfil']);

    Route::post('perfil/actualizar',[UsuarioController::class,'ActualizarPerfil']);

    Route::put('perfil/actualizarPUT',[UsuarioController::class,'ActualizarPerfilPut']);

    Route::post('perfil/getConfigUser',[UsuarioController::class,'getConfigUser']);

    Route::post('perfil/changeConfigUser',[UsuarioController::class,'changeConfigUser']);

    Route::put('perfil/actualizarAvatar',[UsuarioController::class,'actualizarAvatar']);

    Route::delete('perfil/darseDeBaja',[UsuarioController::class,'DarseDeBaja']);

    Route::post('perfil/uploadCV',[UsuarioController::class,'uploadCV']);

    Route::post('perfil/showStudies',[UsuarioController::class,'showStudies']);

    Route::post('perfil/addStudies',[UsuarioController::class,'addStudies']);

    Route::delete('perfil/deleteStudies',[UsuarioController::class,'deleteStudies']);

//Mis apuntes
    Route::get('mis-apuntes',[ApuntesController::class,'misApuntes']);

    Route::post('mis-apuntes/centro',[ApuntesController::class,'misApuntes_centro']);

    Route::post('mis-apuntes/curso',[ApuntesController::class,'misApuntes_curso']);

    Route::post('mis-apuntes/asignatura',[ApuntesController::class,'misApuntes_asignatura']);

    Route::post('mis-apuntes/subirapunte',[ApuntesController::class,'misApuntes_subirapunte']);

    Route::post('mis-apuntes/apuntes',[ApuntesController::class,'misApuntes_apuntes']);

    Route::delete('mis-apuntes/eliminarapunte/{id}',[ApuntesController::class,'misApuntes_eliminarapunte']);

//Apunte
    Route::get('apuntes/{id}',[ApuntesController::class,'apuntes']);

    Route::post('apuntes/comentar',[ApuntesController::class,'comentar']);

    Route::post('apuntes/denunciarComentario',[ApuntesController::class,'denunciarComentario']);

    Route::post('apuntes/denunciarApunte',[ApuntesController::class,'denunciarApunte']);

    Route::post('download',[ApuntesController::class,'download']);

//FILTROS

//Pagina buscador, busqueda multiple_of

    Route::get('buscador',[ApuntesController::class,'buscador']);

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

    Route::delete('admin/historial/{id}',[CRUDAdminController::class,'eliminarHistorial']);

    Route::delete('admin/centro/{id}',[CRUDAdminController::class,'eliminarCentro']);

    Route::delete('admin/cursos/{id}',[CRUDAdminController::class,'eliminarCurso']);

    Route::delete('admin/asignaturas/{id}',[CRUDAdminController::class,'eliminarAsignatura']);

    Route::delete('admin/temas/{id}',[CRUDAdminController::class,'eliminarTema']);

//Mostrar

//Crear
    Route::post('admin/crearcentro',[CRUDAdminController::class,'crearCentro']);

    Route::post('admin/crearcurso',[CRUDAdminController::class,'crearCurso']);

    Route::post('admin/crearasignatura',[CRUDAdminController::class,'crearAsignatura']);

    Route::post('admin/creartema',[CRUDAdminController::class,'crearTema']);

//Actualizar
    Route::put('admin/centro',[CRUDAdminController::class,'actualizarCentro']);

    Route::put('admin/curso',[CRUDAdminController::class,'actualizarCurso']);

    Route::put('admin/asignatura',[CRUDAdminController::class,'actualizarAsignatura']);

    Route::put('admin/tema',[CRUDAdminController::class,'actualizarTema']);

    Route::put('admin/user',[CRUDAdminController::class,'actualizarUsuario']);

//OAUTH
    Route::get('login-google',[OAuthController::class,'login_google']);

    Route::get('google-callback',[OAuthController::class,'google_callback']);

    Route::get('login-facebook',[OAuthController::class,'login_facebook']);

    Route::get('facebook-callback',[OAuthController::class,'facebook_callback']);

    Route::get('login-twitter',[OAuthController::class,'login_twitter']);

    Route::get('twitter-callback',[OAuthController::class,'twitter_callback']);

    Route::get('oauth-register',[OAuthController::class,'oauthViewRegisterAlumno']);

    Route::post('oauth-register-alumno',[OAuthController::class,'oauthRegisterAlumno']);

    Route::post('oauth-register-profesor',[OAuthController::class,'oauthRegisterProfesor']);

//Profesores
    Route::get('profesores',[UsuarioController::class,'MostrarProfesores']);

    Route::post('profesores/multiplyfilter',[UsuarioController::class,'multiplyFilterProfesores']);

    Route::post('profesores/advancedfilter',[UsuarioController::class,'advancedFilterProfesores']);

    Route::post('profesores/mostrarEstudios/{id}',[UsuarioController::class,'mostrarEstudios']);

    Route::post('profesores/mostrarCurriculum/{id}',[UsuarioController::class,'mostrarCurriculum']);

//Moderador
//Mostrar
    Route::get('moderador',[moderadorController::class,'moderadorView']);

    Route::post('moderador/denuncias',[moderadorController::class,'moderadorDenuncias']);

    Route::post('moderador/comments',[moderadorController::class,'moderadorComments']);

    Route::post('moderador/notes',[moderadorController::class,'moderadorNotes']);

//Eliminar
    Route::delete('moderador/eliminar',[moderadorController::class,'eliminarDenuncia']);

    Route::delete('moderador/eliminarcontent',[moderadorController::class,'eliminarContenido']);

    Route::delete('moderador/banearUser',[moderadorController::class,'banearUsuario']);

    Route::delete('moderador/quitardenuncia',[moderadorController::class,'quitardenuncia']);

/*CHAT PRUEBA*/
    Route::get('notehub-chat',Contacts::class)->name('contacts');

    Route::get('notehub-chat/{uuid}',ChatWith::class)->name('chat_with');

    Route::post('notehub-chat/deleteChat',[ChatController::class,'deleteChat']);