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
            $recent=DB::select("SELECT content.id as id_content, content.*,user.nick_usu,sum(coment.val_comentario) as 'valoracion',count(hist.id_contenido) as 'descargas',avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema FROM tbl_contenidos content
            INNER JOIN tbl_usuario user ON content.id_usu = user.id
            LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
            LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
            INNER JOIN tbl_temas temas ON temas.id = content.id_tema
            INNER JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
            INNER JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
            INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
            WHERE NOT user.id = ?
            GROUP BY content.id
            ORDER BY content.fecha_publicacion_contenido DESC LIMIT 15",[$user->id]);
            //Mostrar los más populares
            $popular=DB::select("SELECT content.id as id_content,content.*,user.nick_usu,sum(coment.val_comentario) as 'valoracion',count(hist.id_contenido) as 'descargas',avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema FROM tbl_contenidos content
            INNER JOIN tbl_usuario user ON content.id_usu = user.id
            LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
            LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
            INNER JOIN tbl_temas temas ON temas.id = content.id_tema
            INNER JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
            INNER JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
            INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
            WHERE NOT user.id = ?
            GROUP BY content.id
            ORDER BY valoracion DESC LIMIT 15;",[$user->id]);
            //Lista centros
            $listaCentros = DB::select("SELECT * FROM tbl_centro");
            //Lista de cursos
            $listaCursos = DB::select("SELECT * FROM tbl_cursos");
            //Lista de asignaturas
            $listaAsignaturas = DB::select("SELECT * FROM tbl_asignaturas");
            return view('buscador',compact('user','recent','popular','listaCentros','listaCursos','listaAsignaturas'));
        }else{
            return redirect("login");
        }
    }

    public function multiplyFilter(Request $request){
        $datos=$request->except("_token");
        $user=session()->get('user');
        $filter=DB::select("SELECT content.id as 'id_content', content.*,users.nick_usu,avatar.img_avatar,sum(coment.val_comentario) as 'valoracion',count(hist.id_contenido) as 'descargas',centro.id,centro.nombre_centro,curso.id,curso.nombre_curso,asignaturas.id,asignaturas.nombre_asignatura,temas.id,temas.nombre_tema 
        FROM tbl_contenidos content
                    INNER JOIN tbl_usuario users ON content.id_usu = users.id
                    LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
                    LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                    LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                    INNER JOIN tbl_temas temas ON temas.id = content.id_tema
                    INNER JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                    INNER JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                    INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
                    WHERE (centro.nombre_centro LIKE ? OR curso.nombre_curso LIKE ? OR asignaturas.nombre_asignatura LIKE ? OR content.id = ?) AND NOT users.id= ?
                    GROUP BY content.id",['%'.$datos["filter"].'%','%'.$datos["filter"].'%','%'.$datos["filter"].'%',$datos["filter"],$user->id]);
        return response()->json($filter);
    }

    public function busquedaAvanzada(Request $request){
        $datos = $request->except("_token");
        $user=session()->get('user');
        $query="SELECT content.id as 'id_content', content.*,users.nick_usu,avatar.img_avatar,sum(coment.val_comentario) as 'valoracion',count(hist.id_contenido) as 'descargas',centro.id,centro.nombre_centro,curso.id,curso.nombre_curso,asignaturas.id,asignaturas.nombre_asignatura,temas.id,temas.nombre_tema 
        FROM tbl_contenidos content
        INNER JOIN tbl_usuario users ON content.id_usu = users.id
        LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
        LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
        LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
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
        $query.="GROUP BY id_content ORDER BY content.fecha_publicacion_contenido DESC";
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

    //Pagina mis apuntes
    public function misApuntes(){
        if (session()->get('user')) {
            $user = session()->get('user');
            $select = DB::select("SELECT contenidos.* FROM tbl_contenidos contenidos
            INNER JOIN tbl_usuario user ON contenidos.id_usu = user.id
            WHERE user.id = ?",[$user->id]);
            $selectCurso = DB::select("SELECT curso.id,curso.nombre_curso FROM tbl_centro centro
            INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
            WHERE centro.id = ?",[$user->id_centro]);
            $selectAsignatura = DB::select("SELECT asignatura.id, asignatura.nombre_asignatura FROM tbl_centro centro
            INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
            INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
            WHERE centro.id = ?",[$user->id_centro]);
            $selectTema = DB::select("SELECT tema.id, tema.nombre_tema FROM tbl_centro centro
            INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
            INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
            INNER JOIN tbl_temas tema ON tema.id_asignatura = asignatura.id
            WHERE centro.id = ?",[$user->id_centro]);
            return view('misApuntes',compact('user','select','selectCurso','selectAsignatura','selectTema'));
        }else{
            return redirect('login');
        }
    }
    public function misApuntes_curso(Request $request){
        $datos = $request->except("_token");
        $selectAsignatura = DB::select("SELECT asignatura.id, asignatura.nombre_asignatura FROM tbl_centro centro
        INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
        INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
        WHERE centro.id = ? AND curso.nombre_curso = ?",[$datos['id_centro'],$datos['nombre_curso']]);
        $selectTema = DB::select("SELECT tema.id, tema.nombre_tema FROM tbl_centro centro
        INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
        INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
        INNER JOIN tbl_temas tema ON tema.id_asignatura = asignatura.id
        WHERE centro.id = ? AND curso.nombre_curso = ?",[$datos['id_centro'],$datos['nombre_curso']]);
        return response()->json(array('asignaturas' => $selectAsignatura,'temas' => $selectTema));
    }
    public function misApuntes_asignatura(Request $request){
        $datos = $request->except("_token");
        $selectTema = DB::select("SELECT tema.id, tema.nombre_tema FROM tbl_centro centro
        INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
        INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
        INNER JOIN tbl_temas tema ON tema.id_asignatura = asignatura.id
        WHERE centro.id = ? AND asignatura.nombre_asignatura = ?",[$datos['id_centro'],$datos['nombre_asignatura']]);
        return response()->json($selectTema);
    }
    public function misApuntes_subirapunte(Request $request){
        $user = session()->get('user');
        $datos = $request->except("_token");
        $centro = DB::select("SELECT nombre_centro FROM tbl_centro WHERE id = ?",[$datos["id_centro"]]);
        //Si no ha especificado el tema le hacemos saltar error
        if ($datos["text_tema"] == null && $datos["select_tema"] == null) {
            return response()->json(array('resultado'=> 'nullTema'));
        }else{
            //En caso que usase el input text le creamos carpeta y se almacenará el tema en la base de datos
            if ($datos["text_tema"] != null) {
                $tema = $datos["text_tema"];
                $path = public_path('storage/uploads/apuntes/'.$centro[0]->nombre_centro.'/'.$datos["curso"].'/'.$datos["asignatura"].'/'.$tema);
                if(!file_exists($path)){
                    //En caso que el tema no exista en la ruta le haremos insert en la base de datos del tema y cogemos el id de asignatura y creamos la carpeta
                    //Falta por hacer query, ya se hará pruebas proximamente primero el select con joins y despues el insert
                    Storage::makeDirectory('uploads/apuntes/'.$centro[0]->nombre_centro.'/'.$datos["curso"].'/'.$datos["asignatura"].'/'.$tema);
                }
            }else{
                //En caso que el tema ya exista cogemos datos del select
                $tema = $datos["select_tema"];
            }
            if ($request->hasFile('apuntes')) {
                //En caso que tenga fichero comprobamos si ya existe el apunte
                $path = public_path('storage/uploads/apuntes/'.$centro[0]->nombre_centro.'/'.$datos["curso"].'/'.$datos["asignatura"].'/'.$tema.'/'.$request->file('apuntes'));
                if (file_exists($path)) {
                    return response()->json(array('resultado'=> 'existApunte'));
                }else{
                    //Cogemos ruta de la carpeta
                    $path_folder = 'public/uploads/apuntes/'.$centro[0]->nombre_centro.'/'.$datos["curso"].'/'.$datos["asignatura"].'/'.$tema;
                    $file = $request->file('apuntes');
                    //Cogemos el nombre original del fichero
                    $fileName = $file->getClientOriginalName();
                    //Cogemos la extension del contenido y el nombre para la base de datos
                    $arrayFileName = explode('.',$fileName);
                    //Nombre del archivo
                    $nameFile = $arrayFileName[0];
                    //Extension del archivo
                    $extensionFile = $arrayFileName[1];
                    try {
                        //Lo almacenamos con el nombre original y le hacemos insert
                        $file->storeAs($path_folder,$fileName);
                        return response()->json(array('resultado'=> 'OK'));
                    } catch (\Exception $e) {
                        return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
                    }
                }
            }
        }
    }
    //Pagina apunte
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
            return redirect('login');
        }
    }
    public function download(Request $request){
        if (session()->get('user')) {
            $user = session()->get('user');
            $datos = $request->except('_token');
            try {
                $apunte = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.nombre_tema,avatar.img_avatar FROM tbl_usuario usu 
                INNER JOIN tbl_centro centro ON usu.id_centro = centro.id
                INNER JOIN tbl_cursos curso ON centro.id = curso.id_centro
                INNER JOIN tbl_asignaturas asig ON curso.id = asig.id_curso
                INNER JOIN tbl_temas temas ON asig.id = temas.id_asignatura
                INNER JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
                LEFT JOIN tbl_avatar avatar ON usu.id = avatar.id_usu
                WHERE apuntes.id =  ?",[$datos["id"]]);
                $path = public_path('storage/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido);
                $existDownload = DB::select("SELECT * FROM tbl_historial WHERE id_contenido = ? AND id_usu = ?",[$datos["id"],$user->id]);
                if (file_exists($path)) {
                    if (count($existDownload) == 0) {
                        DB::insert("INSERT INTO tbl_historial (id_contenido,id_usu) VALUES (?, ?)",[$datos["id"],$user->id]);
                    }
                    //$path = asset('storage/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido);
                    //$name = $apunte[0]->nombre_contenido.$apunte[0]->extension_contenido;
                    return response()->download($path);
                }else{
                    return $path;
                }
            } catch (\Exception $e) {
                $e->getMessage();
            }
        }else{
            return redirect('login');
        }
    }
}
