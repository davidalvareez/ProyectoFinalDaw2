<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RegisterUserOAuth;
use App\Http\Requests\RegisterProfeOAuth;
use Illuminate\Support\Facades\DB;
use Imagick;

class OAuthController extends Controller
{
    //Google
        public function login_google(){
            return Socialite::driver('google')->redirect();
        }
        public function google_callback(){
            $user_google = Socialite::driver('google')->user();
            //dd($user_google);
            $existUser = DB::select("SELECT * FROM tbl_usuario WHERE correo_usu = ?",[$user_google->email]);
            if (count($existUser) != 0) {
                $existUser = $existUser[0];
                //Si no tiene centro, contraseña, fecha de nacimiento,rol se manda al registro en caso contrario al buscador.
                if ($existUser->contra_usu == null && $existUser->fecha_nac_usu == null && $existUser->id_rol == null && $existUser->id_centro == null) {
                    $id = $existUser->id;
                    session()->put("id",$id);
                    return redirect('oauth-register');
                }else{
                    session()->put("user",$existUser);
                    return redirect("buscador");
                }
            }else{
                try {
                    DB::beginTransaction();
                    $id=DB::table("tbl_usuario")->insertGetId(["nick_usu"=>$user_google->user["given_name"].$user_google->user["family_name"],"nombre_usu"=>$user_google->user["given_name"],"apellido_usu"=>$user_google->user["family_name"],"fecha_nac_usu"=>null,"correo_usu"=>$user_google->email,"contra_usu"=>null,"validado"=>false,"id_rol"=>null,"id_centro"=>null]);
                    DB::insert("INSERT INTO tbl_avatar (tipo_avatar, img_avatar, id_usu) VALUES (?,?,?)",["Usuario",$user_google->avatar,$id]);
                    DB::commit();
                    session()->put("id",$id);
                    return redirect('oauth-register');
                } catch (\Exception $e) {
                    DB::rollback();
                    return $e;
                }
            }
        }
    //Facebook
        public function login_facebook(){
            return Socialite::driver('facebook')->redirect();
        }
        public function facebook_callback(){
            $user_facebook = Socialite::driver('facebook')->user();
            //dd($user_facebook);
            $existUser = DB::select("SELECT * FROM tbl_usuario WHERE correo_usu = ?",[$user_facebook->email]);
            if (count($existUser) != 0) {
                $existUser = $existUser[0];
                //Si no tiene centro, contraseña, fecha de nacimiento,rol se manda al registro en caso contrario al buscador.
                if ($existUser->contra_usu == null && $existUser->fecha_nac_usu == null && $existUser->id_rol == null && $existUser->id_centro == null) {
                    $id = $existUser->id;
                    session()->put("id",$id);
                    return redirect('oauth-register');
                }else{
                    session()->put("user",$existUser);
                    return redirect("buscador");
                }
            }else{
                try {
                    DB::beginTransaction();
                    $id=DB::table("tbl_usuario")->insertGetId(["nick_usu"=>$user_facebook->name,"nombre_usu"=>$user_facebook->name,"apellido_usu"=>$user_facebook->name,"fecha_nac_usu"=>null,"correo_usu"=>$user_facebook->email,"contra_usu"=>null,"validado"=>false,"id_rol"=>null,"id_centro"=>null]);
                    DB::insert("INSERT INTO tbl_avatar (tipo_avatar, img_avatar, id_usu) VALUES (?,?,?)",["Usuario",$user_facebook->avatar,$id]);
                    DB::commit();
                    session()->put("id",$id);
                    return redirect('oauth-register');
                } catch (\Exception $e) {
                    DB::rollback();
                    return $e;
                }
            }
        }
    //Twitter
        public function login_twitter(){
            return Socialite::driver('twitter')->redirect();
        }
        public function twitter_callback(){
            $user_twitter = Socialite::driver('twitter')->user();
            //dd($user_twitter);
            $existUser = DB::select("SELECT * FROM tbl_usuario WHERE correo_usu = ?",[$user_twitter->email]);
            if (count($existUser) != 0) {
                $existUser = $existUser[0];
                //Si no tiene centro, contraseña, fecha de nacimiento,rol se manda al registro en caso contrario al buscador.
                if ($existUser->contra_usu == null && $existUser->fecha_nac_usu == null && $existUser->id_rol == null && $existUser->id_centro == null) {
                    $id = $existUser->id;
                    session()->put("id",$id);
                    return redirect('oauth-register');
                }else{
                    session()->put("user",$existUser);
                    return redirect("buscador");
                }
            }else{
                try {
                    DB::beginTransaction();
                    $id=DB::table("tbl_usuario")->insertGetId(["nick_usu"=>$user_twitter->nickname,"nombre_usu"=>$user_twitter->name,"apellido_usu"=>$user_twitter->name,"fecha_nac_usu"=>null,"correo_usu"=>$user_twitter->email,"contra_usu"=>null,"validado"=>false,"id_rol"=>null,"id_centro"=>null]);
                    DB::insert("INSERT INTO tbl_avatar (tipo_avatar, img_avatar, id_usu) VALUES (?,?,?)",["Usuario",$user_twitter->avatar,$id]);
                    DB::commit();
                    session()->put("id",$id);
                    return redirect('oauth-register');
                } catch (\Exception $e) {
                    DB::rollback();
                    return $e;
                }
            }
        }
    //Funciones propias
        public function oauthViewRegisterAlumno() {
            $id = session()->get('id');
            $centros = DB::select("SELECT * FROM tbl_centro");
            return view('OAuth_register',compact('id', 'centros'));
        }
        public function oauthRegisterAlumno(RegisterUserOAuth $request) {
            $datos=$request->except("_token");
            $password = hash('sha256',$datos["contra_usu"]);
            try {
                $id_centro=DB::select("SELECT id FROM tbl_centro WHERE nombre_centro = ?",[$datos["centro"]]);
                DB::update("UPDATE tbl_usuario SET fecha_nac_usu = ?,contra_usu = ?,validado = ?,id_rol = ?, id_centro = ? WHERE id = ?",[$datos["fecha_nac_usu"],$password,true,$datos["id_rol"],$id_centro[0]->id,$datos["id"]]);
                DB::update("UPDATE users set password = ? WHERE id = ?",[$password,$datos["id"]]);
                $json = [
                    "id" => $datos["id"],
                    "curso" => null,
                    "idioma" => null,
                    "darkmode" => false
                ];
                $json = json_encode($json);
                //Almacenar JSON
                Storage::disk('config-user')->put("user-".$datos["id"].".json", $json);
                $user = DB::select("SELECT * FROM tbl_usuario WHERE id = ?",[$datos["id"]]);
                $user = $user[0];
                session()->forget("id");
                session()->put("user", $user);
                return redirect("buscador");
            } catch (\Exception $e) {
                return $e;
            }
        }

        public function oauthRegisterProfesor(RegisterProfeOAuth $request) {
            $datos=$request->except("_token");
            $password = hash('sha256',$datos["contra_profe"]);
            try {
                if ($datos["centro"] == null) {
                    $id_centro = null;
                }else{
                    $id_centro=DB::select("SELECT id FROM tbl_centro WHERE nombre_centro = ?",[$datos["centro"]]);
                    $id_centro=$id_centro[0]->id;
                }
                if ($request->hasFile('curriculum_profe2')) {
                    //$file2 = $request->file('curriculum_profe2')->store('uploads/curriculum','public');
                    $profe = DB::select("SELECT * FROM tbl_usuario WHERE id = ?",[$datos["id"]]);
                    $profe = $profe [0];
                    $path_folder = 'uploads/curriculum/';
                    $filecur = $request->file('curriculum_profe2');
                    $fileName = $profe->nombre_usu.$profe->apellido_usu.'_'.$datos["id"].'_CV.pdf';
                    $filecur->storeAs('public/'.$path_folder,$fileName);
                    $NombreCurriculum = $path_folder.$fileName;
                    /* return $nomcur; */
                }else{
                    $NombreCurriculum = "";
                }
                DB::update("UPDATE tbl_usuario SET fecha_nac_usu = ?,contra_usu = ?,validado = ?,id_rol = ?, id_centro = ? WHERE id = ?",[$datos["fecha_nac_prof"],$password,true,$datos["id_rol"],$id_centro,$datos["id"]]);
                DB::update("UPDATE users set password = ? WHERE id = ?",[$password,$datos["id"]]);
                DB::insert("INSERT INTO tbl_curriculum (nombre_curriculum, id_usu) VALUES (?,?)",[$NombreCurriculum,$datos["id"]]);
                $json = [
                    "id" => $datos["id"],
                    "curso" => null,
                    "idioma" => null,
                    "darkmode" => false
                ];
                $json = json_encode($json);
                //Almacenar JSON
                Storage::disk('config-user')->put("user-".$datos["id"].".json", $json);
                $user = DB::select("SELECT * FROM tbl_usuario WHERE id = ?",[$datos["id"]]);
                $user = $user[0];
                session()->forget("id");
                session()->put("user", $user);
                return redirect("buscador");
            } catch (\Exception $e) {
                return $e;
            }
        }
}