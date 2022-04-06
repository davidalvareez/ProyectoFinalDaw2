<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CRUDAdminController extends Controller
{
    //Mostrar
    public function adminView(){
        if (session()->has('user')) {
            $userAdmin = session()->get('user');
            if ($userAdmin->id_rol == 1) {
                return view("admin");
            }
        }
        return redirect('/');
    }

    public function showUsers(){
        if (session()->has('user')) {
            $idUsuario = session()->get('user');
        }

        $users = DB::select("SELECT tbl_usuario.id, tbl_usuario.nick_usu, tbl_usuario.nombre_usu, tbl_usuario.apellido_usu, tbl_usuario.fecha_nac_usu,
        tbl_usuario.correo_usu, tbl_usuario.deshabilitado, tbl_centro.nombre_centro, tbl_rol.nombre_rol, tbl_niveles.nombre_nivel,tbl_avatar.img_avatar
        FROM tbl_usuario INNER JOIN tbl_rol ON tbl_usuario.id_rol = tbl_rol.id
        LEFT JOIN tbl_centro ON tbl_usuario.id_centro = tbl_centro.id
        LEFT JOIN tbl_niveles ON tbl_usuario.id_nivel = tbl_niveles.id
        LEFT JOIN tbl_avatar ON tbl_usuario.id = tbl_avatar.id_usu
        WHERE NOT tbl_usuario.id = ? ",[$idUsuario->id]);
        //?",[$idUsuario->id])
        return response()->json($users);
    }

    public function showCentros(){
        $centros = DB::select("SELECT * FROM tbl_centro");
        return response()->json($centros);
    }

    public function showCursos($id){
        $cursos = DB::select("SELECT * FROM tbl_centro INNER JOIN tbl_cursos ON tbl_centro.id = tbl_cursos.id_centro
        WHERE tbl_centro.id = ? ",[$id]);
        return response()->json($cursos);
    }

    public function showAsignaturas($id){
        $asignaturas = DB::select("SELECT * FROM tbl_cursos INNER JOIN tbl_asignaturas ON tbl_cursos.id = tbl_asignaturas.id_curso
        WHERE tbl_cursos.id = ? ",[$id]);
        return response()->json($asignaturas);
    }

    public function showTemas($id){
        $temas = DB::select("SELECT * FROM tbl_asignaturas INNER JOIN tbl_temas ON tbl_asignaturas.id = tbl_temas.id_asignatura
        WHERE tbl_asignaturas.id = ? ",[$id]);
        return response()->json($temas);
    }

    public function showApuntes(){
        $apuntes = DB::select("SELECT apuntes.*,usu.nombre_usu,usu.apellido_usu FROM tbl_contenidos apuntes INNER JOIN tbl_usuario usu ON usu.id = apuntes.id_usu");
        return response()->json($apuntes);
    }

    public function showDenuncias(){
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

    public function showHistorial(){
        $historial = DB::select("SELECT * FROM tbl_historial
        INNER JOIN tbl_usuario ON tbl_usuario.id = tbl_historial.id_usu
        INNER JOIN tbl_contenidos ON tbl_contenidos.id = tbl_historial.id_contenido");
        return response()->json($historial);
    }

    //Crear


    //Actualizar


    //Eliminar

}
