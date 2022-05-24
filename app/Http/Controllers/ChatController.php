<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Livewire\ChatWith;

class ChatController extends Controller
{
    public function deleteChat(Request $request){
            $datos = $request->except("_token","_method");
            $user = session()->get('user');
            $this->borrar = false;
            try {
                DB::beginTransaction();
                DB::delete("DELETE FROM chats WHERE (user_id = ? AND friend_id = ?)",[$user->id,$datos["id_friend"]]);
                DB::delete("DELETE FROM chats WHERE (user_id = ? AND friend_id = ?)",[$datos["id_friend"],$user->id]);
                DB::delete("DELETE FROM friend WHERE (user_id = ? AND friend_id = ?)",[$user->id,$datos["id_friend"]]);
                DB::delete("DELETE FROM friend WHERE (user_id = ? AND friend_id = ?)",[$datos["id_friend"],$user->id]);
                DB::commit();
                return response()->json(array('resultado' => "OK"));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(array('resultado' => "NOK:".$e->getMessage()));
            }
    }
}
