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
    <link rel="stylesheet" href="{!! asset ('css/misapuntes/misapuntes.css')!!}">
    <script src="{!! asset('js/misApuntes/misApuntesAjax.js') !!}"></script>
    <title>Mis apuntes</title>
</head>
<body class="misapuntes-page">
    <header></header>
    <main>
        <div class="menu">
            <h4>MENÚ</h4>
        </div>

        {{-- <form action='{{url('logout')}}' method='get'>
            <button class="btn btn-secondary">Logout</button>
        </form> --}}
        <h3>Subir nuevo apunte</h3>
        <div class="region region1">
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="misapuntes-content-glassland">
                            <div id="divFormSubirApuntes" class="">
                                <form onsubmit="subirApuntes(); return false;" id="formSubirApuntes" enctype="multipart/form-data">
                                    <div style="float: left">
                                        <select class="inputbtn-selec" name="centro" onchange="selectCurso();">
                                            <option value="" selected disabled>Seleccionar centro</option>
                                            @foreach($selectCentro as $centro)
                                                <option value="{{$centro->nombre_centro}}">{{$centro->nombre_centro}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="float: left">
                                        <select class="inputbtn-selec" name="curso" onchange="selectAsignatura();">
                                            <option value="" selected disabled>Seleccionar curso</option>
                                            @foreach($selectCurso as $curso)
                                                <option value="{{$curso->nombre_curso}}">{{$curso->nombre_curso}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="float: left">
                                        <select class="inputbtn-selec" name="asignatura" onchange="selectTema();">
                                            <option value="" selected disabled>Seleccionar asignatura</option>
                                            @foreach($selectAsignatura as $asignatura)
                                                <option value="{{$asignatura->nombre_asignatura}}">{{$asignatura->nombre_asignatura}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="float: left">
                                        <label for="">¿Nuevo tema?</label>
                                        <input type="radio" name="newTema" id="radioYes" value="si">Si
                                        <input type="radio" name="newTema" id="radioNo" value="no">No
                                    </div>
                                    <div id="selectTema" style="display: none; float: left;">
                                        <select name="select_tema" class="inputbtn-selec">
                                            <option value="" selected disabled>Seleccionar tema</option>
                                            @foreach($selectTema as $tema)
                                                <option value="{{$tema->nombre_tema}}">{{$tema->nombre_tema}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="textNewTema" style="display: none; float: left;">
                                        <input class="inputbtn" type="text" name="text_tema" id="text_tema">
                                    </div>
                                    <div  style="float: left">
                                        <input type="file" name="apuntes" id="">
                                    </div>
                                    <div>
                                        <input type="submit" value="Subir apunte" class="btn-glass">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="">
            <h3>Mis Apuntes</h3>
            <div class="region region2">
                <div class="content-region">
                    <div class="glassland">
                        <div class="content-glassland">
                            <div class="misapuntes-content-glassland">
                                <table class="table" id="content">
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
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </main>
</body>
</html>
@include ('template.footer')