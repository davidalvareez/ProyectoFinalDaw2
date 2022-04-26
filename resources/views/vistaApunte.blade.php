@include('template.header')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{!! asset ('css/vistaapuntes/vistaapuntes.css') !!}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{!! asset('js/vistaapuntes/vistaapuntes.js') !!}"></script>
    <title>Apunte</title>
</head>
<body class="vista-apuntes">
    <header></header>
    <main>
        <div class="region">
            <div class="content-region">
                <div class="apuntes">
                    
                    <div class="content-apuntes">
                        {{-- <iframe src="https://docs.google.com/gview?url={{asset('storage').'/uploads/apuntes/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido.'&embedded=true'}}"></iframe> --}}
                        @if($apunte[0]->extension_contenido == ".pdf")
                            <iframe src="{{$path}}" type="application/pdf"></iframe>
                        @elseif($apunte[0]->extension_contenido == ".doc" || $apunte[0]->extension_contenido == ".docx")
                            <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{$path}}" frameborder="0"></iframe>
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
                                <input class="btn-acciones" type="submit" value="Descargar">
                            </form>
                        </div>
                        <div class="volveratras">
                            <button class="btn-acciones" onclick="window.location.href='{{url('buscador')}}'">Volver atrás</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--CONTENIDO DE COMENTARIOS-->
        <div>
            <div>
                <!--formulario para comentar-->
                <form action="{{url("apuntes/comentar")}}" method="post">
                @csrf
                    <div class="nota-resta">
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
                        <textarea name="desc_comentario" cols="30" rows="10"></textarea>
                        <input type="hidden" name="id_contenido" value={{$apunte[0]->id}}>
                        <input type="submit" value="Enviar">
                    </div>
                </form>
            </div>
            <div>
                <!--COMENTARIOS-->
                @foreach($comentarios as $comentario)
                    <img src="{{asset('storage').'/'.$comentario->img_avatar}}" alt="">
                    <h1>{{$comentario->nick_usu}}</h1>
                    <div class="nota-resta">
                        <label class="rating-label">
                            <input
                              class="rating"
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
                    <p>{{$comentario->desc_comentario}}</p>
                @endforeach
            </div>
        </div>
    </main>
    <footer>@include('template.footer')</footer>
</body>
</html>
