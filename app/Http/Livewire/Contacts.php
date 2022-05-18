<?php

namespace App\Http\Livewire;

use App\Models\chat;
use App\Models\frinds;
use App\Models\User;
use Livewire\Component;

class Contacts extends Component
{
    public function render()
    {
        //Coger variable de sesion para contactos
        if (session()->get("user")) {
            $user = session()->get("user");
            return view('livewire.contacts',[
                'contacts' => frinds::where("friend_id",$user->id)->latest()->get()
            ])->layout('layouts.main');
        }else{
            return redirect('/');
        }
    }
}
