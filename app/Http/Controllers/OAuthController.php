<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Imagick;

class OAuthController extends Controller
{
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function google_callback(){
        $user_google = Socialite::driver('google')->user();
        dd($user_google);
        $existUser = DB::select("SELECT * FROM tbl_usuario WHERE correo_usu = ?",[$user_google->email]);
        if (count($existUser) == 0) {
            $existUser = $existUser[0];
            //Si no tiene centro, contraseña, fecha de nacimiento,rol se manda al registro en caso contrario al buscador.
            if ($existUser->contra_usu == null && $existUser->fecha_nac_usu == null && $existUser->id_rol == null) {
                return view('OAuth_register');
            }else{
                return redirect("buscador");
            }
        }else{
            return view('OAuth_register');
        }
    }
}