@include('template.header')
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
    <title>Mi Perfil</title>
</head>
<body>
    
    <div class="">
        <img src="{{asset('storage').'/'.$perfilUser[0]->img_avatar}}" alt="Avatar Del usuario">
        {{-- <form action='{{url('logout')}}' method='get'>
            <button class="btn btn-secondary">Logout</button>
        </form> --}}
        <div class="">
            <h3>{{$perfilUser[0]->nick_usu}}</h3>
        </div>
        
    </div>
    <div class="">
        <table class="table table-striped table-dark">
            <tr>
                <th scope="col">Nombre Apellido</th>
                <th scope="col">Fecha Nacimiento</th>
                <th scope="col">Correo</th>
                <th scope="col">Nombre Centro</th>
            </tr>
            <tr>
                <td>{{$perfilUser[0]->nombre_usu}} {{$perfilUser[0]->apellido_usu}}</td>
                <td>{{$perfilUser[0]->fecha_nac_usu}}</td>
                <td>{{$perfilUser[0]->correo_usu}}</td>
                <td>{{$perfilUser[0]->nombre_centro}}</td>
            </tr>
        </table>
    </div>
    <div class="">
        <h3>Mis Apuntes</h3>
        <table class="table table-striped table-dark">
            <tr>
                <th scope="col">Documento</th>
                <th scope="col">Fecha Publicacion</th>
            </tr>
            @foreach($apuntesUser as $apuntes)
            <tr>
                <td>
                    <form action="{{url('apuntes')}}"></form>
                    {{$apuntes->nombre_contenido}}{{$apuntes->extension_contenido}}
                </td>
                <td>{{$apuntes->fecha_publicacion_contenido}}</td>
            </tr>
            @endforeach
        </table>    
    </div>
</body>
</html>
@include ('template.footer')