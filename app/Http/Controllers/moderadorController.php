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
                $moderador = DB::select("SELECT * FROM (SELECT tbl_denuncias.*,CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'demandante' FROM tbl_denuncias
                LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_demandante
                LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario) denuncia1
                INNER JOIN (
                    SELECT tbl_denuncias.id as 'id_denuncia',CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'acusado' FROM tbl_denuncias 
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
            $denuncias = DB::select("SELECT * FROM (SELECT tbl_denuncias.*,CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'demandante' FROM tbl_denuncias
            LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_demandante
            LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
            LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario) denuncia1
            INNER JOIN (
                SELECT tbl_denuncias.id as 'id_denuncia',CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'acusado' FROM tbl_denuncias 
                   LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_acusado
                LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
            )denuncia2 on denuncia2.id_denuncia=denuncia1.id");
            return response()->json($denuncias);
        }
        public function moderadorComments(){
            $comentarios = DB::select("SELECT * FROM (SELECT tbl_denuncias.*,CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'demandante' FROM tbl_denuncias
            LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_demandante
            LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
            LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
            WHERE tbl_denuncias.tipus_denuncia = ?) denuncia1
            INNER JOIN (
                SELECT tbl_denuncias.id as 'id_denuncia',CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'acusado' FROM tbl_denuncias 
                   LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_acusado
                LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
                WHERE tbl_denuncias.tipus_denuncia = ?
            )denuncia2 on denuncia2.id_denuncia=denuncia1.id;",["comentario","comentario"]);
            return response()->json($comentarios);
        }
        public function moderadorNotes(){
            $apuntes = DB::select("SELECT * FROM (SELECT tbl_denuncias.*,CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'demandante' FROM tbl_denuncias
            LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_demandante
            LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
            LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
            WHERE tbl_denuncias.tipus_denuncia = ?) denuncia1
            INNER JOIN (
                SELECT tbl_denuncias.id as 'id_denuncia',CONCAT_WS(' ', tbl_usuario.nombre_usu,tbl_usuario.apellido_usu) as 'acusado' FROM tbl_denuncias 
                   LEFT JOIN tbl_usuario ON tbl_usuario.id = tbl_denuncias.id_acusado
                LEFT JOIN tbl_contenidos ON tbl_contenidos.id = tbl_denuncias.id_contenido
                LEFT JOIN tbl_comentarios ON tbl_comentarios.id = tbl_denuncias.id_comentario
                WHERE tbl_denuncias.tipus_denuncia = ?
            )denuncia2 on denuncia2.id_denuncia=denuncia1.id",["Apunte","Apunte"]);
            return response()->json($apuntes);
        }
        //Eliminar denuncia
        public function eliminarDenuncia(Request $request){
            return response()->json($request);
        }
}
