@include('template.header')
    <link rel="stylesheet" href="{!! asset ('css/vistaapuntes/vistaapuntes.css') !!}">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{!! asset('js/vistaapuntes/vistaapuntes.js') !!}"></script>
    <title>Apunte</title>
</head>
<body class="vista-apuntes">
    <header></header>
    <main>
        <div class="menu">
            <h4>MENÚ</h4>
        </div>
        <div class="region">
            <div class="content-region">
                <div class="apuntes">
                    <div class="content-apuntes">
                        {{-- <iframe src="https://docs.google.com/gview?url={{asset('storage').'/uploads/apuntes/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido.'&embedded=true'}}"></iframe> --}}
                        @if($apunte[0]->extension_contenido == ".pdf")
                            <iframe id="framePDF" src="{{$path}}#toolbar=0" type="application/pdf"></iframe>
                        @elseif($apunte[0]->extension_contenido == '.jpeg' || $apunte[0]->extension_contenido == '.jpg' || $apunte[0]->extension_contenido == '.png')
                            <img src="{{$path}}">
                        @endif
                    </div>
                </div>
                <div class="acciones">
                    <div class="content-acciones">
                        <div class="descargar">
                            <form action="{{url('download')}}" {{-- onsubmit="return false;" --}} method="POST"> 
                                @csrf
                                <input type="hidden" name="id" value="{{$apunte[0]->id}}">
                                <input class="btn-glass" type="submit" value="Descargar">
                            </form>
                        </div>
                        <!--DENUNCIAR COMENTARIO-->
                        @if ($apunte[0]->id_usu != Session::get('user')->id)
                            <div class="descargar">
                                <button class="btn-glass" onclick="denunciarApunte({{$apunte[0]->id_usu}},{{$apunte[0]->id}});">Denunciar</button>
                            </div>
                        @endif
                        {{-- <div class="volveratras">
                            <button class="btn-acciones" onclick="window.location.href='{{url('buscador')}}'">Volver atrás</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!--CONTENIDO DE COMENTARIOS-->
        <div>
            <div class="region region2">
                <div class="content-region">
                    <div class="glassland">
                        <div class="content-glassland">
                            <div class="crearcomentario-content-glassland">
                                <h3 class="titulo-coment">Dinos tu opinión sobre el apunte</h3>
                                <div>
                                    <!--formulario para comentar-->
                                    <form id="formAddComment" onsubmit="addcomment(); return false;" method="post">
                                        <div class="nota-resta">
                                            <div class="crear-coment">
                                                <label class="rating-label">
                                                    <input
                                                    class="rating"
                                                    max="5"
                                                    min="0"
                                                    oninput="this.style.setProperty('--value', this.value)"
                                                    step="0.5"
                                                    type="range"
                                                    value="3.5"
                                                    style="--value:3.5;"
                                                    name="val_comentario"
                                                    >
                                                </label>
                                            </div>
                                            <div class="crear-coment">
                                                <textarea name="desc_comentario" cols="60" rows="5" maxlength="200" placeholder="Esribe tu opinión"></textarea>
                                            </div>
                                            
                                            <input type="hidden" name="id_contenido" value={{$apunte[0]->id}}>

                                            <div class="crear-coment">
                                                <input class="btn-glass2" type="submit" value="Enviar">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="content-glassland">
                            <div class="comentario-content-glassland">
                                <h3 class="titulo-coment">Comentarios</h3>
                                <div id="comentarios" class="comentario">
                                    <!--COMENTARIOS-->
                                    @if (count($comentarios) > 0)
                                        @foreach($comentarios as $comentario)
                                        <div>
                                            <div style="float: left">
                                                <h4 style="margin-left:20px;">{{$comentario->nick_usu}}</h4>
                                            </div>
                                            <div style="float:left">
                                                <img src="{{asset('storage').'/'.$comentario->img_avatar}}" alt="" width="50px" height="50px" style="border-radius: 30px; margin-left:20px;">
                                            </div>
                                            <!--DENUNCIAR COMENTARIO-->
                                            @if ($comentario->id_usu != Session::get('user')->id)
                                                <div style="float:left">
                                                    <img src="{!! asset ('media/vistaapuntes/denuncia.png') !!}" onclick="denunciarComentario({{$comentario->id_usu}},{{$comentario->id}},{{$apunte[0]->id}});" alt="" width="30px" height="30px" style="margin-left:20px; cursor: pointer;">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="nota-resta">
                                            <label class="rating-label">
                                                <input
                                                    class="rating-small"
                                                    max="5"
                                                    min="0"
                                                    oninput="this.style.setProperty('--value', this.value)"
                                                    step="0.5"
                                                    type="range"
                                                    value="{{$comentario->val_comentario}}"
                                                    style="--value:{{$comentario->val_comentario}};"
                                                    disabled
                                                    >
                                            </label>
                                        </div>
                                        <div>
                                            <p class="texto-coment" id="{{$comentario->id}}">{{$comentario->desc_comentario}}</p>
                                        </div>
                                        <!--TEXTO SI NO HAY COMENTARIOS-->
                                        {{-- @if($comentario->any())
                                            <p>Actualmente no hay comentarios :)</p>
                                        @endif --}}
                                        @endforeach
                                    @else
                                        <!--TEXTO SI NO HAY COMENTARIOS-->
                                        <p>Actualmente no hay comentarios :)</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('template.footer')
</body>
</html>
