<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <script src="{!! asset('js/moderador/moderadorAjax.js') !!}"></script>
    <title>Vista Moderador</title>
</head>
<body>
    <div class="">
        <h3>Vista Moderador</h3>
    </div>
    <div class="">
        <table class="table table-striped table-dark">
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Descripción</th>
                <th scope="col">Acusado</th>
                <th scope="col">Demandante</th>
                <th scope="col">Acciones</th>
            </tr>
            @foreach($moderador as $registro)
            <tr>
                <td>{{$registro->tipus_denuncia}}</td>
                <td>{{$registro->desc_denuncia}}</td>
                <td>{{$registro->acusado}}</td>
                <td>{{$registro->demandante}}</td>
                <td><button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar('{{$registro->id}}');return false;">Eliminar</button></td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>