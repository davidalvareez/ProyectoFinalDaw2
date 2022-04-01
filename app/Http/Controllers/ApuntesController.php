<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApuntesController extends Controller
{
    //Pagina buscador
    public function buscador(){
        if (session()->get("user")) {
            $user=session()->get('user');
            //Mostrar los más recientes de mi insti
            $recent=DB::select("SELECT content.*,user.nick_usu,avatar.img_avatar from tbl_contenidos content
            INNER JOIN tbl_usuario user ON content.id_usu = user.id
            LEFT JOIN tbl_avatar avatar ON avatar.id_usu = user.id
            ORDER BY content.fecha_publicacion_contenido DESC");
            //Mostrar los más populares de mi insti
            $popular=DB::select("SELECT content.*,user.nick_usu,sum(coment.val_comentario) as 'valoracion' FROM tbl_contenidos content
            INNER JOIN tbl_usuario user ON content.id_usu = user.id
            LEFT JOIN tbl_comentarios coment ON coment.id_contenido = content.id
            GROUP BY content.nombre_contenido
            ORDER BY valoracion DESC");
            return view('buscador',compact('user','recent','popular'));
        }else{
            return redirect("/");
        }
    }
}
