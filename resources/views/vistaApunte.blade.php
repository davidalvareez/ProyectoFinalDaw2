<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="{!! asset('js/perfil/miPerfilAjax.js') !!}"></script>
    <title>Apunte</title>
</head>
<body>
    <div class="">
        <img src="{{asset('storage').'/'.$apunte[0]->img_avatar}}" alt="Avatar Del usuario">
    </div>
    <div class="">
        <!--<iframe src="https://docs.google.com/gview?url={{asset('storage').'/uploads/apuntes/'.$apunte[0]->nombre_contenido.$apunte[0]->extension_contenido.'&embedded=true'}}"></iframe>-->
        @if($apunte[0]->extension_contenido == ".pdf")
            <iframe width="400" height="400" src="{{$path}}" type="application/pdf"></iframe>
        @elseif($apunte[0]->extension_contenido == ".doc" || $apunte[0]->extension_contenido == ".docx")
            <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{$path}}" frameborder="0"></iframe>
        @elseif($apunte[0]->extension_contenido == '.jpeg' || $apunte[0]->extension_contenido == '.jpg' || $apunte[0]->extension_contenido == '.png')
            <img src="{{$path}}">
        @endif
    </div>
    <div class="">
        <form action="{{url('download')}}" {{-- onsubmit="return false;" --}} method="POST"> 
            @csrf
            <input type="hidden" name="id" value="{{$apunte[0]->id}}">
            <input type="submit" value="Descargar">
        </form>
    </div>
</body>
</html>