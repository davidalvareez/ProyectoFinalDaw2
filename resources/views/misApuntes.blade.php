@include('template.header')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="{!! asset('js/misApuntes/misApuntesAjax.js') !!}"></script>
    <title>Mis apuntes</title>
</head>
<body>
    <div class="">
        <button class="btn btn-dark" onclick="openformSubirApuntes(); return false;" type="submit">Subir apunte</button>
    </div>
    {{-- <form action='{{url('logout')}}' method='get'>
        <button class="btn btn-secondary">Logout</button>
    </form> --}}
    <div id="divFormSubirApuntes" style="display: none;" class="">
        <form onsubmit="subirApuntes(); return false;" id="formSubirApuntes" enctype="multipart/form-data">
            <select name="curso" onchange="selectAsignatura();">
                <option value="">--</option>
                @foreach($selectCurso as $curso)
                    <option value="{{$curso->nombre_curso}}">{{$curso->nombre_curso}}</option>
                @endforeach
            </select>
            <select name="asignatura" onchange="selectTema();">
                <option value="">--</option>
                @foreach($selectAsignatura as $asignatura)
                    <option value="{{$asignatura->nombre_asignatura}}">{{$asignatura->nombre_asignatura}}</option>
                @endforeach
            </select>
            <label for="">¿Nuevo tema?</label>
            <input type="radio" name="newTema" id="radioYes" value="si">Si
            <input type="radio" name="newTema" id="radioNo" value="no">No
            <div id="selectTema" style="display: none;">
                <select name="select_tema">
                    <option value="">--</option>
                    @foreach($selectTema as $tema)
                        <option value="{{$tema->nombre_tema}}">{{$tema->nombre_tema}}</option>
                    @endforeach
                </select>
            </div>
            <div id="textNewTema" style="display: none;">
                <input type="text" name="text_tema" id="text_tema">
            </div>
            <input type="file" name="apuntes" id="">
            <input type="hidden" id="id_centro" name="id_centro" value="{{$user->id_centro}}">
            <input type="submit" value="Subir apunte">
        </form>
    </div>
    <div class="">
        <h3>Mis Apuntes</h3>
        <table class="table table-striped table-dark" id="content">
            <tr>
                <th scope="col">Documento</th>
                <th scope="col">Fecha Publicacion</th>
            </tr>
            @foreach($select as $apuntes)
            <tr>
                <td>{{$apuntes->nombre_contenido}}{{$apuntes->extension_contenido}}</td>
                <td>{{$apuntes->fecha_publicacion_contenido}}</td>
                <td>
                    <button class="btn btn-light" type="submit" id="" onclick="eliminarApunte({{$apuntes->id}})">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </table>    
    </div>
</body>
</html>
@include ('template.footer')