<?php

namespace App\Http\Livewire;

use App\Models\chat;
use App\Models\frinds;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
class Contacts extends Component
{
    public function render()
    {
        try {
            //Coger variable de sesion para contactos
            $user = session()->get("user");
            //$contact = frinds::where("friend_id",$user->id)->latest()->get();
            $contact = DB::select("SELECT name,image,uuid,message,created_at,user_id
            FROM (
            SELECT users.name,users.image,users.uuid,chats.message,DATE_FORMAT(chats.created_at,'%H:%i') as created_at,chats.user_id,ROW_NUMBER() OVER(PARTITION BY users.name ORDER BY chats.created_at desc) row_num 
            FROM friend
            INNER JOIN users ON users.id = friend.user_id
            LEFT JOIN chats ON chats.chat_id = friend.chat_id
            WHERE friend.friend_id = ?
            ) as sub 
            WHERE row_num = ?;",[$user->id,1]);
            return view('livewire.contacts',[
                'contacts' => $contact
            ])->layout('layouts.main');
        } catch (\Exception $e) {
            return view('livewire.contacts')->layout('layouts.main');
        }
    }
}
