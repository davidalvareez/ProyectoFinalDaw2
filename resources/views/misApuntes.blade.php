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
        <form action="" method="">
            <button class="btn btn-dark" type="submit" id="">Subir apunte</button>
        </form>
    </div>
    <div class="">
        <h3>Mis Apuntes</h3>
        <table class="table table-striped table-dark">
            <tr>
                <th scope="col">Documento</th>
                <th scope="col">Fecha Publicacion</th>
            </tr>
            @foreach($select as $apuntes)
            <tr>
                <td>{{$apuntes->nombre_contenido}}{{$apuntes->extension_contenido}}</td>
                <td>{{$apuntes->fecha_publicacion_contenido}}</td>
                <td><form action="" method="">
                    <button class="btn btn-light" type="submit" id="">Eliminar</button>
                </form></td>
            </tr>
            @endforeach
        </table>    
    </div>
</body>
</html>