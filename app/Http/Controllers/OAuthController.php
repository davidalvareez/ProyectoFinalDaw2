<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RegisterUserOAuth;
use Illuminate\Support\Facades\DB;
use Imagick;

class OAuthController extends Controller
{
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
    public function oauthViewRegisterAlumno() {
        $id = session()->get('id');
        $centros = DB::select("SELECT * FROM tbl_centro");
        return view('OAuth_register',compact('id', 'centros'));
    }
    public function oauthRegisterAlumno(RegisterUserOAuth $request) {
        $datos=$request->except("_token");
        $password = md5($datos["contra_usu"]);
        try {
            $id_centro=DB::select("SELECT id FROM tbl_centro WHERE nombre_centro = ?",[$datos["centro"]]);
            DB::update("UPDATE tbl_usuario SET fecha_nac_usu = ?,contra_usu = ?,validado = ?,id_rol = ?, id_centro = ? WHERE id = ?",[$datos["fecha_nac_usu"],$password,true,$datos["id_rol"],$id_centro[0]->id,$datos["id"]]);
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