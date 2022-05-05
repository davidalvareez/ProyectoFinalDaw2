<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\RegisterValidation;

class UsuarioController extends Controller
{
    //Login + registro
    //Funciones view para hacer funciones + formulario
    public function loginView(){
        return view('login');
    }

    public function registerView(){
        $avatares = DB::select("SELECT * FROM tbl_avatar WHERE tipo_avatar = 'Sistema'");
        $centros = DB::select("SELECT * FROM tbl_centro");
        //return $avatares;
        return view('register',compact('avatares','centros'));
    }

    //Funciones de hacer login y registro
    public function login(LoginValidation $request){
        $datos=$request->except("_token");
        //Contraseña convertida a md5
        $password = md5($datos["contra_usu"]);
        //Sentencia que exista el usuario
        try {
            $user = DB::select("SELECT * FROM tbl_usuario WHERE (correo_usu = ? or nick_usu = ?) AND contra_usu = ?",[$datos["correo_nick"],$datos["correo_nick"],$password]);
            //Coger la longitud del array si coge 1 esta bien en caso contrario mal
            $existUser = count($user);
            //Si es 0 login incorrecto
            if ($existUser == 0) {
                //Mandarlo al login conforme usuario y contraseña incorrecto
                return "Mal";
            //En caso contrario comprovamos lo siguiente
            }else{
                $user = $user[0];
                //date_default_timezone_set("Europe/Madrid");
                $sysDate = date('Y-m-d H:i:s');
                //Una vez dentro cogemos fecha actual del sistema
                //Si no está baneado es decir es nulo para dentro
                if ($user->deshabilitado == null) {
                    session()->put("user",$user);
                    if ($user->id_rol == 1) {
                        return redirect("admin");
                    }elseif($user->id_rol == 2){
                        return redirect("moderador");
                    }else{
                        return redirect("buscador");
                    }
                }else{
                    //Si esta baneado validamos entre fecha/hora actual y el baneo y si el sistema es mayor o igual lo ponemos a nulo y lo devolvemos a la vista
                    $timeBanned = $user->deshabilitado;
                    if ($timeBanned <= $sysDate) {
                        DB::select('UPDATE tbl_usuario SET deshabilitado=null where id = ?',[$user->id]);
                        session()->put("user",$user);
                        if ($user->id_rol == 1) {
                            return redirect("admin");
                        }elseif($user->id_rol == 2){
                            return redirect("moderador");
                        }else{
                            return redirect("buscador");
                        }
                    }else{
                        return "Sigues baneado";
                    }
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function register(RegisterValidation $request){
        $datos=$request->except("_token");
        //Contraseña convertida a md5
        /* return $datos; */
        $password = md5($datos["contra_usu"]);
        if ($request->hasFile('img_avatar_usu2')) {
            $file = $request->file('img_avatar_usu2')->store('uploads/avatar','public');
            /* return $file; */
        }else{
            $file = $datos["img_avatar_sistema"];
            /* return $datos; */
        }
        //Sentencia de creacion de usuario
        try {
            $id=DB::table("tbl_usuario")->insertGetId(["nick_usu"=>$datos['nick_usu'],"nombre_usu"=>$datos['nombre_usu'],"apellido_usu"=>$datos['apellido_usu'],"fecha_nac_usu"=>$datos['fecha_nac_usu'],"correo_usu"=>$datos['correo_usu'],"contra_usu"=>$password,"id_rol"=>3,"id_centro"=>$datos['centro']]);
            //insert("INSERT INTO tbl_usuario (nick_usu,nombre_usu,apellido_usu,fecha_nac_usu,correo_usu,contra_usu,id_rol) VALUES (?,?,?,?,?,?,?)",[$datos["nick_usu"],$datos["nombre_usu"],$datos["apellido_usu"],$datos["fecha_nac_usu"],$datos["correo_usu"],$password,3]);
            DB::insert("INSERT INTO tbl_avatar (tipo_avatar, img_avatar, id_usu) VALUES (?,?,?)",["Usuario",$file,$id]);
            $newuser = DB::select("SELECT * FROM tbl_usuario WHERE id = ?",[$id]);
            $newuser=$newuser[0];
            session()->put("user",$newuser);
            //Crear JSON archivo de configuración
            $json = [
                "id" => $newuser->id,
                "curso" => null,
                "idioma" => null,
                "darkmode" => false
            ];
            $json = json_encode($json);
            //Almacenar JSON
            Storage::disk('config-user')->put("user-".$newuser->id.".json", $json);
            //request()->file($json)->store('uploads/configuration','public');
            return redirect("buscador");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    //Logout
    public function logout(){
        session()->flush();
        return redirect('/');
    }

    //Vista Perfil
    public function perfil($nick_usu){
        if (session()->get("user")) {
            $perfilUser = DB::select("SELECT user.*,avatar.img_avatar,centro.nombre_centro,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas' FROM tbl_usuario user
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
            INNER JOIN tbl_centro centro ON user.id_centro = centro.id
            LEFT JOIN tbl_contenidos content ON content.id_usu = user.id
            LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
            LEFT JOIN tbl_historial hist ON hist.id_usu = user.id
            WHERE nick_usu = ?",[$nick_usu]);

            $apuntesUser = DB::select("SELECT content.id as 'id_content', content.*,users.nick_usu,avatar.img_avatar,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas',centro.id,centro.nombre_centro,curso.id,curso.nombre_curso,asignaturas.id,asignaturas.nombre_asignatura,temas.id,temas.nombre_tema 
            FROM tbl_contenidos content
            INNER JOIN tbl_usuario users ON content.id_usu = users.id
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
            LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
            LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
            INNER JOIN tbl_temas temas ON temas.id = content.id_tema
            INNER JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
            INNER JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
            INNER JOIN tbl_centro centro ON centro.id = curso.id_centro
            WHERE users.nick_usu = ?
            GROUP BY id_content",[$nick_usu]);

            $avatares = DB::select("SELECT * FROM tbl_avatar WHERE tipo_avatar = 'Sistema'");

            return view('perfil',compact('perfilUser','apuntesUser', 'avatares'));
        }else{
            return redirect('/');
        }
    }

    //Moderador
    public function moderadorView(){
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
    }

    //Actualizar Perfil
    public function ActualizarPerfil(Request $request){
        if (session()->get('user')) {
            $user = session()->get('user');
            $dataUser = DB::select("SELECT user.*,centro.nombre_centro FROM tbl_usuario user
            INNER JOIN tbl_centro centro ON centro.id = user.id_centro
            WHERE user.id = ?",[$user->id]);
            $centros = DB::select("SELECT * FROM tbl_centro");
            return response()->json(array("user"=>$dataUser,"centros"=>$centros));
        }
    }

    public function ActualizarPerfilPut(Request $request){
        $user = session()->get('user');
        $NombreCentro = $request['nombre_centro'];
        $idCentro = DB::select("SELECT id FROM tbl_centro WHERE nombre_centro = ?",[$NombreCentro]);
        try {
            DB::beginTransaction();
            if($request['contra_usu'] == NULL){
                DB::update("UPDATE tbl_usuario SET nick_usu = ?, nombre_usu = ?, apellido_usu = ?, fecha_nac_usu = ?, correo_usu = ?, id_centro = ?  WHERE id = ?",[$request["nick_usu"],$request["nombre_usu"],$request["apellido_usu"],$request["fecha_nac_usu"],$request["correo_usu"],$idCentro[0]->id,$user->id]);
            }else{
                DB::update("UPDATE tbl_usuario SET SET nick_usu = ?, nombre_usu = ?, apellido_usu = ?, fecha_nac_usu = ?, correo_usu = ?, contra_usu = ?, id_centro=?  WHERE id = ?",[$request["nick_usu"],$request["nombre_usu"],$request["apellido_usu"],$request["fecha_nac_usu"],$request["correo_usu"],md5($request["contra_usu"]),$idCentro[0]->id,$user->id]);
            }
            $dataUser = DB::select("SELECT user.*,centro.nombre_centro FROM tbl_usuario user
            INNER JOIN tbl_centro centro ON centro.id = user.id_centro
            WHERE user.id = ?",[$user->id]);
            DB::commit();
            return response()->json(array('resultado'=> "OK",'user'=>$dataUser));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(array('resultado'=>"NOK: ".$e->getMessage()));
        }
    }

    public function actualizarAvatar(Request $request){
        $user = session()->get('user');
        if ($request->hasFile('img_avatar_usu2')) {
            //$file = $request->file('img_avatar_usu2')->store('uploads/avatar','public');
            $file = $request->file('img_avatar_usu2');
            //Cogemos el nombre original del fichero
            $fileName = "uploads/avatar/".$file->getClientOriginalName();
            $file->storeAs('uploads/avatar',$fileName);
            /* return $file; */
        }else{
            $fileName = $request["img_avatar_sistema"];
            /* return $datos; */
        }
        try {
            DB::beginTransaction();
            DB::update("UPDATE tbl_avatar SET img_avatar = ? WHERE id_usu = ?",[$fileName,$user->id]);
            $dataUser = DB::select("SELECT user.*,avatar.img_avatar FROM tbl_usuario user
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
            WHERE user.id = ?",[$user->id]);
            DB::commit();
            return response()->json(array('resultado'=> "OK",'user'=>$dataUser));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(array('resultado'=>"NOK: ".$e->getMessage()));
        }
    }
    /*CONFIGURACION USER*/
    public function getConfigUser(){
        $user = session()->get('user');
        if (file_exists(storage_path('app/public/uploads/configuration/user-'.$user->id.'.json'))) {
            //Si existe directamente cogemos el fichero y miramos si el campo esta nulo
            $configuration = json_decode(file_get_contents(storage_path('app/public/uploads/configuration/user-'.$user->id.'.json')), true);
            $configuration = $configuration["curso"];
            $cursos = DB::select("SELECT DISTINCT nombre_curso FROM tbl_cursos");
            return response()->json(array("configuration" => $configuration,"cursos"=>$cursos));
        }
    }
    public function changeConfigUser(Request $request){
        $user = session()->get('user');
        $json = json_decode(file_get_contents(storage_path('app/public/uploads/configuration/user-'.$user->id.'.json')), true);
        $json["curso"] = $request["nombre_curso"];
        $modifyJson = json_encode($json);
        Storage::disk('config-user')->put("user-".$user->id.".json", $modifyJson);
        return response()->json(array("resultado" => "OK"));
    }
}
