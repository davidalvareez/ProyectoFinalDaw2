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
        public function showUsers(){
            if (session()->has('user')) {
                $idUsuario = session()->get('user');
            }

            $users = DB::select("SELECT tbl_usuario.id, tbl_usuario.nick_usu, tbl_usuario.nombre_usu, tbl_usuario.apellido_usu, tbl_usuario.fecha_nac_usu,
            tbl_usuario.correo_usu, tbl_usuario.deshabilitado,tbl_centro.nombre_centro, tbl_rol.nombre_rol, tbl_niveles.nombre_nivel,tbl_avatar.img_avatar
            FROM tbl_usuario INNER JOIN tbl_rol ON tbl_usuario.id_rol = tbl_rol.id
            LEFT JOIN tbl_centro ON tbl_usuario.id_centro = tbl_centro.id
            LEFT JOIN tbl_niveles ON tbl_usuario.id_nivel = tbl_niveles.id
            LEFT JOIN tbl_avatar ON tbl_usuario.id = tbl_avatar.id_usu
            WHERE NOT tbl_usuario.id = ? ",[$idUsuario->id]);
            return response()->json($users);
        }
    /* MostrarCentros */     
        public function showCentros(){
            $centros = DB::select("SELECT * FROM tbl_centro");
            return response()->json($centros);
        }
    /* MostrarCursos */
        public function showCursos($id){
            $cursos = DB::select("SELECT * FROM tbl_centro INNER JOIN tbl_cursos ON tbl_centro.id = tbl_cursos.id_centro
            WHERE tbl_centro.id = ? ",[$id]);
            return response()->json($cursos);
        }
    /* MostrarAsignaturas */
        public function showAsignaturas($id){
            $asignaturas = DB::select("SELECT * FROM tbl_cursos INNER JOIN tbl_asignaturas ON tbl_cursos.id = tbl_asignaturas.id_curso
            WHERE tbl_cursos.id = ? ",[$id]);
            return response()->json($asignaturas);
        }
    /* MostrarTemas */
        public function showTemas($id){
            $temas = DB::select("SELECT * FROM tbl_asignaturas INNER JOIN tbl_temas ON tbl_asignaturas.id = tbl_temas.id_asignatura
            WHERE tbl_asignaturas.id = ? ",[$id]);
            return response()->json($temas);
        }
    /* MostrarApuntes */
        public function showApuntes(){
            $apuntes = DB::select("SELECT apuntes.*,usu.nombre_usu,usu.apellido_usu FROM tbl_contenidos apuntes INNER JOIN tbl_usuario usu ON usu.id = apuntes.id_usu");
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
            try{
                DB::beginTransaction();
                DB::delete("DELETE FROM tbl_denuncias WHERE id_demandante= ? or id_acusado = ?",[$id,$id]);
                DB::delete("DELETE FROM tbl_comentarios WHERE id_usu= ?",[$id]);
                DB::delete("DELETE FROM tbl_historial WHERE id_usu= ?",[$id]);
                DB::delete("DELETE FROM tbl_contenidos WHERE id_usu= ?",[$id]);
                DB::delete("DELETE FROM tbl_avatar WHERE id_usu= ?",[$id]);
                DB::delete("DELETE FROM tbl_usuario WHERE id= ?",[$id]);
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
    /* EliminarDenuncia */
        public function eliminarDenuncia($id){
            try{
                DB::beginTransaction();
                DB::select("DELETE FROM tbl_denuncias WHERE id= ?",[$id]);              
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
    /* EliminarCurso */
        public function eliminarCurso($id){
            try{
                DB::beginTransaction();
                $id_asignatura=DB::select("SELECT id FROM tbl_asignaturas WHERE id_curso= ?",[$id]); 
                foreach ($id_asignatura as $asignatura) { 
                    $id_tema=DB::select("SELECT id FROM tbl_temas WHERE id_asignatura= ?",[$asignatura->id]);
                    foreach ($id_tema as $tema) {
                        DB::select("UPDATE tbl_contenidos SET id_tema = NULL WHERE tbl_contenidos.id_tema = ?",[$tema->id]);
                        DB::select("DELETE FROM tbl_temas WHERE id= ?",[$tema->id]);
                    }
                    DB::select("DELETE FROM tbl_asignaturas WHERE id= ?",[$asignatura->id]); 
                    } 
                DB::select("DELETE FROM tbl_cursos WHERE id= ?",[$id]);
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
                $id_tema=DB::select("SELECT id FROM tbl_temas WHERE id_asignatura= ?",[$id]);
                foreach ($id_tema as $tema) {
                    DB::select("UPDATE tbl_contenidos SET id_tema = NULL WHERE tbl_contenidos.id_tema = ?",[$tema->id]);
                    DB::select("DELETE FROM tbl_temas WHERE id= ?",[$tema->id]); 
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
                DB::select("DELETE FROM tbl_denuncias WHERE id_contenido= ?",[$id]);
                DB::select("DELETE FROM tbl_comentarios WHERE id_contenido= ?",[$id]);
                DB::select("DELETE FROM tbl_historial WHERE id_contenido= ?",[$id]);
                DB::select("DELETE FROM tbl_contenidos WHERE id= ?",[$id]);                
                
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json(array('resultado'=>$e->getMessage()));
            }
        }
}
