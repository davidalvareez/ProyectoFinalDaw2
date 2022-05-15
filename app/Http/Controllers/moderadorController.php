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
                    $msj = "Querido/a $nombreApellido hemos recibido su denuncia hacia el comentario y no se ha aprobado, gracias por aportar al equipo de Note Hub";
                }elseif ($datosDenuncia->tipus_denuncia == "Apunte"){
                    $sub = "Denuncia apunte denegado";
                    $msj = "Querido/a $nombreApellido hemos recibido su denuncia hacia dicho apunte y no se ha aprobado, gracias por aportar al equipo de Note Hub";
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
                //Si la denuncia es un comentario eliminamos el comentario
                if ($datosDenuncia->tipus_denuncia == "Comentario") {
                    try {
                        DB::beginTransaction();
                        DB::delete("DELETE FROM tbl_comentarios WHERE id = ?",[$datosDenuncia->id_comentario]);
                        DB::delete("DELETE FROM tbl_denuncias WHERE id = ?",[$datosDenuncia->id]);
                        DB::commit();
                        return response()->json(array('resultado' => "OK"));
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(array('resultado' => "NOK: ".$e->getMessage()));
                    }
                //Si es un apunte borramos el apunte el historial que hay en el y la denuncia y borramos el apunte del storage para hacer limpieza en el servidor
                }elseif ($datosDenuncia->tipus_denuncia == "Apunte"){
                
                }
            } catch (\Exception $e) {
                return response()->json(array('resultado' => "NOK: ".$e->getMessage()));
            }
        }
        public function banearUsuario(Request $request){
            $datos = $request->except("_token","_method");
            $datosDenuncia = DB::select("SELECT * FROM tbl_denuncias WHERE id = ?",[$datos["id_denuncia"]]);
            $datosAcusado = DB::select("SELECT * FROM tbl_usuario WHERE nick_usu = ?",[$datos["nick_usu"]]);
            return response()->json($datos);
        }
}
