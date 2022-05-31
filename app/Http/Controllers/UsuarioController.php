<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\RegisterValidation;
use App\Http\Requests\RegisterProfeValidation;
use App\Http\Requests\ValidateResetPassword;
use App\Http\Requests\ValidateVerifyMail;
use Illuminate\Support\Facades\MAIL;
use App\Mail\sendMail;

class UsuarioController extends Controller
{
    //Login + registro
    //Funciones view para hacer funciones + formulario
        public function loginView(){
            if (session()->get('user')) {
                return redirect('buscador');
            }else{
                return view('login');
            }
        }

        public function registerView(){
            if (session()->get('user')) {
                return redirect('buscador');
            }else{
                $avatares = DB::select("SELECT * FROM tbl_avatar WHERE tipo_avatar = 'Sistema'");
                $centros = DB::select("SELECT * FROM tbl_centro");
                //return $avatares;
                return view('register',compact('avatares','centros'));
            }
        }

    //Funciones de hacer login y registro
        public function login(LoginValidation $request){
            $datos=$request->except("_token");
            //Contraseña convertida a bcrypt
            $password = hash('sha256',$datos["contra_usu"]);
            //Sentencia que exista el usuario
            try {
                $user = DB::select("SELECT * FROM tbl_usuario WHERE (correo_usu = ? or nick_usu = ?) AND contra_usu = ?",[$datos["correo_nick"],$datos["correo_nick"],$password]);
                //Coger la longitud del array si coge 1 esta bien en caso contrario mal
                $existUser = count($user);
                //Si es 0 login incorrecto
                if ($existUser == 0) {
                    //Mandarlo al login conforme usuario y contraseña incorrecto
                    $fail_login = true;
                    return view("login",compact("fail_login"));
                //En caso contrario comprovamos lo siguiente
                }else{
                    $user = $user[0];
                    if ($user->validado == false) {
                        $fail_validate = true;
                        return view("login",compact("fail_validate"));
                    }else{
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
                        } else{
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
                                $fail_banned = true;
                                return view("login",compact("fail_banned"));
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        public function register(RegisterValidation $request){
            $datos=$request->except("_token");
            //Contraseña convertida a bcrypt
            /* return $datos; */
            $password = hash('sha256',$datos["contra_usu"]);
            if ($request->hasFile('img_avatar_usu2')) {
                $file = $request->file('img_avatar_usu2')->store('uploads/avatar','public');
                /* return $file; */
            }else{
                $file = $datos["img_avatar_sistema"];
            }
            //Sentencia de creacion de usuario
            try {
                //Cogemos el id del centro y hacemos el registro como usuario normal
                $id_centro=DB::select("SELECT id FROM tbl_centro WHERE nombre_centro = ?",[$datos["centro"]]);
                $id=DB::table("tbl_usuario")->insertGetId(["nick_usu"=>$datos['nick_usu'],"nombre_usu"=>$datos['nombre_usu'],"apellido_usu"=>$datos['apellido_usu'],"fecha_nac_usu"=>$datos['fecha_nac_usu'],"correo_usu"=>$datos['correo_usu'],"contra_usu"=>$password,"validado"=>false,"id_rol"=>$datos['tipo_usuario'],"id_centro"=>$id_centro[0]->id]);
                DB::insert("INSERT INTO tbl_avatar (tipo_avatar, img_avatar, id_usu) VALUES (?,?,?)",["Usuario",$file,$id]);
                // if ($datos["tipo_usuario"]==4) {
                //     DB::insert("INSERT INTO tbl_curriculum (nombre_curriculum, id_usu) VALUES (?,?)",[$nomcur,$id]);
                // }   
                $newuser = DB::select("SELECT * FROM tbl_usuario WHERE id = ?",[$id]);
                $newuser=$newuser[0];
                //INSERTAMOS CODIGO DE VALIDACION
                $code = rand(1000,9999);
                DB::insert("INSERT INTO tbl_validacion (code,id_usu) VALUES (?,?)",[$code,$newuser->id]);
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
                $urlValidateUser = url("validarcorreo");
                $sub = "Codigo de validacion de usuario";
                $msj = "El codigo de validacion es: $code. Insertalo en la página: $urlValidateUser";
                $datos = array('message'=>$msj);
                $enviar = new sendMail($datos);
                $enviar->sub = $sub;
                Mail::to($newuser->correo_usu)->send($enviar);
                return redirect("login");
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }


        public function registerProfe(RegisterProfeValidation $request){
            $datos=$request->except("_token");
            //Contraseña convertida a bcrypt
            /* return $datos; */
            $password = hash('sha256',$datos["contra_profe"]);
            if ($request->hasFile('img_avatar_usu2')) {
                $file = $request->file('img_avatar_usu2')->store('uploads/avatar','public');
                /* return $file; */
            }else{
                $file = $datos["img_avatar_sistema"];
                /* return $datos; */
            }
            //Sentencia de creacion de usuario
            try {
                //Cogemos el id del centro y hacemos el registro como usuario normal
                $id_centro=DB::select("SELECT id FROM tbl_centro WHERE nombre_centro = ?",[$datos["centro"]]);
                $id=DB::table("tbl_usuario")->insertGetId(["nick_usu"=>$datos['nick_usu'],"nombre_usu"=>$datos['nombre_profe'],"apellido_usu"=>$datos['apellido_profe'],"fecha_nac_usu"=>$datos['fecha_nac_profe'],"correo_usu"=>$datos['correo_usu'],"contra_usu"=>$password,"validado"=>false,"id_rol"=>$datos['tipo_usuario'],"id_centro"=>$id_centro[0]->id]);
                DB::insert("INSERT INTO tbl_avatar (tipo_avatar, img_avatar, id_usu) VALUES (?,?,?)",["Usuario",$file,$id]);
            if ($request->hasFile('curriculum_profe2')) {
                //$file2 = $request->file('curriculum_profe2')->store('uploads/curriculum','public');
                $path_folder = 'uploads/curriculum/';
                $filecur = $request->file('curriculum_profe2');
                $fileName = $datos['nombre_profe'].$datos['apellido_profe'].'_'.$id.'_CV.pdf';
                $filecur->storeAs('public/'.$path_folder,$fileName);
                $nomcur= $path_folder.$fileName;
                /* return $nomcur; */
            }else{
                $nomcur= "";
            }
                DB::insert("INSERT INTO tbl_curriculum (nombre_curriculum, id_usu) VALUES (?,?)",[$nomcur,$id]);
                $newuser = DB::select("SELECT * FROM tbl_usuario WHERE id = ?",[$id]);
                $newuser=$newuser[0];
                //INSERTAMOS CODIGO DE VALIDACION
                $code = rand(1000,9999);
                DB::insert("INSERT INTO tbl_validacion (code,id_usu) VALUES (?,?)",[$code,$newuser->id]);
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
                $urlValidateUser = url("validarcorreo");
                $sub = "Codigo de validacion de usuario";
                $msj = "El codigo de validacion es: $code. Insertalo en la página: $urlValidateUser";
                $datos = array('message'=>$msj);
                $enviar = new sendMail($datos);
                $enviar->sub = $sub;
                Mail::to($newuser->correo_usu)->send($enviar);
                return redirect("login");
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    //Validar usuario
        public function validarUsuario(ValidateVerifyMail $request){
            $datos = $request->except("_token");
            $user = DB::select("SELECT * FROM tbl_usuario WHERE correo_usu = ?",[$datos["correo"]]);
            if (count($user) == 0) {
                $user_notfound = true;
                return view("validarCorreo",compact("user_notfound"));
            }else{
                $user = $user[0];
                $validar = DB::select("SELECT * FROM tbl_validacion WHERE code = ? AND id_usu = ?",[$datos["codigo_usu"],$user->id]);
                if(count($validar) == 0){
                    $incorrect_code = true;
                    return view("validarCorreo",compact("incorrect_code"));
                }else{
                    try {
                        DB::beginTransaction();
                        DB::delete("DELETE FROM tbl_validacion WHERE code = ? AND id_usu = ?",[$datos["codigo_usu"],$user->id]);
                        DB::update("UPDATE tbl_usuario SET validado = ? WHERE id = ?",[true,$user->id]);
                        DB::commit();
                        session()->put("user",$user);
                        return redirect('buscador');
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return $e;
                    }
                }   
            }
        }
    //Validar contraseña
        public function validarContraseñaView(){
            return view('cambiarPass');
        }
        public function MAILvalidarContraseña(Request $request){
            $datos = $request->except("_token","_method");
            $correo_nick = $datos["nick_correo"];
            $existUser = DB::select("SELECT * FROM tbl_usuario WHERE correo_usu = ? or nick_usu = ?",[$correo_nick,$correo_nick]);
            if (count($existUser) == 0) {
                return response()->json(array("resultado" => "NotExist"));
            }else{
                try {
                    $existUser = $existUser[0];
                    $code = rand(1000,9999);
                    DB::insert("INSERT INTO tbl_validacion (code,id_usu) VALUES (?,?)",[$code,$existUser->id]);
                    $urlValidateUser = url("cambiarPass");
                    $sub = "Codigo de validacion de usuario";
                    $msj = "El codigo de validacion es: $code. Insertalo en la página: $urlValidateUser";
                    $datos = array('message'=>$msj);
                    $enviar = new sendMail($datos);
                    $enviar->sub = $sub;
                    Mail::to($existUser->correo_usu)->send($enviar);
                } catch (\Exception $e) {
                    return response()->json(array("resultado" => "NOK: ".$e->getMessage()));
                }
            }
        }
        public function validarCambioContraseña(ValidateResetPassword $request){
            $datos = $request->except("_token");
            $user = DB::select("SELECT * FROM tbl_usuario WHERE correo_usu = ?",[$datos["correo_usu"]]);
            if (count($user) == 0) {
                $user_notfound = true;
                return view("cambiarPass",compact("user_notfound"));
            }else{
                $user = $user[0];
                $password_encrypt = hash('sha256',$datos["contra_usu"]);
                if ($user->contra_usu == $password_encrypt) {
                    $samepassword = true;
                    return view("cambiarPass",compact("samepassword"));
                }else{
                    $validar = DB::select("SELECT * FROM tbl_validacion WHERE code = ? AND id_usu = ?",[$datos["codigo_usu"],$user->id]);
                    if(count($validar) == 0){
                        $incorrect_code = true;
                        return view("cambiarPass",compact("incorrect_code"));
                    }else{
                        try {
                            DB::beginTransaction();
                            DB::delete("DELETE FROM tbl_validacion WHERE code = ? AND id_usu = ?",[$datos["codigo_usu"],$user->id]);
                            DB::update("UPDATE tbl_usuario set contra_usu = ? WHERE id = ?",[$password_encrypt,$user->id]);
                            DB::commit();
                            return redirect('login');
                        } catch (\Exception $e) {
                            DB::rollBack();
                            return $e;
                        }
                    }
                }   
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
                //return $nick_usu;
                $perfilUser = DB::select("SELECT user.id,user.nick_usu,user.nombre_usu,user.apellido_usu,user.correo_usu,DATE_FORMAT(user.fecha_nac_usu,'%d/%m/%Y') as 'fecha_nac_usu',user.id_rol,users.uuid,avatar.img_avatar,centro.nombre_centro,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas' FROM tbl_usuario user
                LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
                LEFT JOIN tbl_centro centro ON user.id_centro = centro.id
                LEFT JOIN tbl_contenidos content ON content.id_usu = user.id
                LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                LEFT JOIN tbl_historial hist ON hist.id_usu = user.id
                JOIN users ON users.id = user.id
                WHERE user.nick_usu = ?",[$nick_usu]);

                $apuntesUser = DB::select("SELECT content.id as id_content, content.nombre_contenido,content.extension_contenido,DATE_FORMAT(content.fecha_publicacion_contenido,'%d/%m/%Y') as 'fecha_publicacion_contenido',users.nick_usu,(sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas',avatar.img_avatar,centro.nombre_centro,curso.nombre_curso,asignaturas.nombre_asignatura,temas.nombre_tema,temas.id as id_tema 
                FROM tbl_contenidos content
                INNER JOIN tbl_usuario users ON content.id_usu = users.id
                LEFT JOIN tbl_avatar avatar ON avatar.id_usu = users.id
                LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                LEFT JOIN tbl_temas temas ON temas.id = content.id_tema
                LEFT JOIN tbl_asignaturas asignaturas ON asignaturas.id = temas.id_asignatura
                LEFT JOIN tbl_cursos curso ON curso.id = asignaturas.id_curso
                LEFT JOIN tbl_centro centro ON centro.id = curso.id_centro
                WHERE users.nick_usu = ?
                GROUP BY id_content",[$nick_usu]);

                $apunteDestacado = DB::select("SELECT content.id, (sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas' FROM tbl_contenidos content 
                INNER JOIN tbl_usuario user ON content.id_usu = user.id
                LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                WHERE user.nick_usu = ?
                GROUP BY content.id ORDER BY valoracion DESC LIMIT 1",[$nick_usu]);

                $apunteDescargas = DB::select("SELECT content.id, (sum(coment.val_comentario)/count(coment.val_comentario)) as 'valoracion',count(hist.id_contenido) as 'descargas' FROM tbl_contenidos content 
                INNER JOIN tbl_usuario user ON content.id_usu = user.id
                LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
                LEFT JOIN tbl_historial hist ON hist.id_contenido = content.id
                WHERE user.nick_usu = ?
                GROUP BY content.id ORDER BY descargas DESC LIMIT 1",[$nick_usu]);

                $avatares = DB::select("SELECT * FROM tbl_avatar WHERE tipo_avatar = 'Sistema'");
                
                $curriculum = DB::select("SELECT nombre_curriculum FROM tbl_curriculum LEFT JOIN tbl_usuario ON tbl_curriculum.id_usu = tbl_usuario.id WHERE tbl_usuario.nick_usu = ?",[$nick_usu]);

                return view('perfil',compact('perfilUser','apuntesUser', 'avatares','apunteDestacado','apunteDescargas','curriculum'));
            }else{
                return redirect('/');
            }
        }
    //Actualizar Perfil
        public function ActualizarPerfil(Request $request){
            if (session()->get('user')) {
                $user = session()->get('user');
                $dataUser = DB::select("SELECT user.*,centro.nombre_centro FROM tbl_usuario user
                LEFT JOIN tbl_centro centro ON centro.id = user.id_centro
                WHERE user.id = ?",[$user->id]);
                $centros = DB::select("SELECT * FROM tbl_centro");
                return response()->json(array("user"=>$dataUser,"centros"=>$centros));
            }
        }

        public function ActualizarPerfilPut(Request $request){
            $user = session()->get('user');
            $NombreCentro = $request['nombre_centro'];
            $idCentro = DB::select("SELECT id FROM tbl_centro WHERE nombre_centro = ?",[$NombreCentro]);
            $existNick = DB::select("SELECT * FROM tbl_usuario WHERE NOT id = ? AND nick_usu = ?",[$user->id,$request["nick_usu"]]);
            $existEmail = DB::select("SELECT * FROM tbl_usuario WHERE NOT id = ? AND correo_usu = ?",[$user->id,$request["correo_usu"]]);
            if (count($existNick) != 0) {
                return response()->json(array('resultado'=> "existNick"));
            }
            if (count($existEmail) != 0) {
                return response()->json(array('resultado'=> "existEmail"));
            }
            try {
                DB::beginTransaction();
                if($request['contra_usu'] == NULL){
                    DB::update("UPDATE tbl_usuario SET nick_usu = ?, nombre_usu = ?, apellido_usu = ?, fecha_nac_usu = ?, correo_usu = ?, id_centro = ?  WHERE id = ?",[$request["nick_usu"],$request["nombre_usu"],$request["apellido_usu"],$request["fecha_nac_usu"],$request["correo_usu"],$idCentro[0]->id,$user->id]);
                }else{
                    DB::update("UPDATE tbl_usuario SET SET nick_usu = ?, nombre_usu = ?, apellido_usu = ?, fecha_nac_usu = ?, correo_usu = ?, contra_usu = ?, id_centro=?  WHERE id = ?",[$request["nick_usu"],$request["nombre_usu"],$request["apellido_usu"],$request["fecha_nac_usu"],$request["correo_usu"],hash('sha256',$request["contra_usu"]),$idCentro[0]->id,$user->id]);
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
            //Cogemos si tiene alguno del sistema para no borrarlo.
            $userImage = DB::select("SELECT * FROM tbl_avatar WHERE id_usu = ?",[$user->id]);
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
            if ($request->hasFile('img_avatar_usu2')) {
                //$file = $request->file('img_avatar_usu2')->store('uploads/avatar','public');
                $file = $request->file('img_avatar_usu2');
                //Cogemos el nombre original del fichero
                $fileName = "uploads/avatar/".$file->getClientOriginalName();
                $file->storeAs('public/',$fileName);
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
    /*DARSE DE BAJA */
        public function DarseDeBaja(Request $request){
            $user= session()->get('user');
            $datos = $request->except("_token","_method");
            $password_encrypt = hash('sha256',$datos["contra_usu"]);
            $correctPassword = DB::select("SELECT * FROM tbl_usuario WHERE contra_usu = ? AND id = ?",[$password_encrypt,$user->id]);
            if (count($correctPassword) == 0) {
                return response()->json(array("resultado"=>"IncorrectPassword"));
            }else{
                try{
                    //Cogemos si tiene alguno del sistema para no borrarlo.
                        $userImage = DB::select("SELECT * FROM tbl_avatar WHERE id_usu = ?",[$user->id]);
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
                    $apuntes = DB::select("SELECT apuntes.*,centro.nombre_centro,curso.nombre_curso,asig.nombre_asignatura,temas.nombre_tema FROM tbl_usuario usu 
                    INNER JOIN tbl_centro centro ON usu.id_centro = centro.id
                    INNER JOIN tbl_cursos curso ON centro.id = curso.id_centro
                    INNER JOIN tbl_asignaturas asig ON curso.id = asig.id_curso
                    INNER JOIN tbl_temas temas ON asig.id = temas.id_asignatura
                    INNER JOIN tbl_contenidos apuntes ON temas.id = apuntes.id_tema
                    WHERE apuntes.id_usu =  ?",[$user->id]);
                    foreach ($apuntes as $apunte) {
                        DB::delete("DELETE FROM tbl_multimedia WHERE id = ?",[$apunte->id]);
                        $pathPDF = 'public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.$apunte->extension_contenido;
                        $pathIMG = 'public/uploads/apuntes/'.$apunte->nombre_centro.'/'.$apunte->nombre_curso.'/'.$apunte->nombre_asignatura.'/'.$apunte->nombre_tema.'/'.$apunte->nombre_contenido.'.png';
                        Storage::delete($pathPDF);
                        Storage::delete($pathIMG);
                    }
                    Storage::delete('public/uploads/configuration/user-'.$user->id.'.json');
                    DB::delete("DELETE FROM tbl_denuncias WHERE id_demandante= ? or id_acusado = ?",[$user->id,$user->id]);
                    DB::delete("DELETE FROM tbl_comentarios WHERE id_usu= ?",[$user->id]);
                    DB::delete("DELETE FROM tbl_historial WHERE id_usu= ?",[$user->id]);
                    DB::delete("DELETE FROM tbl_contenidos WHERE id_usu= ?",[$user->id]);
                    DB::delete("DELETE FROM tbl_avatar WHERE id_usu= ?",[$user->id]);
                    DB::delete("DELETE FROM tbl_estudios WHERE id_usu= ?",[$user->id]);
                    DB::delete("DELETE FROM chats WHERE user_id= ?",[$user->id]);
                    DB::delete("DELETE FROM chats WHERE friend_id= ?",[$user->id]);
                    DB::delete("DELETE FROM friend WHERE user_id= ?",[$user->id]);
                    DB::delete("DELETE FROM friend WHERE friend_id= ?",[$user->id]);
                    DB::delete("DELETE FROM tbl_usuario WHERE id= ?",[$user->id]);
                    DB::commit();
                    $redirect = url('/');
                    session()->flush();
                    return response()->json(array('resultado'=>'OK','redirect'=>$redirect));
                }catch(\Exception $e){
                    DB::rollBack();
                    return response()->json(array('resultado'=>'NOK'.$e->getMessage()));
                }
            }
        }
        public function uploadCV(Request $request){
            $user = session()->get("user");
            try {
                $path_folder = 'uploads/curriculum/';
                $filecur = $request->file('fileupload');
                $fileNameCV = $filecur->getClientOriginalName();
                $arrayFileName = explode('.',$fileNameCV);
                $extensionFile = $arrayFileName[1];
                if ($extensionFile != "pdf") {
                    return response()->json(array('resultado'=>'failExtension'));
                }
                $fileName = $user->nombre_usu.$user->apellido_usu.'_'.$user->id.'_CV.pdf';
                $nomcur= $path_folder.$fileName;
                DB::beginTransaction();
                $existCV = DB::select("SELECT * FROM tbl_curriculum WHERE id_usu = ?",[$user->id]);
                if (count($existCV) == 0) {
                    DB::insert("INSERT INTO tbl_curriculum (nombre_curriculum,id_usu) VALUES (?,?)",[$nomcur,$user->id]);
                }else{
                    if (file_exists(storage_path('app/public/'.$existCV[0]->nombre_curriculum))) {
                        Storage::delete("public/".$existCV[0]->nombre_curriculum);
                    }
                    DB::update("UPDATE tbl_curriculum SET nombre_curriculum = ? WHERE id_usu = ?",[$nomcur,$user->id]);
                }
                $filecur->storeAs('public/'.$path_folder,$fileName);
                DB::commit();
                return response()->json(array('resultado'=>'OK'));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(array('resultado'=>'NOK: '.$e->getMessage()));
            }
        }
    /*Profesores*/
        public function MostrarProfesores(){
            if (session()->get('user')) {
                //Todos los profes
                $MostrarProfesores = DB::select("SELECT user.*,users.uuid,estudios.id_usu, estudios.id_curso, avatar.tipo_avatar,
                avatar.img_avatar, avatar.id_usu, cursos.nombre_curso, cursos.nombre_corto_curso, cursos.tipo_curso,
                cursos.id_centro,cv.nombre_curriculum FROM tbl_usuario user
                LEFT JOIN tbl_avatar avatar ON user.id = avatar.id_usu
                INNER JOIN tbl_estudios estudios ON user.id = estudios.id_usu
                INNER JOIN tbl_cursos cursos ON cursos.id = estudios.id_curso
                LEFT JOIN tbl_curriculum cv ON cv.id_usu = user.id
                JOIN users ON users.id = user.id
                WHERE user.id_rol = ?",[4]);
                //Todos los cursos
                $allCursos = DB::select("SELECT * FROM tbl_cursos GROUP BY nombre_curso ORDER BY id ASC");
                return view ('profesores',compact('MostrarProfesores','allCursos'));
            }else{
                return redirect('login');
            }
        }

        public function multiplyFilterProfesores(Request $request){
            $datos = $request->except("_token","_method");
            if ($datos["filter"] == "") {
                $filterProfe = DB::select("SELECT user.*,users.uuid, estudios.id_usu, estudios.id_curso, avatar.tipo_avatar,
                avatar.img_avatar, avatar.id_usu, cursos.nombre_curso, cursos.nombre_corto_curso, cursos.tipo_curso,
                cursos.id_centro,cv.nombre_curriculum FROM tbl_usuario user
                LEFT JOIN tbl_avatar avatar ON user.id = avatar.id_usu
                INNER JOIN tbl_estudios estudios ON user.id = estudios.id_usu
                INNER JOIN tbl_cursos cursos ON cursos.id = estudios.id_curso
                LEFT JOIN tbl_curriculum cv ON cv.id_usu = user.id
                JOIN users ON users.id = user.id
                WHERE user.id_rol = ?",[4]);
            }else{
                $id = $datos["filter"][0];
                if (is_numeric($id)) {
                    $filterProfe = DB::select("SELECT user.*,users.uuid, estudios.id_usu, estudios.id_curso, avatar.tipo_avatar,
                    avatar.img_avatar, avatar.id_usu, cursos.nombre_curso, cursos.nombre_corto_curso, cursos.tipo_curso,
                    cursos.id_centro,cv.nombre_curriculum FROM tbl_usuario user
                    LEFT JOIN tbl_avatar avatar ON user.id = avatar.id_usu
                    INNER JOIN tbl_estudios estudios ON user.id = estudios.id_usu
                    INNER JOIN tbl_cursos cursos ON cursos.id = estudios.id_curso
                    LEFT JOIN tbl_curriculum cv ON cv.id_usu = user.id
                    JOIN users ON users.id = user.id
                    WHERE user.id_rol = ? AND user.id = ?",[4,$datos["filter"]]);
                }else{
                    $filterProfe = DB::select("SELECT user.*,users.uuid, estudios.id_usu, estudios.id_curso, avatar.tipo_avatar,
                    avatar.img_avatar, avatar.id_usu, cursos.nombre_curso, cursos.nombre_corto_curso, cursos.tipo_curso,
                    cursos.id_centro,cv.nombre_curriculum FROM tbl_usuario user
                    LEFT JOIN tbl_avatar avatar ON user.id = avatar.id_usu
                    INNER JOIN tbl_estudios estudios ON user.id = estudios.id_usu
                    INNER JOIN tbl_cursos cursos ON cursos.id = estudios.id_curso
                    LEFT JOIN tbl_curriculum cv ON cv.id_usu = user.id
                    JOIN users ON users.id = user.id
                    WHERE user.id_rol = ? AND (user.nick_usu LIKE ? OR user.nombre_usu LIKE ? OR cursos.nombre_curso LIKE ?)",[4,'%'.$datos["filter"].'%','%'.$datos["filter"].'%','%'.$datos["filter"].'%']);
                }
            }
            return response()->json($filterProfe);
        }
        public function advancedFilterProfesores(Request $request){
            $datos = $request->except("_token","_method");
            if ($datos["cursos"] == null) {
                $filterProfe = DB::select("SELECT user.*,users.uuid, estudios.id_usu, estudios.id_curso, avatar.tipo_avatar,
                    avatar.img_avatar, avatar.id_usu, cursos.nombre_curso, cursos.nombre_corto_curso, cursos.tipo_curso,
                    cursos.id_centro,cv.nombre_curriculum FROM tbl_usuario user
                    LEFT JOIN tbl_avatar avatar ON user.id = avatar.id_usu
                    INNER JOIN tbl_estudios estudios ON user.id = estudios.id_usu
                    INNER JOIN tbl_cursos cursos ON cursos.id = estudios.id_curso
                    LEFT JOIN tbl_curriculum cv ON cv.id_usu = user.id
                    JOIN users ON users.id = user.id
                    WHERE user.id_rol = ?",[4]);
            }else{
                $cursos = explode(',',$datos["cursos"]);
                $array_cursos_id = [];
                for ($i=0; $i < count($cursos); $i++) {
                    $id_curso = DB::select("SELECT * FROM tbl_cursos WHERE nombre_curso = '{$cursos[$i]}'");
                    foreach($id_curso as $id){
                        array_push($array_cursos_id,$id->id);
                    }
                }
                $string_array_cursos_id = implode(',',$array_cursos_id);
                $select = "SELECT user.*,users.uuid, estudios.id_usu, estudios.id_curso, avatar.tipo_avatar,
                avatar.img_avatar, avatar.id_usu, cursos.nombre_curso, cursos.nombre_corto_curso, cursos.tipo_curso,
                cursos.id_centro,cv.nombre_curriculum FROM tbl_usuario user
                LEFT JOIN tbl_avatar avatar ON user.id = avatar.id_usu
                INNER JOIN tbl_estudios estudios ON user.id = estudios.id_usu
                INNER JOIN tbl_cursos cursos ON cursos.id = estudios.id_curso
                LEFT JOIN tbl_curriculum cv ON cv.id_usu = user.id
                JOIN users ON users.id = user.id
                WHERE user.id_rol = 4 AND estudios.id_curso IN ($string_array_cursos_id) ORDER BY user.id ASC";
                $filterProfe = DB::select($select);
            }
            return response()->json($filterProfe);
        }

        public function mostrarEstudios($id){
            $listaEstudios = DB::select("SELECT * FROM tbl_usuario usuario INNER JOIN tbl_estudios estudios ON usuario.id = estudios.id_usu
            INNER JOIN tbl_cursos cursos ON estudios.id_curso = cursos.id WHERE usuario.id = ?;",[$id]);
            //return $listaEstudios;
            return response()->json($listaEstudios);
        }

        public function mostrarCurriculum($id){
            $Curriculum = DB::select("SELECT * FROM tbl_usuario usuario LEFT JOIN tbl_curriculum curriculum
            ON usuario.id = curriculum.id_usu WHERE usuario.id_rol = ? AND usuario.id = ?;",[4, $id]);
            return response()->json($Curriculum);
        }

        public function showStudies(Request $request){
            $datos = $request->except("_token","_method");
            $user = session()->get('user');
            if ($datos["add_delete_study"] == "true") {
                //Mostrar los que no tiene para asignar
                $cursosuser = DB::select("SELECT * from tbl_estudios estudios 
                INNER JOIN tbl_cursos cursos ON estudios.id_curso = cursos.id
                WHERE estudios.id_usu = ?;",[$user->id]);
                $arrayIdCurso = [];
                foreach ($cursosuser as $curso){
                    array_push($arrayIdCurso,$curso->id);
                }
                $stringIdCurso = implode(',',$arrayIdCurso);
                $query = "SELECT * FROM tbl_cursos 
                WHERE id NOT IN ({$stringIdCurso})
                GROUP BY nombre_curso
                ORDER BY id ASC";
                $studies = DB::select($query);
            }else{
                //Mostrar los que tiene asignados para eliminar
                $studies = DB::select("SELECT * from tbl_estudios estudios 
                INNER JOIN tbl_cursos cursos ON estudios.id_curso = cursos.id
                WHERE estudios.id_usu = ?",[$user->id]);
            }
            return response()->json($studies);
        }
        public function addStudies(Request $request){
            $datos = $request->except("_token","_method");
            $user = session()->get('user');
            if ($datos["cursos"] == null) {
                return response()->json(array('resultado'=>'nullCursos'));
             }else{
                 $arrayCursos = explode(',',$datos["cursos"]);
                 try {
                     DB::beginTransaction();
                     for ($i=0; $i < count($arrayCursos); $i++) { 
                         DB::insert("INSERT INTO tbl_estudios (id_usu,id_curso) VALUES (?,?)",[$user->id,$arrayCursos[$i]]);
                     }
                     DB::commit();
                     return response()->json(array('resultado'=>'OK'));
                 } catch (\Exception $e) {
                     DB::rollBack();
                    return response()->json(array('resultado'=>'NOK: '.$e->getMessage()));
                 }
             }
        }
        public function deleteStudies(Request $request){
            $datos = $request->except("_token","_method");
            $user = session()->get('user');
            if ($datos["cursos"] == null) {
               return response()->json(array('resultado'=>'nullCursos'));
            }else{
                $arrayCursos = explode(',',$datos["cursos"]);
                 try {
                     DB::beginTransaction();
                     for ($i=0; $i < count($arrayCursos); $i++) { 
                         DB::delete("DELETE FROM tbl_estudios WHERE id_usu = ? AND id_curso = ?",[$user->id,$arrayCursos[$i]]);
                     }
                     DB::commit();
                     return response()->json(array('resultado'=>'OK'));
                 } catch (\Exception $e) {
                     DB::rollBack();
                    return response()->json(array('resultado'=>'NOK: '.$e->getMessage()));
                 }
            }
            return response()->json($datos);
        }
}