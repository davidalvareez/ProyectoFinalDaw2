@include('template.header')
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
        <div class="title-text">
            <h3>Subir nuevo apunte</h3>
        </div>
        <div class="region region1">
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="misapuntes-content-glassland">
                            <div id="divFormSubirApuntes" class="">
                                <form onsubmit="subirApuntes(); return false;" id="formSubirApuntes" enctype="multipart/form-data">
                                    <div style="float: left; width:100%">
                                        <div class="padding-subirapuntes">
                                            <label for="">Seleccionar centro</label>
                                            <br>
                                            <input class="inputbtn" name="centro" autocomplete="off" list="centros" placeholder="SELECCIONAR CENTRO" onchange="selectCurso();">
                                            <datalist id="centros">
                                                @foreach($selectCentro as $centro)
                                                    <option value="{{$centro->nombre_centro}}">{{$centro->nombre_centro}}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="padding-subirapuntes">
                                            <label for="">Seleccionar curso</label>
                                            <br>
                                            <select disabled class="inputbtn-selec" name="curso" autocomplete="off" list="cursos" placeholder="Seleccionar curso" onchange="selectAsignatura();">
                                                <option value="" selected>--</option>
                                                {{-- @foreach($selectCurso as $curso)
                                                    <option value="{{$curso->nombre_curso}}">{{$curso->nombre_curso}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="padding-subirapuntes">
                                            <label for="">Seleccionar asignatura</label>
                                            <br>
                                            <select disabled class="inputbtn-selec" name="asignatura" autocomplete="off" list="asignaturas" placeholder="Seleccionar asignatura" onchange="selectTema();">
                                                <option value="" selected>--</option>
                                                {{-- @foreach($selectAsignatura as $asignatura)
                                                    <option value="{{$asignatura->nombre_asignatura}}">{{$asignatura->nombre_asignatura}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="padding-subirapuntes">
                                            <label for="">¿Nuevo tema? </label>
                                            <input type="radio" name="newTema" id="radioYes" value="si">Si
                                            <input type="radio" name="newTema" id="radioNo" value="no" checked>No
                                            <br>
                                            <div>
                                                <div id="selectTema" style="display: ; float: left;">
                                                    <select disabled name="select_tema" class="inputbtn-selec" autocomplete="off" list="temas" placeholder="Seleccionar tema">
                                                        <option value="" selected>--</option>
                                                        {{-- @foreach($selectTema as $tema)
                                                            <option value="{{$tema->nombre_tema}}">{{$tema->nombre_tema}}</option>
                                                        @endforeach --}}
                                                    </select>
                                                </div>
                                                <div id="textNewTema" style="display: none; float: left;">
                                                    <input class="inputbtn" type="text" name="text_tema" id="text_tema" placeholder="Escribe el tema">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="padding-subirapuntes">
                                            <label for="">Seleccionar archivo</label>
                                            <br>
                                            <input class="inputbtn-file" type="file" name="apuntes" id="">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="padding-subirapuntes-submit">
                                            <input type="submit" value="Subir apunte" class="btn-glass">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="">
            <div class="title-text">
                <h3>Mis Apuntes</h3>
            </div>
            <div class="region region2">
                <div class="content-region">
                    <div class="glassland">
                        <div class="content-glassland">
                            <div class="misapuntes-content-glassland">
                                <table class="table" id="content">
                                    <tr>
                                        <th style="text-align: center"><b>Documento</b></th>
                                        <th style="text-align: center"><b>Fecha Publicacion</b></th>
                                        <th></th>
                                    </tr>
                                    @foreach($select as $apuntes)
                                    <tr>
                                        <td>{{$apuntes->nombre_contenido}}{{$apuntes->extension_contenido}}</td>
                                        <td>{{$apuntes->fecha_publicacion_contenido}}</td>
                                        <td>
                                            <button class="btn btn-danger" type="submit" id="" onclick="eliminarApunte({{$apuntes->id}})">Eliminar</button>
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
    @include ('template.footer')
</body>
</html>