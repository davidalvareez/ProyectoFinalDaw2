<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\RegisterValidation;
use Illuminate\Support\Facades\MAIL;
use App\Mail\sendMail;

class CRUDAdminController extends Controller
{
//Mostrar
    /* VistaAdmin */
        public function adminView(){
            if (session()->has('user')) {
                $userAdmin = session()->get('user');
                if ($userAdmin->id_rol == 1) {
                    return view("admin");
                }
            }
            return redirect('/');
        }
    /* MostrarUsuarios */
        public function showUsers(Request $request){
            if (session()->has('user')) {
                $idUsuario = session()->get('user');
            }
            $users = DB::select("SELECT tbl_usuario.id, tbl_usuario.nick_usu, tbl_usuario.nombre_usu, tbl_usuario.apellido_usu, tbl_usuario.fecha_nac_usu,
            tbl_usuario.correo_usu, tbl_usuario.deshabilitado,tbl_centro.nombre_centro, tbl_rol.nombre_rol, tbl_niveles.nombre_nivel,tbl_avatar.img_avatar
            FROM tbl_usuario INNER JOIN tbl_rol ON tbl_usuario.id_rol = tbl_rol.id
            LEFT JOIN tbl_centro ON tbl_usuario.id_centro = tbl_centro.id
            LEFT JOIN tbl_niveles ON tbl_usuario.id_nivel = tbl_niveles.id
            LEFT JOIN tbl_avatar ON tbl_usuario.id = tbl_avatar.id_usu
            WHERE NOT tbl_usuario.id = ? AND nick_usu LIKE ?",[$idUsuario->id,'%'.$request["filter"].'%']);
            return response()->json($users);
        }
    /* MostrarCentros */     
        public function showCentros(Request $request){
            $centros = DB::select("SELECT * FROM tbl_centro WHERE nombre_centro LIKE ? OR ciudad_centro LIKE ?", ['%'.$request["filter"].'%','%'.$request["filter"].'%']);
            return response()->json($centros);
        }
    /* MostrarCursos */
        public function showCursos(Request $request, $id){
            $cursos = DB::select("SELECT * FROM tbl_centro INNER JOIN tbl_cursos ON tbl_centro.id = tbl_cursos.id_centro
            WHERE tbl_centro.id = ? AND nombre_curso LIKE ?",[$id,'%'.$request["filter"].'%']);
            return response()->json($cursos);   
        }
    /* MostrarAsignaturas */
        public function showAsignaturas(Request $request, $id){
            $asignaturas = DB::select("SELECT * FROM tbl_cursos INNER JOIN tbl_asignaturas ON tbl_cursos.id = tbl_asignaturas.id_curso
            WHERE tbl_cursos.id = ? AND nombre_asignatura LIKE ?",[$id,'%'.$request["filter"].'%']);
            return response()->json($asignaturas);
        }
    /* MostrarTemas */
        public function showTemas(Request $request, $id){
            $temas = DB::select("SELECT * FROM tbl_asignaturas INNER JOIN tbl_temas ON tbl_asignaturas.id = tbl_temas.id_asignatura
            WHERE tbl_asignaturas.id = ? AND nombre_tema LIKE ?",[$id,'%'.$request["filter"].'%']);
            return response()->json($temas);
        }
    /* MostrarApuntes */
        public function showApuntes(Request $request){
            $apuntes = DB::select("SELECT apuntes.*,usu.nombre_usu,usu.apellido_usu FROM tbl_contenidos apuntes INNER JOIN tbl_usuario usu ON usu.id = apuntes.id_usu WHERE nombre_contenido LIKE ?", ['%'.$request["filter"].'%']);
            return response()->json($apuntes);
        }
    /* MostrarDenuncias */
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
    /* MostrarHistorial */
        public function showHistorial(){
            $historial = DB::select("SELECT * FROM tbl_historial
            INNER JOIN tbl_usuario ON tbl_usuario.id = tbl_historial.id_usu
            INNER JOIN tbl_contenidos ON tbl_contenidos.id = tbl_historial.id_contenido");
            return response()->json($historial);
        }

//Crear
    /* CrearCentro */
        public function crearCentro(Request $request){ 
            $datos=$request->except("_token");
            try{
                DB::insert("INSERT INTO tbl_centro (nombre_centro, pais_centro, com_auto_centro, ciudad_centro, direccion_centro) VALUES (?,?,?,?,?)",[$datos["nombre_centro"],$datos["pais_centro"],$datos["com_auto_centro"],$datos["ciudad_centro"],$datos["direccion_centro"]]);
                Storage::makeDirectory('public/uploads/apuntes/'.$datos["nombre_centro"]);
                return response()->json(array('resultado'=> 'OK'));
            }catch(\Throwable $th) {
                return response()->json(array('resultado'=> 'NOK: '.$th->getMessage()));
            }
        }

    /* CrearCursos */
        public function crearCurso(Request $request){ 
            $datos=$request->except("_token");
            try{
                DB::beginTransaction();
                DB::insert("INSERT INTO tbl_cursos (nombre_curso, nombre_corto_curso, tipo_curso, id_centro) VALUES (?,?,?,?)",[$datos["nombre_curso"],$datos["nombre_corto_curso"],$datos["tipo_curso"],$datos["id_centro"]]);
                $nombre_centro=DB::select("SELECT nombre_centro FROM tbl_centro WHERE id = ?",[$datos["id_centro"]]);
                Storage::makeDirectory('public/uploads/apuntes/'.$nombre_centro[0]->nombre_centro.'/'.$datos["nombre_curso"]);
                DB::commit();
                return response()->json(array('resultado'=> 'OK'));
            }catch(\Throwable $th) {
                DB::rollBack();
                return response()->json(array('resultado'=> 'NOK: '.$th->getMessage()));
            }
        }

    /* CrearAsignaturas */
        public function crearAsignatura(Request $request){ 
            $datos=$request->except("_token");
            try{
                DB::beginTransaction();
                DB::insert("INSERT INTO tbl_asignaturas (nombre_asignatura, id_curso) VALUES (?,?)",[$datos["nombre_asignatura"],$datos["id_curso"]]);
                $nombre_centro=DB::select("SELECT nombre_centro FROM tbl_centro WHERE id = ?",[$datos["id_centro"]]);
                $nombre_curso=DB::select("SELECT nombre_curso FROM tbl_cursos WHERE id = ?",[$datos["id_curso"]]);
                Storage::makeDirectory('public/uploads/apuntes/'.$nombre_centro[0]->nombre_centro.'/'.$nombre_curso[0]->nombre_curso.'/'.$datos["nombre_asignatura"]);
                DB::commit();
                return response()->json(array('resultado'=> 'OK'));
            }catch(\Throwable $th) {
                DB::rollBack();
                return response()->json(array('resultado'=> 'NOK: '.$th->getMessage()));
            }
        }

    /* CrearTemas */
        public function crearTema(Request $request){ 
            $datos=$request->except("_token");
            try{
                DB::beginTransaction();
                DB::insert("INSERT INTO tbl_temas (nombre_tema, id_asignatura) VALUES (?,?)",[$datos["nombre_tema"],$datos["id_asignatura"]]);
                $nombre_asignatura=DB::select("SELECT nombre_asignatura FROM tbl_asignaturas WHERE id = ?",[$datos["id_asignatura"]]);
                $nombre_centro=DB::select("SELECT nombre_centro FROM tbl_centro WHERE id = ?",[$datos["id_centro"]]);
                $nombre_curso=DB::select("SELECT nombre_curso FROM tbl_cursos WHERE id = ?",[$datos["id_curso"]]);
                Storage::makeDirectory('public/uploads/apuntes/'.$nombre_centro[0]->nombre_centro.'/'.$nombre_curso[0]->nombre_curso.'/'.$nombre_asignatura[0]->nombre_asignatura.'/'.$datos["nombre_tema"]);
                DB::commit();
                return response()->json(array('resultado'=> 'OK'));
            }catch(\Throwable $th) {
                DB::rollBack();
                return response()->json(array('resultado'=> 'NOK: '.$th->getMessage()));
            }
        }
//Actualizar
    /* ActualizarCentro */
        public function actualizarCentro(Request $request){  
            $datos=$request->except("_token");
            try {
                DB::update("UPDATE tbl_centro set nombre_centro= ?, pais_centro= ?, com_auto_centro= ?, ciudad_centro= ?, direccion_centro= ? where id=?",[$datos["nombre"],$datos["pais"],$datos["com_auto"],$datos["ciudad"],$datos["direccion"],$datos["id_centro"]]);
                if ($datos["nombre_antiguo"] != $datos["nombre"]) {
                    Storage::move('public/uploads/apuntes/'.$datos["nombre_antiguo"], 'public/uploads/apuntes/'.$datos["nombre"]);
                }
                return response()->json(array('resultado'=> 'OK'));
            } catch (\Throwable $th) {
                    return response()->json(array('resultado'=> 'NOK: '.$th->getMessage()));
            }
        }
    /* ActualizarCurso */
        public function actualizarCurso(Request $request){  
            $datos=$request->except("_token");
            try {  
                DB::beginTransaction();
                DB::update("UPDATE tbl_cursos set nombre_curso= ?, nombre_corto_curso= ?, tipo_curso= ? where id=?",[$datos["nombre_curso"],$datos["nombre_corto_curso"],$datos["tipo_curso"],$datos["id"]]);
                $nombre_centro=DB::select("SELECT nombre_centro FROM tbl_centro WHERE id = ?",[$datos["id_centro"]]);
                if ($datos["nombre_antiguo"] != $datos["nombre_curso"]) {
                    Storage::move('public/uploads/apuntes/'.$nombre_centro[0]->nombre_centro.'/'.$datos["nombre_antiguo"], 'public/uploads/apuntes/'.$nombre_centro[0]->nombre_centro.'/'.$datos["nombre_curso"]);
                }
                DB::commit();
                return response()->json(array('resultado'=> 'OK'));
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(array('resultado'=> 'NOK: '.$th->getMessage()));
            }
        }
    /* ActualizarAsignatura */
        public function actualizarAsignatura(Request $request){  
            $datos=$request->except("_token");
            try {  
                DB::beginTransaction();
                DB::update("UPDATE tbl_asignaturas set nombre_asignatura= ? where id=?",[$datos["nombre_asignatura"],$datos["id"]]);
                $nombre_centro=DB::select("SELECT nombre_centro FROM tbl_centro WHERE id = ?",[$datos["id_centro"]]);
                $nombre_curso=DB::select("SELECT nombre_curso FROM tbl_cursos WHERE id = ?",[$datos["id_curso"]]);
                if ($datos["nombre_antiguo"] != $datos["nombre_asignatura"]) {
                    Storage::move('public/uploads/apuntes/'.$nombre_centro[0]->nombre_centro.'/'.$nombre_curso[0]->nombre_curso.'/'.$datos["nombre_antiguo"], 'public/uploads/apuntes/'.$nombre_centro[0]->nombre_centro.'/'.$nombre_curso[0]->nombre_curso.'/'.$datos["nombre_asignatura"]);
                }
                DB::commit();
                return response()->json(array('resultado'=> 'OK'));
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(array('resultado'=> 'NOK: '.$th->getMessage()));
            }
        }
    /* ActualizarTema */
        public function actualizarTema(Request $request){  
            $datos=$request->except("_token");
            try { 
                DB::beginTransaction(); 
                DB::update("UPDATE tbl_temas set nombre_tema= ? where id=?",[$datos["nombre_tema"],$datos["id"]]);
                $nombre_centro=DB::select("SELECT nombre_centro FROM tbl_centro WHERE id = ?",[$datos["id_centro"]]);
                $nombre_curso=DB::select("SELECT nombre_curso FROM tbl_cursos WHERE id = ?",[$datos["id_curso"]]);
                $nombre_asignatura=DB::select("SELECT nombre_asignatura FROM tbl_asignaturas WHERE id = ?",[$datos["id_asignatura"]]);
                if ($datos["nombre_antiguo"] != $datos["nombre_tema"]) {
                    Storage::move('public/uploads/apuntes/'.$nombre_centro[0]->nombre_centro.'/'.$nombre_curso[0]->nombre_curso.'/'.$nombre_asignatura[0]->nombre_asignatura.'/'.$datos["nombre_antiguo"], 'public/uploads/apuntes/'.$nombre_centro[0]->nombre_centro.'/'.$nombre_curso[0]->nombre_curso.'/'.$nombre_asignatura[0]->nombre_asignatura.'/'.$datos["nombre_tema"]);
                }
                DB::commit();
                return response()->json(array('resultado'=> 'OK'));
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(array('resultado'=> 'NOK: '.$th->getMessage()));
            }
        }
    /* ActualizarUsuario */
        public function actualizarUsuario(Request $request){  
            /* return response()->json($request); */
            try {  
                    $rol=DB::select("SELECT * FROM tbl_rol WHERE nombre_rol= ?",[$request["nombre_rol"]]);
                    /* return $rol; */
                    if ($request["deshabilitado"] == null && $request["tmpdeshabilitado"] == null) {
                        $datetime = null;
                    }else{
                        $datetime = $request["deshabilitado"].' '.$request["tmpdeshabilitado"];
                    }
                    DB::update("UPDATE tbl_usuario set nick_usu= ?, nombre_usu= ?, apellido_usu= ?, fecha_nac_usu= ?, correo_usu= ?, deshabilitado= ?, id_rol= ? where id=?",[$request["nick_usu"],$request["nombre_usu"],$request["apellido_usu"],$request["fecha_nac_usu"],$request["correo_usu"],$datetime,$rol[0]->id,$request["id"]]);
                    /* return response()->json($update); */
                return response()->json(array('resultado'=> 'OK'));
            } catch (\Throwable $th) {
                    return response()->json(array('resultado'=> 'NOK: '.$th->getMessage()));
            }
        }

//Eliminar
    /* EliminarUsers */
        public function eliminarUser($id){
            $user= session()->get('user');
                try{
                    //Cogemos si tiene alguno del sistema para no borrarlo.
                        $userImage = DB::select("SELECT * FROM tbl_avatar WHERE id_usu = ?",[$id]);
                        $userImage = $userImage[0]->img_avatar;
                        $avataresSistema = DB::select("SELECT * FROM tbl_avatar WHERE id_usu = ?",[null]);
                        $isAvatarSistema = false;
                        foreach ($avataresSistema as $avatarSistema){
                            if ($avatarSistema->img_avatar == $userImage) {
                                $isAvatarSistema = true;
                            }
                        }
                        //Comprobamos si es avatar del sistema
                        if ($isAvatarSistema == false) {
                            if (file_exists(storage_path('app/public/'.$userImage))) {
                                Storage::delete('public/'.$userImage);
                            }
                        }
                DB::beginTransaction();
                $exitDenuncia =DB::select("SELECT * FROM tbl_denuncias WHERE id_demandante= ? or id_acusado = ?",[$id,$id]);
                if (count($exitDenuncia) != 0) {
                    DB::delete("DELETE FROM tbl_denuncias WHERE id_demandante= ? or id_acusado = ?",[$id,$id]);
                }
                $existComment = DB::SELECT("SELECT * FROM tbl_comentarios WHERE id_usu = ?",[$id]);
                if (count($existComment) != 0) {
                    DB::delete("DELETE FROM tbl_comentarios WHERE id_usu= ?",[$id]);
                }
                $existHistorial = DB::select("SELECT * FROM tbl_historial WHERE id_usu = ?",[$id]);
                if (count($existHistorial) != 0) {
                    DB::delete("DELETE FROM tbl_historial WHERE id_usu= ?",[$id]);
                }

                $apuntes = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.nombre_tema FROM tbl_usuario usu 
                INNER JOIN tbl_centro centro ON usu.id_centro = centro.id
                INNER JOIN tbl_cursos curso ON centro.id = curso.id_centro
                INNER JOIN tbl_asignaturas asig ON curso.id = asig.id_curso
                INNER JOIN tbl_temas temas ON asig.id = temas.id_asignatura
                INNER JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
                WHERE apuntes.id_usu =  ?",[$id]);
                foreach ($apuntes as $apunte) {
                    DB::delete("DELETE FROM tbl_multimedia WHERE id = ?",[$apunte->id]);
                    $pathPDF = 'public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido;
                    $pathIMG = 'public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.'.png';
                    Storage::delete($pathPDF);
                    Storage::delete($pathIMG);
                }
                $newuser = DB::select("SELECT * FROM tbl_usuario WHERE id = ?",[$id]);
                $newuser=$newuser[0];
                $sub = "Tu cuenta ha sido eliminada 😭";
                $msj = "Tu cuenta ha sido eliminada por un administrador, si quieres volver a acceder tendras que crearte una cuenta nueva";
                $datos = array('message'=>$msj);
                $enviar = new sendMail($datos);
                $enviar->sub = $sub;
                Mail::to($newuser->correo_usu)->send($enviar);
                Storage::delete('public/uploads/configuration/user-'.$id.'.json');
                DB::delete("DELETE FROM tbl_contenidos WHERE id_usu= ?",[$id]);
                DB::delete("DELETE FROM tbl_avatar WHERE id_usu= ?",[$id]);
                DB::delete("DELETE FROM tbl_estudios WHERE id_usu= ?",[$id]);
                DB::delete("DELETE FROM chats WHERE user_id= ?",[$user->id]);
                DB::delete("DELETE FROM chats WHERE friend_id= ?",[$user->id]);
                DB::delete("DELETE FROM friend WHERE user_id= ?",[$user->id]);
                DB::delete("DELETE FROM friend WHERE friend_id= ?",[$user->id]);
                DB::delete("DELETE FROM tbl_usuario WHERE id= ?",[$id]);
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
    /* EliminarHistorial */
        public function eliminarHistorial($id){
            try{
                DB::beginTransaction();
                DB::select("DELETE FROM tbl_historial WHERE id= ?",[$id]);              
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
    /* EliminarCentro */
        public function eliminarCentro($id){
            try {
                DB::beginTransaction();
                $id_curso = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.id as id_curso,curso.nombre_curso,asig.nombre_asignatura,temas.id as id_tema,temas.nombre_tema FROM tbl_centro centro 
                LEFT JOIN tbl_cursos curso ON curso.id_centro = centro.id
                LEFT JOIN tbl_asignaturas asig ON asig.id_curso = curso.id
                LEFT JOIN tbl_temas temas ON temas.id_asignatura = asig.id
                LEFT JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
                WHERE centro.id =  ? GROUP BY apuntes.nombre_contenido",[$id]);
                
                //Traspasamos todos los apuntes a reciclaje antes de eliminarlos
                if ($id_curso != null) {
                    foreach ($id_curso as $apunte){
                        if ($apunte->nombre_contenido != null) {
                            if (file_exists(storage_path('app/public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido))) {
                                if ($apunte->extension_contenido == ".pdf") {
                                    Storage::move('public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.".png", 'public/uploads/apuntes_reciclados/'.$apunte->nombre_contenido.".png");
                                }
                                Storage::move('public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido, 'public/uploads/apuntes_reciclados/'.$apunte->nombre_contenido.$apunte->extension_contenido);
                            }
                        }
                    }
                //Eliminamos la carpeta
                    $pathFolder = 'public/uploads/apuntes/'.$id_curso[0]->nombre_centro;
                    Storage::deleteDirectory($pathFolder);
                    foreach ($id_curso as $curso){
                        $id_asignatura = DB::select("SELECT id FROM tbl_asignaturas WHERE id_curso= ?",[$curso->id_curso]);
                        foreach ($id_asignatura as $asignatura) { 
                            $id_tema=DB::select("SELECT id FROM tbl_temas WHERE id_asignatura= ?",[$asignatura->id]);
                            foreach ($id_tema as $tema) {
                                DB::update("UPDATE tbl_contenidos SET id_tema = NULL WHERE tbl_contenidos.id_tema = ?",[$tema->id]);
                                DB::delete("DELETE FROM tbl_temas WHERE id= ?",[$tema->id]);
                            }
                            DB::delete("DELETE FROM tbl_asignaturas WHERE id= ?",[$asignatura->id]); 
                        } 
                        DB::delete("DELETE FROM tbl_estudios WHERE id_curso= ?",[$curso->id_curso]);
                        DB::delete("DELETE FROM tbl_cursos WHERE id= ?",[$curso->id_curso]);
                    }
                }
                DB::update("UPDATE tbl_usuario SET id_centro = NULL WHERE id_centro = ?",[$id]); 
                DB::delete("DELETE FROM tbl_centro WHERE id = ?",[$id]);
                DB::commit();
                return response()->json(array('resultado'=>"OK"));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
    /* EliminarCurso */
        public function eliminarCurso($id){
            try{
                DB::beginTransaction();
                $id_asignatura=DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.id as id_asignatura,asig.nombre_asignatura,temas.id as id_tema,temas.nombre_tema FROM tbl_centro centro 
                LEFT JOIN tbl_cursos curso ON curso.id_centro = centro.id
                LEFT JOIN tbl_asignaturas asig ON asig.id_curso = curso.id
                LEFT JOIN tbl_temas temas ON temas.id_asignatura = asig.id
                LEFT JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
                WHERE curso.id =  ? GROUP BY apuntes.nombre_contenido",[$id]);
                //Traspasamos todos los apuntes a reciclaje antes de eliminarlos
                if ($id_asignatura != null) {
                    foreach ($id_asignatura as $apunte){
                        if ($apunte->nombre_contenido != null) {
                            if (file_exists(storage_path('app/public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido))) {
                                if ($apunte->extension_contenido == ".pdf") {
                                    Storage::move('public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.".png", 'public/uploads/apuntes_reciclados/'.$apunte->nombre_contenido.".png");
                                }
                                Storage::move('public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido, 'public/uploads/apuntes_reciclados/'.$apunte->nombre_contenido.$apunte->extension_contenido);
                            }
                        }
                    }
                    //Eliminamos la carpeta
                    $pathFolder = 'public/uploads/apuntes/'.$id_asignatura[0]->nombre_centro.'/'.$id_asignatura[0]->nombre_curso;
                    Storage::deleteDirectory($pathFolder);
                    foreach ($id_asignatura as $asignatura) { 
                        $id_tema=DB::select("SELECT id FROM tbl_temas WHERE id_asignatura= ?",[$asignatura->id_asignatura]);
                        foreach ($id_tema as $tema) {
                            DB::update("UPDATE tbl_contenidos SET id_tema = NULL WHERE tbl_contenidos.id_tema = ?",[$tema->id]);
                            DB::delete("DELETE FROM tbl_temas WHERE id= ?",[$tema->id]);
                        }
                        DB::delete("DELETE FROM tbl_asignaturas WHERE id= ?",[$asignatura->id_asignatura]); 
                    } 
                }
                
                DB::delete("DELETE FROM tbl_estudios WHERE id_curso= ?",[$id]);
                DB::delete("DELETE FROM tbl_cursos WHERE id= ?",[$id]);
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
    /* EliminarAsignatura */
        public function eliminarAsignatura($id){
            try{
                DB::beginTransaction();
                $id_tema = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.id as id_tema,temas.nombre_tema FROM tbl_centro centro 
                LEFT JOIN tbl_cursos curso ON curso.id_centro = centro.id
                LEFT JOIN tbl_asignaturas asig ON asig.id_curso = curso.id
                LEFT JOIN tbl_temas temas ON temas.id_asignatura = asig.id
                LEFT JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
                WHERE asig.id =  ? GROUP BY apuntes.nombre_contenido",[$id]);
                //Traspasamos todos los apuntes a reciclaje antes de eliminarlos
                if ($id_tema != null) {
                    foreach ($id_tema as $apunte){
                        if ($apunte->nombre_contenido != null) {
                            if (file_exists(storage_path('app/public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido))) {
                                if ($apunte->extension_contenido == ".pdf") {
                                    Storage::move('public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.".png", 'public/uploads/apuntes_reciclados/'.$apunte->nombre_contenido.".png");
                                }
                                Storage::move('public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido, 'public/uploads/apuntes_reciclados/'.$apunte->nombre_contenido.$apunte->extension_contenido);
                            }
                        }
                    }
                    //Eliminamos la carpeta
                    $pathFolder = 'public/uploads/apuntes/'.$id_tema[0]->nombre_centro.'/'.$id_tema[0]->nombre_curso.'/'.$id_tema[0]->nombre_asignatura;
                    Storage::deleteDirectory($pathFolder);
                    foreach ($id_tema as $tema) {
                        DB::select("UPDATE tbl_contenidos SET id_tema = NULL WHERE tbl_contenidos.id_tema = ?",[$tema->id_tema]);
                        DB::select("DELETE FROM tbl_temas WHERE id= ?",[$tema->id_tema]); 
                    } 
                }
                DB::select("DELETE FROM tbl_asignaturas WHERE id= ?",[$id]);                
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
    /* EliminarTema */
        public function eliminarTema($id){
            try{
                DB::beginTransaction(); 
                $apuntes = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.id as id_tema,temas.nombre_tema FROM tbl_centro centro 
                LEFT JOIN tbl_cursos curso ON curso.id_centro = centro.id
                LEFT JOIN tbl_asignaturas asig ON asig.id_curso = curso.id
                LEFT JOIN tbl_temas temas ON temas.id_asignatura = asig.id
                LEFT JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
                WHERE temas.id =  ? GROUP BY apuntes.nombre_contenido",[$id]);
                //Traspasamos todos los apuntes a reciclaje antes de eliminarlos
                if ($apuntes != null) {
                    foreach ($apuntes as $apunte){
                        if ($apunte->nombre_contenido != null) {
                            if (file_exists(storage_path('app/public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido))) {
                                if ($apunte->extension_contenido == ".pdf") {
                                    Storage::move('public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.".png", 'public/uploads/apuntes_reciclados/'.$apunte->nombre_contenido.".png");
                                }
                                Storage::move('public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido, 'public/uploads/apuntes_reciclados/'.$apunte->nombre_contenido.$apunte->extension_contenido);
                            }
                        }
                    }   
                    //Eliminamos la carpeta
                    $pathFolder = 'public/uploads/apuntes/'.$apuntes[0]->nombre_centro.'/'.$apuntes[0]->nombre_curso.'/'.$apuntes[0]->nombre_asignatura;
                    Storage::deleteDirectory($pathFolder);
                }
                DB::select("UPDATE tbl_contenidos SET id_tema = NULL WHERE tbl_contenidos.id_tema = ?",[$id]); 
                DB::select("DELETE FROM tbl_temas WHERE id= ?",[$id]);   
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
    /* EliminarApunte */
        public function eliminarApunte($id){
            try{
                DB::beginTransaction();         
                $exitDenuncia =DB::select("SELECT * FROM tbl_denuncias WHERE id_contenido = ?",[$id]);
                if (count($exitDenuncia) != 0) {
                    DB::delete("DELETE FROM tbl_denuncias WHERE id_contenido = ?",[$id]);
                }
                $existComment = DB::SELECT("SELECT * FROM tbl_comentarios WHERE id_contenido = ?",[$id]);
                if (count($existComment) != 0) {
                    DB::delete("DELETE FROM tbl_comentarios WHERE id_contenido = ?",[$id]);
                }
                $existMultimedia = DB::select("SELECT * FROM tbl_multimedia WHERE id = ?",[$id]);
                if (count($existMultimedia) != 0) {
                    DB::delete("DELETE FROM tbl_multimedia WHERE id = ?",[$id]);
                }
                $existHistorial = DB::select("SELECT * FROM tbl_historial WHERE id_contenido = ?",[$id]);
                if (count($existHistorial) != 0) {
                    DB::delete("DELETE FROM tbl_historial WHERE id_contenido = ?",[$id]);
                }
                $apunte = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.nombre_tema FROM tbl_usuario usu 
                LEFT JOIN tbl_centro centro ON usu.id_centro = centro.id
                LEFT JOIN tbl_cursos curso ON centro.id = curso.id_centro
                LEFT JOIN tbl_asignaturas asig ON curso.id = asig.id_curso
                LEFT JOIN tbl_temas temas ON asig.id = temas.id_asignatura
                LEFT JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
                WHERE apuntes.id =  ? GROUP BY apuntes.nombre_contenido",[$id]);
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
                $user = DB::select("SELECT * FROM tbl_usuario WHERE id = ?",[$apunte[0]->id_usu]);
                $user=$user[0];
                $sub = "Tu apunte fue eliminado de nuestra pagina 😥";
                $msj = "El documento '" .$apunte[0]->nombre_contenido."".$apunte[0]->extension_contenido. "' no respetaba la política de seguridad y privacidad de la página por lo cual, el equipo administrador de Note Hub tuvo que reprender la acción de suprimir el archivo. 
                        Un cordial saludo, Note Hub";
                $datos = array('message'=>$msj);
                $enviar = new sendMail($datos);
                $enviar->sub = $sub;
                Mail::to($user->correo_usu)->send($enviar);
                
                DB::delete("DELETE FROM tbl_contenidos WHERE id= ?",[$id]);
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
}
