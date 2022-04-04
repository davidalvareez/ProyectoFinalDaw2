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
            //Para búsqueda avanzada mostrar todos los datos
            //Mostrar los más recientes
            $recent=DB::select("SELECT content.*,user.nick_usu,avatar.img_avatar from tbl_contenidos content
            INNER JOIN tbl_usuario user ON content.id_usu = user.id
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
            WHERE NOT user.id = ?
            ORDER BY content.fecha_publicacion_contenido DESC LIMIT 15",[$user->id]);
            //Mostrar los más populares
            $popular=DB::select("SELECT content.*,user.nick_usu,sum(coment.val_comentario) as 'valoracion',avatar.img_avatar FROM tbl_contenidos content
            INNER JOIN tbl_usuario user ON content.id_usu = user.id
            LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
            WHERE NOT user.id = ?
            GROUP BY content.nombre_contenido
            ORDER BY valoracion DESC LIMIT 15",[$user->id]);
            //Lista centros
            $listaCentros = DB::select("SELECT * FROM tbl_centro");
            //Lista de cursos
            $listaCursos = DB::select("SELECT * FROM tbl_cursos");
            //Lista de asignaturas
            $listaAsignaturas = DB::select("SELECT * FROM tbl_asignaturas");
            return view('buscador',compact('user','recent','popular','listaCentros','listaCursos','listaAsignaturas'));
        }else{
            return redirect("/");
        }
    }
    public function multiplyFilter(Request $request){
        $datos=$request->except("_token");
        $user=session()->get('user');
        $filter=DB::select("SELECT content.*,users.nick_usu,avatar.img_avatar,centro.id,centro.nombre_centro,curso.id,curso.nombre_curso,asignaturas.id,asignaturas.nombre_asignatura,temas.id,temas.nombre_tema 
        FROM tbl_contenidos content
                    INNER JOIN tbl_usuario users ON content.id_usu = users.id
                    LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
                    INNER JOIN tbl_temas temas ON temas.id = content.id_tema
                    INNER JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                    INNER JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                    INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
                    WHERE (centro.nombre_centro LIKE ? OR curso.nombre_curso LIKE ? OR asignaturas.nombre_asignatura LIKE ? OR temas.nombre_tema LIKE ?) AND NOT users.id= ?
                    ORDER BY content.fecha_publicacion_contenido DESC;",['%'.$datos["filter"].'%','%'.$datos["filter"].'%','%'.$datos["filter"].'%','%'.$datos["filter"].'%',$user->id]);
        return response()->json($filter);
    }
    public function busquedaAvanzada(Request $request){
        $datos = $request->except("_token");
        $user=session()->get('user');
        $query="SELECT * FROM tbl_contenidos content
        INNER JOIN tbl_usuario users ON content.id_usu = users.id
        LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
        INNER JOIN tbl_temas temas ON temas.id = content.id_tema
        INNER JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
        INNER JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
        INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
        WHERE NOT users.id= {$user->id} ";
        if($datos["centros"] != null){
            $query += "AND centro.nombre_centro = {$datos["centros"]} ";
            //$query = $query + $Centro;
            return response()->json($query);
        }
        if($datos["cursos"] != null){
            $Curso = "AND curso.nombre_curso LIKE '%'{$datos["cursos"]}'%' ";
            $query = $query + $Curso;
        }
        if($datos["asignaturas"]!= null){
            $Asignatura = "AND asignaturas.nombre_asignatura LIKE '%'{$datos["asignaturas"]}'%' ";
            $query = $query + $Asignatura;
        }
        if ($datos["nombre_tema"]!= null){
            $tema = "AND temas.nombre_tema LIKE '%'{$datos["nombre_tema"]}'%' ";
            $query = $query + $tema;
        }
        //$query+="ORDER BY content.fecha_publicacion_contenido";
        //$filtro = DB::select($query);
        return response()->json($query);
    }
}
