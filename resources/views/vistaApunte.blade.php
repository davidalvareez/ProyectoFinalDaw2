@include('template.header')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{!! asset ('css/vistaapuntes/vistaapuntes.css') !!}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{!! asset('js/perfil/miPerfilAjax.js') !!}"></script>
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
    </main>
    <footer>@include('template.footer')</footer>
</body>
</html>
