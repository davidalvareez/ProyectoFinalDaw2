<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <script src="{!! asset('js/buscador/buscadorAjax.js') !!}"></script>
    <title>Buscador</title>
</head>
<body>
    <div>
        <h1>Busqueda avanzada</h1>
        <form method="POST" id="formBusquedaAvanzada" onsubmit="return false;">
            <select name="centros" onchange="busquedaAvanzada();selectCurso_Asignatura();">
                <option value="">--</option>
                @foreach($listaCentros as $centros)
                <option value="{{$centros->nombre_centro}}">{{$centros->nombre_centro}}</option>
                @endforeach
            </select>
            <select name="cursos" onchange="busquedaAvanzada();selectAsignatura();">
                <option value="">--</option>
                @foreach($listaCursos as $cursos)
                <option value="{{$cursos->nombre_curso}}">{{$cursos->nombre_curso}}</option>
                @endforeach
            </select>
            <select name="asignaturas" onchange="busquedaAvanzada()">
                <option value="">--</option>
                @foreach($listaAsignaturas as $asignaturas)
                <option value="{{$asignaturas->nombre_asignatura}}">{{$asignaturas->nombre_asignatura}}</option>
                @endforeach
            </select>
            <input type="text" name="nombre_tema" placeholder="Introduce nombre del tema..."  onkeyup="busquedaAvanzada()">
        </form>
    </div>
    <div>
        <h1>Busqueda normal</h1>
        <p>¿Que deseas buscar?</p>
        <input type="text" onkeyup="multiplyFilter();return false;" name="BusquedaMultiple" id="multiplysearch">
    </div>
    <!--RESULTADO DE BUSQUEDA TANTO AVANZADA COMO NORMAL-->
    <div id="contentFilter"></div>
    <!--APUNTES MÁS RECIENTES-->
    <div>
        <h1>Más recientes</h1>
        <table>
                @foreach($recent as $recentnotes)
                <tr>
                    <td>{{$recentnotes->nombre_contenido}}{{$recentnotes->extension_contenido}}</td>
                    <td><img src="{{asset('storage').'/'.$recentnotes->img_avatar}}"></td>
                    <td>{{$recentnotes->nick_usu}}</td>
                    <td>{{$recentnotes->idioma_contenido}}</td>
                    <td>{{$recentnotes->fecha_publicacion_contenido}}</td>
                </tr>
                @endforeach
        </table>
    </div>
    <!--APUNTES MÁS POPULARES-->
    <div>
        <h1>Más populares</h1>
        <table>
            @foreach($popular as $popularnotes)
            <tr>
                <td>{{$popularnotes->nombre_contenido}}{{$popularnotes->extension_contenido}}</td>
                <td><img src="{{asset('storage').'/'.$popularnotes->img_avatar}}"></td>
                <td>{{$popularnotes->nick_usu}}</td>
                <td>{{$popularnotes->idioma_contenido}}</td>
                <td>{{$popularnotes->fecha_publicacion_contenido}}</td>
                <td><button onclick="window.location.href='{{url('apuntes/'.$popularnotes->id)}}'">Ver apunte</button></td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>