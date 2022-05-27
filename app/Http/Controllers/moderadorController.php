<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\MAIL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\sendMail;
class moderadorController extends Controller
{
    //Moderador
        //Mostrar
            public function moderadorView(){
                if (session()->get('user')) {
                    $moderador = DB::select("SELECT * FROM (SELECT tbl_denuncias.*,CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'demandante',tbl_usuario.nick_usu as 'nick_demandante' FROM tbl_denuncias
                    LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_demandante
                    LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                    LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario) denuncia1
                    INNER JOIN (
                        SELECT tbl_denuncias.id as 'id_denuncia',CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'acusado',tbl_usuario.nick_usu as 'nick_acusado' FROM tbl_denuncias 
                        LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_acusado
                        LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                        LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
                    )denuncia2 on denuncia2.id_denuncia=denuncia1.id");
                    return view('moderadorView', compact('moderador'));
                }else{
                    return redirect('/');
                }
            }
            public function moderadorDenuncias(){
                $denuncias = DB::select("SELECT * FROM (SELECT tbl_denuncias.*,CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'demandante',tbl_usuario.nick_usu as 'nick_demandante' FROM tbl_denuncias
                LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_demandante
                LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario) denuncia1
                INNER JOIN (
                    SELECT tbl_denuncias.id as 'id_denuncia',CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'acusado',tbl_usuario.nick_usu as 'nick_acusado' FROM tbl_denuncias 
                    LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_acusado
                    LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                    LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
                )denuncia2 on denuncia2.id_denuncia=denuncia1.id");
                return response()->json($denuncias);
            }
            public function moderadorComments(){
                $comentarios = DB::select("SELECT * FROM (SELECT tbl_denuncias.*,CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'demandante',tbl_usuario.nick_usu as 'nick_demandante' FROM tbl_denuncias
                LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_demandante
                LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
                WHERE tbl_denuncias.tipus_denuncia = ?) denuncia1
                INNER JOIN (
                    SELECT tbl_denuncias.id as 'id_denuncia',CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'acusado',tbl_usuario.nick_usu as 'nick_acusado' FROM tbl_denuncias 
                    LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_acusado
                    LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                    LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
                    WHERE tbl_denuncias.tipus_denuncia = ?
                )denuncia2 on denuncia2.id_denuncia=denuncia1.id;",["comentario","comentario"]);
                return response()->json($comentarios);
            }
            public function moderadorNotes(){
                $apuntes = DB::select("SELECT * FROM (SELECT tbl_denuncias.*,CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'demandante', tbl_usuario.nick_usu as 'nick_demandante' FROM tbl_denuncias
                LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_demandante
                LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
                WHERE tbl_denuncias.tipus_denuncia = ?) denuncia1
                INNER JOIN (
                    SELECT tbl_denuncias.id as 'id_denuncia',CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'acusado',tbl_usuario.nick_usu as 'nick_acusado' FROM tbl_denuncias 
                    LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_acusado
                    LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                    LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
                    WHERE tbl_denuncias.tipus_denuncia = ?
                )denuncia2 on denuncia2.id_denuncia=denuncia1.id",["Apunte","Apunte"]);
                return response()->json($apuntes);
            }
        //Eliminar denuncia
            public function eliminarDenuncia(Request $request){
                $datos = $request->except('_token','_method');
                try {
                    $datosDenuncia = DB::select("SELECT * FROM tbl_denuncias WHERE id = ?",[$datos["id_denuncia"]]);
                    $datosDemandante = DB::select("SELECT * FROM tbl_usuario WHERE nick_usu = ?",[$datos["nick_usu"]]);
                    $datosDenuncia = $datosDenuncia[0];
                    $datosDemandante = $datosDemandante[0];
                    $nombreApellido = $datosDemandante->nombre_usu." ".$datosDemandante->apellido_usu;
                    if ($datosDenuncia->tipus_denuncia == "Comentario") {
                        $sub = "Denuncia comentario denegado";
                        $msj = "Estimado/a $nombreApellido nuestro departamento ha recibido la denuncia propuesta hacia dicho comentario.
                        Queremos sostener mediante un análisis detallado del problema que no va a poder llevarse a cabo por lo que no vamos a realizar ninguna acción sobre dicho comentario. 
                        Un cordial saludo, el equipo de Note Hub";
                    }elseif ($datosDenuncia->tipus_denuncia == "Apunte"){
                        $sub = "Denuncia apunte denegado";
                        $msj = "Estimado/a $nombreApellido nuestro departamento ha recibido la denuncia propuesta hacia dicho apunte.
                        Queremos sostener mediante un análisis detallado del problema que no va a poder llevarse a cabo por lo que no vamos a realizar ninguna acción sobre dicho documento. 
                        Un cordial saludo, el equipo de Note Hub";
                    }
                    $datos = array('message'=>$msj);
                    $enviar = new sendMail($datos);
                    $enviar->sub = $sub;
                    Mail::to($datosDemandante->correo_usu)->send($enviar);
                    DB::delete("DELETE FROM tbl_denuncias WHERE id = ?",[$datosDenuncia->id]);
                    return response()->json(array("resultado" => "OK"));   
                } catch (\Exception $e) {
                    return response()->json(array("resultado" => "NOK: ".$e->getMessage()));  
                }
            }
            public function eliminarContenido(Request $request) {
                $datos = $request->except("_token","_method");
                try {
                    $datosDenuncia = DB::select("SELECT * FROM tbl_denuncias WHERE id = ?",[$datos["id_denuncia"]]);
                    $datosAcusado = DB::select("SELECT * FROM tbl_usuario WHERE nick_usu = ?",[$datos["nick_usu"]]);
                    $datosDenuncia = $datosDenuncia[0];
                    $datosAcusado = $datosAcusado[0];
                    $nombreApellido = $datosAcusado->nombre_usu." ".$datosAcusado->apellido_usu;
                    //Si la denuncia es un comentario eliminamos el comentario
                    if ($datosDenuncia->tipus_denuncia == "Comentario") {
                        try {
                            DB::beginTransaction();
                            $sub = "Comentario eliminado";
                            $msj = "Querido/a $nombreApellido nuestro departamento responde a su demanda hacia el comentario, reprendiendo las acciones necesarias para mejorar la plataforma y el correcto funcionamiento de esta. 
                            Se censurará dicho contenido junto con una amonestación al usuario. 
                            El equipo de Note Hub le desea un cordial saludo.";
                            DB::delete("DELETE FROM tbl_denuncias WHERE id = ?",[$datosDenuncia->id]);
                            DB::delete("DELETE FROM tbl_comentarios WHERE id = ?",[$datosDenuncia->id_comentario]);
                            $datos = array('message'=>$msj);
                            $enviar = new sendMail($datos);
                            $enviar->sub = $sub;
                            Mail::to($datosAcusado->correo_usu)->send($enviar);
                            //Mail::to($datosAcusado->correo_usu)->send($enviar);
                            DB::commit();
                            return response()->json(array('resultado' => "OK"));
                        } catch (\Exception $e) {
                            DB::rollback();
                            return response()->json(array('resultado' => "NOK: ".$e->getMessage()));
                        }
                    //Si es un apunte borramos el apunte el historial que hay en el y la denuncia y borramos el apunte del storage para hacer limpieza en el servidor
                    }elseif ($datosDenuncia->tipus_denuncia == "Apunte"){
                        try {
                            DB::beginTransaction();
                            $sub = "Contenido eliminado";
                            $msj = "Querido/a $nombreApellido nuestro departamento responde a su demanda hacia el documento, reprendiendo las acciones necesarias para mejorar la plataforma y el correcto funcionamiento de esta. 
                            Se censurará dicho contenido junto con una amonestación al usuario. 
                            El equipo de Note Hub le desea un cordial saludo.";
                            $exitDenuncia =DB::select("SELECT * FROM tbl_denuncias WHERE id_contenido = ?",[$datosDenuncia->id_contenido]);
                            if (count($exitDenuncia) != 0) {
                                DB::delete("DELETE FROM tbl_denuncias WHERE id_contenido = ?",[$datosDenuncia->id_contenido]);
                            }
                            $existComment = DB::SELECT("SELECT * FROM tbl_comentarios WHERE id_contenido = ?",[$datosDenuncia->id_contenido]);
                            if (count($existComment) != 0) {
                                DB::delete("DELETE FROM tbl_comentarios WHERE id_contenido = ?",[$datosDenuncia->id_contenido]);
                            }
                            $existMultimedia = DB::select("SELECT * FROM tbl_multimedia WHERE id = ?",[$datosDenuncia->id_contenido]);
                            if (count($existMultimedia) != 0) {
                                DB::delete("DELETE FROM tbl_multimedia WHERE id = ?",[$datosDenuncia->id_contenido]);
                            }
                            $existHistorial = DB::select("SELECT * FROM tbl_historial WHERE id_contenido = ?",[$datosDenuncia->id_contenido]);
                            if (count($existHistorial) != 0) {
                                DB::delete("DELETE FROM tbl_historial WHERE id_contenido = ?",[$datosDenuncia->id_contenido]);
                            }
                            $apunte = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.nombre_tema FROM tbl_centro centro 
                            RIGHT JOIN tbl_cursos curso ON centro.id = curso.id_centro 
                            RIGHT JOIN tbl_asignaturas asig ON asig.id_curso = curso.id 
                            RIGHT JOIN tbl_temas temas ON temas.id_asignatura = asig.id 
                            RIGHT JOIN tbl_contenidos apuntes ON apuntes.id_tema = temas.id 
                            WHERE apuntes.id = ?",[$datosDenuncia->id_contenido]);
                            if ($apunte[0]->id_tema == null) {
                                if ($apunte[0]->extension_contenido == ".pdf") {
                                    $pathPDF = 'public/uploads/apuntes_reciclados/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido;
                                    $pathIMG = 'public/uploads/apuntes_reciclados/'.$apunte[0]->nombre_contenido.'.png';
                                    Storage::delete($pathPDF); 
                                    Storage::delete($pathIMG); 
                                }else{
                                    $path = 'public/uploads/apuntes_reciclados/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido; 
                                    Storage::delete($path); 
                                }
                            }else{
                                if ($apunte[0]->extension_contenido == ".pdf") {
                                    $pathPDF = 'public/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido;
                                    $pathIMG = 'public/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.'.png';
                                    Storage::delete($pathPDF); 
                                    Storage::delete($pathIMG); 
                                }else{
                                    $path = 'public/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido; 
                                    Storage::delete($path); 
                                }
                            }
                            DB::delete("DELETE FROM tbl_contenidos WHERE id = ?",[$datosDenuncia->id_contenido]);
                            $datos = array('message'=>$msj);
                            $enviar = new sendMail($datos);
                            $enviar->sub = $sub;
                            Mail::to($datosAcusado->correo_usu)->send($enviar);
                            //Mail::to($datosAcusado->correo_usu)->send($enviar);
                            DB::commit();
                            return response()->json(array('resultado' => "OK"));
                        } catch (\Exception $e) {
                            DB::rollback();
                            return response()->json(array('resultado' => "NOK: ".$e->getMessage()));
                        } 
                    }
                } catch (\Exception $e) {
                    return response()->json(array('resultado' => "NOK: ".$e->getMessage()));
                }
            }
            public function banearUsuario(Request $request){
                $datos = $request->except("_token","_method");
                try {
                    $datosAcusado = DB::select("SELECT * FROM tbl_usuario WHERE nick_usu = ?",[$datos["nick_usu"]]);
                    $datosAcusado = $datosAcusado[0];
                    $nombreApellido = $datosAcusado->nombre_usu." ".$datosAcusado->apellido_usu;
                    $horaActual = date('H:i:s');
                    $datetime = $datos["fecha_denuncia"]." ".$horaActual;
                    DB::update("UPDATE tbl_usuario SET deshabilitado = ? WHERE id = ?",[$datetime,$datosAcusado->id]);
                    $sub = "Baneo de cuenta";
                    $msj = "Estimado/a $nombreApellido el equipo de Notehub ha decidido banear su cuenta debido a incidencias que usted ha ido comentiendo en nuestra plataforma, cualquier duda contacte con el equipo de Notehub.";
                    $datos = array('message'=>$msj);
                    $enviar = new sendMail($datos);
                    $enviar->sub = $sub;
                    Mail::to($datosAcusado->correo_usu)->send($enviar);
                    //Mail::to($datosAcusado->correo_usu)->send($enviar);
                    return response()->json(array('resultado' => "OK")); 
                } catch (\Exception $e) {
                    return response()->json(array('resultado' => "NOK: ".$e->getMessage()));
                }
            }
            public function quitardenuncia(Request $request){
                $datos = $request->except("_token","_method");
                try {
                    DB::delete("DELETE FROM tbl_denuncias WHERE id = ?",[$datos["id_denuncia"]]);
                    return response()->json(array('resultado' => "OK")); 
                } catch (\Exception $e) {
                    return response()->json(array('resultado' => "NOK: ".$e->getMessage()));
                }
            }
}
