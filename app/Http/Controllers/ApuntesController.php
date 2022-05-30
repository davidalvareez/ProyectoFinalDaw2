<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Imagick;
class ApuntesController extends Controller
{
    //Pagina buscador
        public function buscador(){
            if (session()->get("user")) {
                $user=session()->get('user');
                $sqlrecent="SELECT content.id as id_content, content.nombre_contenido,content.extension_contenido,DATE_FORMAT(content.fecha_publicacion_contenido,'%d/%m/%Y') as 'fecha_publicacion_contenido',user.nick_usu,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas',avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema,temas.id as id_tema FROM tbl_contenidos content
                INNER JOIN tbl_usuario user ON content.id_usu = user.id
                LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
                LEFT JOIN tbl_temas temas ON temas.id = content.id_tema
                LEFT JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                LEFT JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                LEFT JOIN tbl_centro centro ON centro.id = curso.id_centro ";

                $sqlpopular = "SELECT content.id as id_content, content.nombre_contenido,content.extension_contenido,DATE_FORMAT(content.fecha_publicacion_contenido,'%d/%m/%Y') as 'fecha_publicacion_contenido',user.nick_usu,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas',avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema,temas.id as id_tema FROM tbl_contenidos content
                INNER JOIN tbl_usuario user ON content.id_usu = user.id
                LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
                LEFT JOIN tbl_temas temas ON temas.id = content.id_tema
                LEFT JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                LEFT JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                LEFT JOIN tbl_centro centro ON centro.id = curso.id_centro ";
                //Si tiene fichero configuración se filtrara de una manera o de otra, o si en su configuración es nulo
                if (file_exists(storage_path('app/public/uploads/configuration/user-'.$user->id.'.json'))) {
                    //Si existe directamente cogemos el fichero y miramos si el campo esta nulo
                    $configuration = json_decode(file_get_contents(storage_path('app/public/uploads/configuration/user-'.$user->id.'.json')), true);
                    if ($configuration["curso"] != null or $configuration["curso"] != "") {
                        $sqlrecent .= "WHERE curso.nombre_curso = '{$configuration["curso"]}' ";
                        $sqlpopular .= "WHERE curso.nombre_curso = '{$configuration["curso"]}' ";
                    }
                }
                $sqlrecent .= "GROUP BY content.id ORDER BY content.fecha_publicacion_contenido DESC LIMIT 15";
                $sqlpopular .= "GROUP BY content.id ORDER BY valoracion DESC,descargas DESC LIMIT 15";
                
                //Mostrar los más recientes
                $recent=DB::select($sqlrecent);

                //Mostrar los más populares
                $popular=DB::select($sqlpopular);

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
            $datos=$request->except("_token","_method");
            $user=session()->get('user');
            if ($datos["filter"] == "") {
                $filter=DB::select("SELECT content.id as id_content, content.nombre_contenido,content.extension_contenido,DATE_FORMAT(content.fecha_publicacion_contenido,'%d/%m/%Y') as 'fecha_publicacion_contenido',users.nick_usu,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas',avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema,temas.id as id_tema 
                    FROM tbl_contenidos content
                                INNER JOIN tbl_usuario users ON content.id_usu = users.id
                                LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
                                LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                                LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                                LEFT JOIN tbl_temas temas ON temas.id = content.id_tema
                                LEFT JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                                LEFT JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                                LEFT JOIN tbl_centro centro ON centro.id = curso.id_centro
                                GROUP BY content.id");
            }else{
                $id = $datos["filter"][0];
                if (is_numeric($id)) {
                    $filter=DB::select("SELECT content.id as id_content, content.nombre_contenido,content.extension_contenido,DATE_FORMAT(content.fecha_publicacion_contenido,'%d/%m/%Y') as 'fecha_publicacion_contenido',users.nick_usu,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas',avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema,temas.id as id_tema
                    FROM tbl_contenidos content
                                INNER JOIN tbl_usuario users ON content.id_usu = users.id
                                LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
                                LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                                LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                                LEFT JOIN tbl_temas temas ON temas.id = content.id_tema
                                LEFT JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                                LEFT JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                                LEFT JOIN tbl_centro centro ON centro.id = curso.id_centro
                                WHERE content.id = ? AND (users.id = ? OR NOT users.id = ?)
                                GROUP BY content.id",[$datos["filter"],$user->id,$user->id]);
                }else{
                    $filter=DB::select("SELECT content.id as id_content, content.nombre_contenido,content.extension_contenido,DATE_FORMAT(content.fecha_publicacion_contenido,'%d/%m/%Y') as 'fecha_publicacion_contenido',users.nick_usu,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas',avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema,temas.id as id_tema
                    FROM tbl_contenidos content
                    INNER JOIN tbl_usuario users ON content.id_usu = users.id
                    LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
                    LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                    LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                    LEFT JOIN tbl_temas temas ON temas.id = content.id_tema
                    LEFT JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                    LEFT JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                    LEFT JOIN tbl_centro centro ON centro.id = curso.id_centro
                    WHERE (centro.nombre_centro LIKE ? OR curso.nombre_curso LIKE ? OR asignaturas.nombre_asignatura LIKE ? OR content.id = ?) AND (users.id = ? OR NOT users.id = ?)
                    GROUP BY content.id",['%'.$datos["filter"].'%','%'.$datos["filter"].'%','%'.$datos["filter"].'%',$datos["filter"],$user->id,$user->id]);
                }
            }
            return response()->json($filter);
        }

        public function busquedaAvanzada(Request $request){
            $datos = $request->except("_token");
            $user=session()->get('user');
            $query="SELECT content.id as id_content, content.nombre_contenido,content.extension_contenido,DATE_FORMAT(content.fecha_publicacion_contenido,'%d/%m/%Y') as 'fecha_publicacion_contenido',users.nick_usu,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas',avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema,temas.id as id_tema
            FROM tbl_contenidos content
            INNER JOIN tbl_usuario users ON content.id_usu = users.id
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
            LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
            LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
            LEFT JOIN tbl_temas temas ON temas.id = content.id_tema
            LEFT JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
            LEFT JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
            LEFT JOIN tbl_centro centro ON centro.id = curso.id_centro
            WHERE (NOT users.id= {$user->id} OR users.id = {$user->id}) ";
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
                $select = DB::select("SELECT contenidos.id,contenidos.nombre_contenido,contenidos.extension_contenido,DATE_FORMAT(contenidos.fecha_publicacion_contenido,'%d/%m/%Y') as 'fecha_publicacion_contenido' FROM tbl_contenidos contenidos
                INNER JOIN tbl_usuario user ON contenidos.id_usu = user.id
                WHERE user.id = ?",[$user->id]);
                $selectCentro = DB::select("SELECT id,nombre_centro FROM tbl_centro");
                $selectCurso = DB::select("SELECT curso.id,curso.nombre_curso FROM tbl_centro centro
                INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id");
                $selectAsignatura = DB::select("SELECT asignatura.id, asignatura.nombre_asignatura FROM tbl_centro centro
                INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
                INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id");
                $selectTema = DB::select("SELECT tema.id, tema.nombre_tema FROM tbl_centro centro
                INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
                INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
                INNER JOIN tbl_temas tema ON tema.id_asignatura = asignatura.id");
                return view('misApuntes',compact('user','select','selectCentro','selectCurso','selectAsignatura','selectTema'));
            }else{
                return redirect('login');
            }
        }
        public function misApuntes_centro(Request $request) {
            $datos = $request->except("_token");
            $selectCurso = DB::select("SELECT curso.id,curso.nombre_curso FROM tbl_centro centro
            INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
            WHERE centro.nombre_centro = ?",[$datos["nombre_centro"]]);
            $selectAsignatura = DB::select("SELECT asignatura.id, asignatura.nombre_asignatura FROM tbl_centro centro
            INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
            INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
            WHERE centro.nombre_centro = ?",[$datos['nombre_centro']]);
            $selectTema = DB::select("SELECT tema.id, tema.nombre_tema FROM tbl_centro centro
            INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
            INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
            INNER JOIN tbl_temas tema ON tema.id_asignatura = asignatura.id
            WHERE centro.nombre_centro = ?",[$datos['nombre_centro']]);
            return response()->json(array('cursos'=>$selectCurso,'asignaturas' => $selectAsignatura,'temas' => $selectTema));
        }
        public function misApuntes_curso(Request $request){
            $datos = $request->except("_token");
            $selectAsignatura = DB::select("SELECT asignatura.id, asignatura.nombre_asignatura FROM tbl_centro centro
            INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
            INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
            WHERE centro.nombre_centro = ? AND curso.nombre_curso LIKE ?",[$datos['nombre_centro'],'%'.$datos['nombre_curso'].'%']);
            $selectTema = DB::select("SELECT tema.id, tema.nombre_tema FROM tbl_centro centro
            INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
            INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
            INNER JOIN tbl_temas tema ON tema.id_asignatura = asignatura.id
            WHERE centro.nombre_centro = ? AND curso.nombre_curso LIKE ?",[$datos['nombre_centro'],'%'.$datos['nombre_curso'].'%']);
            return response()->json(array('asignaturas' => $selectAsignatura,'temas' => $selectTema));
        }
        public function misApuntes_asignatura(Request $request){
            $datos = $request->except("_token");
            $selectTema = DB::select("SELECT tema.id, tema.nombre_tema FROM tbl_centro centro
            INNER JOIN tbl_cursos curso ON curso.id_centro = centro.id
            INNER JOIN tbl_asignaturas asignatura ON asignatura.id_curso = curso.id
            INNER JOIN tbl_temas tema ON tema.id_asignatura = asignatura.id
            WHERE centro.nombre_centro = ? AND curso.nombre_curso LIKE ? AND asignatura.nombre_asignatura LIKE ?",[$datos['nombre_centro'],'%'.$datos['nombre_curso'].'%','%'.$datos['nombre_asignatura'].'%']);
            return response()->json($selectTema);
        }
        public function misApuntes_apuntes(){
            $user = session()->get('user');
            $select = DB::select("SELECT contenidos.id,contenidos.nombre_contenido,contenidos.extension_contenido,DATE_FORMAT(contenidos.fecha_publicacion_contenido,'%d/%m/%Y') as 'fecha_publicacion_contenido' FROM tbl_contenidos contenidos
            INNER JOIN tbl_usuario user ON contenidos.id_usu = user.id
            WHERE user.id = ?",[$user->id]);
            return response()->json($select);
        }
        public function misApuntes_eliminarapunte($id){
            try {
                DB::beginTransaction();
                $existComment = DB::SELECT("SELECT * FROM tbl_comentarios WHERE id_contenido = ?",[$id]);
                if (count($existComment) != 0) {
                    DB::delete("DELETE FROM tbl_comentarios WHERE id_contenido = ?",[$id]);
                }
                $exitDenuncia =DB::select("SELECT * FROM tbl_denuncias WHERE id_contenido = ?",[$id]);
                if (count($exitDenuncia) != 0) {
                    DB::delete("DELETE FROM tbl_denuncias WHERE id_contenido = ?",[$id]);
                }
                $existMultimedia = DB::select("SELECT * FROM tbl_multimedia WHERE id = ?",[$id]);
                if (count($existMultimedia) != 0) {
                    DB::delete("DELETE FROM tbl_multimedia WHERE id = ?",[$id]);
                }
                $existHistorial = DB::select("SELECT * FROM tbl_historial WHERE id_contenido = ?",[$id]);
                if (count($existHistorial) != 0) {
                    DB::delete("DELETE FROM tbl_historial WHERE id_contenido = ?",[$id]);
                }
                $apunte = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.nombre_tema,avatar.img_avatar FROM tbl_usuario usu 
                INNER JOIN tbl_centro centro ON usu.id_centro = centro.id
                INNER JOIN tbl_cursos curso ON centro.id = curso.id_centro
                INNER JOIN tbl_asignaturas asig ON curso.id = asig.id_curso
                INNER JOIN tbl_temas temas ON asig.id = temas.id_asignatura
                INNER JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
                LEFT JOIN tbl_avatar avatar ON usu.id = avatar.id_usu
                WHERE apuntes.id =  ?",[$id]);
                 //Validar si existe el apunte entre todo en caso que no es que esta en reciclaje
                 if (count($apunte) == 0) {
                    $apunte = DB::select("SELECT * FROM tbl_contenidos WHERE id = ?",[$id]);
                    if ($apunte[0]->extension_contenido == ".pdf") {
                        $pathIMG = 'public/uploads/apuntes_reciclados/'.$apunte[0]->nombre_contenido.".png";
                        Storage::delete($pathIMG);
                    }
                    $pathPDF = 'public/uploads/apuntes_reciclados/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido;
                    Storage::delete($pathPDF);
                //En caso contrario cogemos la ruta y la eliminamos
                }else{
                    if ($apunte[0]->extension_contenido == ".pdf") {
                        $pathIMG = 'public/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.'.png';
                        Storage::delete($pathIMG);
                    }
                    $pathPDF = 'public/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido;
                    Storage::delete($pathPDF);
                }    
                DB::delete("DELETE FROM tbl_contenidos WHERE id = ?",[$id]);
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
        public function misApuntes_subirapunte(Request $request){
            $user = session()->get('user');
            $datos = $request->except("_token");
            //return response()->json(array('resultado'=>$datos));
            if ($datos["centro"] == ""){
                return response()->json(array('resultado'=> 'nullCentro'));
            }
            if (!isset($datos["curso"])){
                return response()->json(array('resultado'=> 'nullCurso'));
            }
            if (!isset($datos["asignatura"])){
                return response()->json(array('resultado'=> 'nullAsignatura'));
            }
            //Si no ha especificado el tema le hacemos saltar error
            if ($datos["text_tema"] == null && !isset($datos["select_tema"])) {
                return response()->json(array('resultado'=> 'nullTema'));
            }
            if (!$request->hasFile("apuntes")) {
                return response()->json(array('resultado'=> 'nullApunte'));
            }else{
                $apunte = $request->file('apuntes');
                //Cogemos el nombre original del fichero
                $ApunteName = $apunte->getClientOriginalName();
                //Cogemos la extension del contenido y el nombre para la base de datos
                $arrayFileName = explode('.',$ApunteName);
                //Extension del archivo
                $extensionApunteFile = $arrayFileName[1];
                if ($extensionApunteFile != "pdf" && $extensionApunteFile != "jpg" && $extensionApunteFile != "png") {
                    return response()->json(array('resultado'=> 'nullExtensionApunte'));
                }
            }
            $centro = DB::select("SELECT id,nombre_centro FROM tbl_centro WHERE nombre_centro = ?",[$datos["centro"]]);
            //En caso que usase el input text le creamos carpeta y se almacenará el tema en la base de datos
            if ($datos["text_tema"] != null) {
                $tema = $datos["text_tema"];
                $path = public_path('storage/uploads/apuntes/'.$centro[0]->nombre_centro.'/'.$datos["curso"].'/'.$datos["asignatura"].'/'.$tema);
                if(!file_exists($path)){
                    //En caso que el tema no exista en la ruta le haremos insert en la base de datos del tema y cogemos el id de asignatura y creamos la carpeta
                    $existTema = DB::select("SELECT * FROM tbl_temas temas
                                            INNER JOIN tbl_asignaturas asignatura ON asignatura.id=temas.id_asignatura
                                            INNER JOIN tbl_cursos curso ON curso.id=asignatura.id_curso
                                            INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
                                            WHERE centro.id = ? AND curso.nombre_curso = ? AND asignatura.nombre_asignatura = ? AND temas.nombre_tema = ?",[$centro[0]->id,$datos['curso'],$datos['asignatura'],$tema]);
                    //Si no existe tema creamos el insert y cogemos el id de la asignatura
                    if (count($existTema)==0) {
                        $id_asignatura = DB::select("SELECT asignatura.id FROM tbl_asignaturas asignatura
                        INNER JOIN tbl_cursos curso ON curso.id=asignatura.id_curso
                        INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
                        WHERE centro.id = ? AND curso.nombre_curso = ? AND asignatura.nombre_asignatura = ?",[$centro[0]->id,$datos['curso'],$datos['asignatura']]);
                        $id_new_tema  = DB::table("tbl_temas")->insertGetId(["nombre_tema"=>$tema,"id_asignatura"=>$id_asignatura[0]->id]);
                    }
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
                        if (isset($id_new_tema)) {
                            $id_tema = $id_new_tema;
                        }else{
                            $id_tema_select = DB::select("SELECT temas.id FROM tbl_temas temas
                                            INNER JOIN tbl_asignaturas asignatura ON asignatura.id=temas.id_asignatura
                                            INNER JOIN tbl_cursos curso ON curso.id=asignatura.id_curso
                                            INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
                                            WHERE centro.id = ? AND curso.nombre_curso = ? AND asignatura.nombre_asignatura = ? AND temas.nombre_tema = ?",[$centro[0]->id,$datos['curso'],$datos['asignatura'],$tema]);
                            $id_tema = $id_tema_select[0]->id;
                        }
                        $nombre_contenido = DB::select("SELECT * FROM tbl_contenidos where nombre_contenido = ?",[$nameFile]);
                        if (count($nombre_contenido) == 0) {
                            DB::insert("INSERT INTO tbl_contenidos (nombre_contenido,idioma_contenido,extension_contenido,fecha_publicacion_contenido,id_tema,id_usu) VALUES (?,?,?,?,?,?)",
                            [$nameFile,"Español",".".$extensionFile,date('Y-m-d H:i:s'),$id_tema,$user->id]);
                                $file->storeAs($path_folder,$fileName);
                                if ($extensionFile == "pdf") {
                                    $imagickpath = public_path('storage/uploads/apuntes/'.$centro[0]->nombre_centro.'/'.$datos["curso"].'/'.$datos["asignatura"].'/'.$tema);
                                    $im = new Imagick ($imagickpath.'/'.$fileName."[0]");
                                    $im->setImageFormat("png");
                                    $im->writeImage($imagickpath.'/'.$nameFile.".png"); // fails with no error message
                                    //instead
                                    //file_put_contents ($path_folder."/test_0.jpg", $im); // works, or:
                                }
                                return response()->json(array('resultado'=> 'OK'));
                        }else{
                            return response()->json(array('resultado'=> 'existApunte'));
                        }
                    } catch (\Exception $e) {
                        return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
                    }
                }
            }
        }
    //Pagina apunte
        public function apuntes($id){
            if (session()->get('user')) {
                $apunte = DB::select("SELECT content.*,users.nick_usu,avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema 
                FROM tbl_contenidos content
                            INNER JOIN tbl_usuario users ON content.id_usu = users.id
                            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
                            LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                            LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                            LEFT JOIN tbl_temas temas ON temas.id = content.id_tema
                            LEFT JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                            LEFT JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                            LEFT JOIN tbl_centro centro ON centro.id = curso.id_centro
                            WHERE content.id = ?
                            GROUP BY content.id",[$id]);
                if ($apunte[0]->id_tema != null) {
                    $path = asset('storage/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido);
                }else{
                    $path = asset('storage/uploads/apuntes_reciclados/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido);
                }
                //return $path;
                $comentarios = DB::select("SELECT comment.*,user.nick_usu,avatar.img_avatar FROM tbl_comentarios comment
                INNER JOIN tbl_usuario user ON comment.id_usu = user.id
                LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
                WHERE comment.id_contenido = ?",[$apunte[0]->id]);
                return view('vistaApunte',compact('apunte','path','comentarios'));
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
                    if (count($apunte) == 0) {
                        $apunte = DB::select("SELECT * FROM tbl_contenidos WHERE id = ?",[$datos["id"]]);
                        $path = public_path('storage/uploads/apuntes_reciclados/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido);
                    }else{
                        $path = public_path('storage/uploads/apuntes/'.$apunte[0]->nombre_centro.'/'.$apunte[0]->nombre_curso.'/'.$apunte[0]->nombre_asignatura.'/'.$apunte[0]->nombre_tema.'/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido);
                    }
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
        public function comentar(Request $request){
            $datos = $request->except("_token");
            if (session()->get('user')) {
                $user = session()->get('user');
                $comentsameuser = DB::select("SELECT * FROM tbl_contenidos contenido 
                WHERE contenido.id=? AND contenido.id_usu = ?",[$datos["id_contenido"],$user->id]);
                if (count($comentsameuser) > 0) {
                    return response()->json(array("resultado"=>"SAME"));
                }else{
                    $comentagain = DB::select("SELECT * FROM tbl_comentarios WHERE id_contenido = ? AND id_usu = ?",[$datos["id_contenido"],$user->id]);
                    if (count($comentagain) > 0) {
                        return response()->json(array("resultado"=>"Comentado"));
                    }else{
                        DB::insert("INSERT INTO tbl_comentarios (desc_comentario,val_comentario,id_contenido,id_usu) VALUES (?,?,?,?)",[$datos["desc_comentario"],$datos["val_comentario"],$datos["id_contenido"],$user->id]);
                        $comentarios = DB::select("SELECT comment.*,user.nick_usu,avatar.img_avatar FROM tbl_comentarios comment
                                                INNER JOIN tbl_usuario user ON comment.id_usu = user.id
                                                LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
                                                WHERE comment.id_contenido = ?",[$datos["id_contenido"]]);
                        return response()->json(array("resultado"=>"OK","comentarios"=>$comentarios));
                    }
                }
            }else{
                return redirect('login');
            }
        }
        public function denunciarComentario(Request $request){
            $demandante = session()->get('user');
            $datos = $request->except("_token","_method");
            if ($datos["desc_denuncia"] == null) {
                return response()->json(array("resultado"=>"nullDenuncia"));
            }else{
                $existDenuncia = DB::select("SELECT * FROM tbl_denuncias WHERE id_comentario = ? AND id_demandante = ?",[$datos["id_comentario"],$demandante->id]);
                if (count($existDenuncia) != 0) {
                    return response()->json(array("resultado"=>"existDenuncia"));
                }else{
                    try {
                        DB::insert("INSERT INTO tbl_denuncias (tipus_denuncia,desc_denuncia,id_contenido,id_comentario,id_demandante,id_acusado) VALUES (?,?,?,?,?,?)",["Comentario",$datos["desc_denuncia"],$datos["id_contenido"],$datos["id_comentario"],$demandante->id,$datos["id_acusado"]]);
                        return response()->json(array("resultado"=>"OK"));
                    } catch (\Exception $e) {
                        return response()->json(array("resultado"=>"NOK: ".$e->getMessage()));
                    }
                }
            }
            return response()->json($datos);
        }
        public function denunciarApunte(Request $request){
            $demandante = session()->get('user');
            $datos = $request->except("_token","_method");
            if ($datos["desc_denuncia"] == null) {
                return response()->json(array("resultado"=>"nullDenuncia"));
            }else{
                $existDenuncia = DB::select("SELECT * FROM tbl_denuncias WHERE id_contenido = ? AND id_demandante = ?",[$datos["id_contenido"],$demandante->id]);
                if (count($existDenuncia) != 0) {
                    return response()->json(array("resultado"=>"existDenuncia"));
                }else{
                    try {
                        DB::insert("INSERT INTO tbl_denuncias (tipus_denuncia,desc_denuncia,id_contenido,id_demandante,id_acusado) VALUES (?,?,?,?,?)",["Apunte",$datos["desc_denuncia"],$datos["id_contenido"],$demandante->id,$datos["id_acusado"]]);
                        return response()->json(array("resultado"=>"OK"));
                    } catch (\Exception $e) {
                        return response()->json(array("resultado"=>"NOK: ".$e->getMessage()));
                    }
                }
            }
            return response()->json($datos);
        }
}
