<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApuntesController extends Controller
{
    //Pagina buscador
    public function buscador(){
        if (session()->get("user")) {
            $user=session()->get('user');
            //Mostrar los más recientes
            $recent=DB::select("SELECT content.*,user.nick_usu,avatar.img_avatar from tbl_contenidos content
            INNER JOIN tbl_usuario user ON content.id_usu = user.id
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
            ORDER BY content.fecha_publicacion_contenido DESC");
            //Mostrar los más populares
            $popular=DB::select("SELECT content.*,user.nick_usu,sum(coment.val_comentario) as 'valoracion',avatar.img_avatar FROM tbl_contenidos content
            INNER JOIN tbl_usuario user ON content.id_usu = user.id
            LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
            GROUP BY content.nombre_contenido
            ORDER BY valoracion DESC");
            return view('buscador',compact('user','recent','popular'));
        }else{
            return redirect("/");
        }
    }
    public function multiplyFilter(Request $request){
        $datos=$request->except("_token");
        $filter=DB::select("SELECT content.*,users.nick_usu,avatar.img_avatar,centro.id,centro.nombre_centro,curso.id,curso.nombre_curso,asignaturas.id,asignaturas.nombre_asignatura,temas.id,temas.nombre_tema 
        FROM tbl_contenidos content
                    INNER JOIN tbl_usuario users ON content.id_usu = users.id
                    LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
                    INNER JOIN tbl_temas temas ON temas.id = content.id_tema
                    INNER JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                    INNER JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                    INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
                    WHERE centro.nombre_centro LIKE ? OR curso.nombre_curso LIKE ? OR asignaturas.nombre_asignatura LIKE ? OR temas.nombre_tema LIKE ?
                    ORDER BY content.fecha_publicacion_contenido DESC;",['%'.$datos["filter"].'%','%'.$datos["filter"].'%','%'.$datos["filter"].'%','%'.$datos["filter"].'%']);
        return response()->json($filter);
    }
}
