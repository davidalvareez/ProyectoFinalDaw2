<div class="chat-body">
    <div class="chat-box-header">
        <img src="{!! asset ('media/logo1chat.png') !!}" class="employee" alt="" srcset="">
        
        <div class="employee-name"></div>
        <div class="top-right-menu-icons">
        </div>
        <div class="top-right-menu-last-icons" id="close-chat">
            <a href="{{url('buscador')}}">
                <img src="{!! asset ('media/home.png') !!}" alt="" width="120%">
            </a>
        </div>
    </div>
    <div class="chat-box-content" wire:poll.keep-alive>
        <div class="conversation-group">
            @forelse ($contacts as $user)
                <a href="{{ route('chat_with', $user->uuid) }}">
                    <div class="contact">
                        <img class="contact_image" src="{{asset('storage').'/'.$user->image }}" alt="" />
                        <p class="contact_name">{{ $user->name }}</p>
                        <!--Mostrar hora del ultimo mensaje, mostra el mensaje de quien fue para mostrar una cosa o otra-->
                        <!--MENSAJE MIO-->
                        @if ($user->user_id == Session::get('user')->id)
                        <div>{{ $user->message }}</div>
                        @else
                        <!--MENSAJE DE EL-->
                        <div>{{ $user->message }}</div>
                        @endif
                        <div class="contact_last_chat_time">{{ $user->created_at }}</div>
                    </div>
                </a>
            @empty
                <center>No hay ningun chat</center>
            @endforelse
        </div>
    </div>
</div>
