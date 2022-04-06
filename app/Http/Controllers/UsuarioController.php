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
        //return $datos;
        //Contraseña convertida a md5
        $password = md5($datos["contra_usu"]);
        if ($request->hasFile('img_avatar_usu')) {
            $file = $request->file('img_avatar_usu')->store('uploads/avatar','public');
        }else{
            $file = $datos["img_avatar_sistema"];
        }
        //Sentencia de creacion de usuario
        try {
            $id=DB::table("tbl_usuario")->insertGetId(["nick_usu"=>$datos['nick_usu'],"nombre_usu"=>$datos['nombre_usu'],"apellido_usu"=>$datos['apellido_usu'],"fecha_nac_usu"=>$datos['fecha_nac_usu'],"correo_usu"=>$datos['correo_usu'],"contra_usu"=>$password,"id_rol"=>3,"id_centro"=>$datos['centro']]);
            //insert("INSERT INTO tbl_usuario (nick_usu,nombre_usu,apellido_usu,fecha_nac_usu,correo_usu,contra_usu,id_rol) VALUES (?,?,?,?,?,?,?)",[$datos["nick_usu"],$datos["nombre_usu"],$datos["apellido_usu"],$datos["fecha_nac_usu"],$datos["correo_usu"],$password,3]);
            DB::insert("INSERT INTO tbl_avatar (tipo_avatar, img_avatar, id_usu) VALUES (?,?,?)",["Usuario",$file,$id]);
            $newuser = DB::select("SELECT * FROM tbl_usuario WHERE id = ?",[$id]);
            $newuser=$newuser[0];
            session()->put("user",$newuser);
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
}
