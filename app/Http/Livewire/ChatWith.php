<?php

namespace App\Http\Livewire;

use App\Models\chat;
use App\Models\frinds;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class ChatWith extends Component
{

    public $uuid;
    public $user;
    public $message;

    public function send_message()
    {
        if (session()->get("user")) {
            $user = session()->get("user");
            $this->validate(['message' => "required"]);
            //Auth cambiar por variable de sesion de id de user logeado
            chat::create([
                'user_id' => $user->id,
                'message' => $this->message,
                'chat_id' => frinds::where(['user_id'=>$user->id, 'friend_id' =>$this->user->id])->first()->chat_id,
                'friend_id' => $this->user->id
            ]);

            $this->message='';
            $this->render();
        }else{
            return redirect('/');
        }
    }

    public function mount($uuid)
    {
        if (session()->get('user')) {
            $user = session()->get("user");
            $this->uuid = $uuid;
            $this->user = User::where('uuid',$uuid)->first();

            //Auth cambiar por variable de sesion de id de user logeado
            if (frinds::where(['user_id' => $user->id, 'friend_id' => $this->user->id])->count() === 0 || frinds::where(['user_id' => $this->user->id, 'friend_id' => $user->id])->count() === 0) {
                $uuid = Str::uuid();
                frinds::create([
                    'user_id' => $user->id,
                    'chat_id' => $uuid,
                    'friend_id' => $this->user->id
                ]);

                frinds::create([
                    'user_id' => $this->user->id,
                    'chat_id' => $uuid,
                    'friend_id' => $user->id
                ]);
            }
        }else{
            return redirect('/'); 
        }
    }
    public function render()
    {
        if (session()->get('user')) {
            $user = session()->get("user");
            try {
                return view('livewire.chat-with',[
                    'messages' => chat::where('chat_id',frinds::where(['user_id'=>$user->id, 'friend_id' =>$this->user->id])->first()->chat_id)->get()
                            ])->layout('layouts.main');
            } catch (\Exception $e) {
                return view('livewire.chat-with')->layout('layouts.main');
            }
        }
    }
}
