<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $query .= "AND centro.nombre_centro LIKE \"%".$datos["centros"]."%\" ";
            //$query = $query + $Centro;
        }
        if($datos["cursos"] != null){
            $query .= "AND curso.nombre_curso LIKE \"%".$datos["cursos"]."%\" ";
        }
        if($datos["asignaturas"]!= null){
            $query .= "AND asignaturas.nombre_asignatura LIKE \"%".$datos["asignaturas"]."%\" ";
        }
        if ($datos["nombre_tema"]!= null){
            $query .= "AND temas.nombre_tema LIKE \"%".$datos["nombre_tema"]."%\" ";
        }
        $query.="ORDER BY content.fecha_publicacion_contenido DESC";
        $filtro = DB::select($query);
        return response()->json($filtro);
    }

    public function busquedaAvanzadaCentro(Request $request){
        $datos = $request->except("_token");
        $selectCurso = DB::select("SELECT curso.id,curso.nombre_curso FROM tbl_centro centro
        INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
        WHERE centro.nombre_centro LIKE ?",['%'.$datos['nombre_centro'].'%']);
        $selectAsignatura = DB::select("SELECT asignatura.id, asignatura.nombre_asignatura FROM tbl_centro centro
        INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
        INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
        WHERE centro.nombre_centro LIKE ?",['%'.$datos['nombre_centro'].'%']);
        return response()->json(array('cursos' => $selectCurso,'asignaturas' =>$selectAsignatura));
    }

    public function busquedaAvanzadaCurso(Request $request){
        $datos = $request->except("_token");
        $select = DB::select("SELECT curso.id as id_curso,curso.nombre_curso, asignatura.id as id_asignatura, asignatura.nombre_asignatura FROM tbl_cursos curso
        INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
        WHERE curso.nombre_curso LIKE ?",['%'.$datos['nombre_curso'].'%']);
        return response()->json($select);
    }

    public function misApuntes(){
        if (session()->get('user')) {
            $user = session()->get('user');
            $select = DB::select("SELECT contenidos.* FROM tbl_contenidos contenidos
            INNER JOIN tbl_usuario user ON contenidos.id_usu = user.id
            WHERE user.id = ?",[$user->id]);
            return view('misApuntes',compact('select'));
        }else{
            return redirect('/');
        }
    }
    public function apuntes($id){
        if (session()->get('user')) {
            $apunte = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.nombre_tema,avatar.img_avatar FROM tbl_usuario usu 
            INNER JOIN tbl_centro centro ON usu.id_centro = centro.id
            INNER JOIN tbl_cursos curso ON centro.id = curso.id_centro
            INNER JOIN tbl_asignaturas asig ON curso.id = asig.id_curso
            INNER JOIN tbl_temas temas ON asig.id = temas.id_asignatura
            INNER JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
            LEFT JOIN tbl_avatar avatar ON usu.id = avatar.id_usu
            WHERE apuntes.id =  ?",[$id]);
            $path = asset('storage/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido);
            //return $path;
            return view('vistaApunte',compact('apunte','path'));
        }else{
            return redirect('/');
        }
    }
    public function download(Request $request){
        $datos = $request->except('_token');
        $apunte = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.nombre_tema,avatar.img_avatar FROM tbl_usuario usu 
            INNER JOIN tbl_centro centro ON usu.id_centro = centro.id
            INNER JOIN tbl_cursos curso ON centro.id = curso.id_centro
            INNER JOIN tbl_asignaturas asig ON curso.id = asig.id_curso
            INNER JOIN tbl_temas temas ON asig.id = temas.id_asignatura
            INNER JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
            LEFT JOIN tbl_avatar avatar ON usu.id = avatar.id_usu
            WHERE apuntes.id =  ?",[$datos["id"]]);
        $path = asset('storage/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido);
        $name = $apunte[0]->nombre_contenido.$apunte[0]->extension_contenido;
        return Storage::download($path);
    }
}
