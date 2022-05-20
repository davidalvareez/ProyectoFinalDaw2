@include('template.header')
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{!!asset('css/buscador/styles.css')!!}">
    <script src="{!! asset('js/profesores/profesoresAjax.js') !!}"></script>
    <script src="{!! asset('js/buscador/js.js') !!}"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <title>Profesores</title>
</head>
<body class="main-page">
    <header class="region-header">
        <div class="content-header">
            <div class="widget-search">
                <div class="container widget-search-container">
                    <div class="searchbar">
                        <form action="">
                            <div class="row input-box"><input type="text" name="BusquedaMultiple" id="multiplysearch"></div>
                            <div class="row s-cover" id="">
                                <button type="submit" onclick="multiplyFilter();return false;"><div class="s-circle"></div><span></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="advancedSearch">
                <div class="container">
                    <form onchange="advancedFilterProfesores();" method="POST" id="filterCurso">
                        @foreach($allCursos as $cursos)
                            <input type="checkbox" name="cursos" value="{{$cursos->id}}"/>
                            <label name="{{$cursos->nombre_curso}}">{{$cursos->nombre_curso}}</label>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="" id="contenedor">
            <table class="table table-striped table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Nombre Y Apellidos</th>
                    <th scope="col">Acciones</th>
                </tr>
                @foreach($MostrarProfesores as $Resultados)
                <tr>
                    <td>{{$Resultados->id}}</td>
                    <td><img src="{{asset('storage').'/'.$Resultados->img_avatar}}" width="50"></td>
                    <td>{{$Resultados->nombre_usu}} {{$Resultados->apellido_usu}}</td>
                    <td><button class="boton_modificar" type="submit" id="" onclick="mostrarEstudios({{$Resultados->id}}); return false;">Mostrar Estudios</button></td>
                    <td><button class="boton_modificar" type="submit" id="" onclick="mostrarCurriculum({{$Resultados->id}}); return false;">Mostrar Curriculum</button></td>
                    <td><form  action="{{url('')}}" method="GET">
                        <button class="boton_modificar" type="submit" id="">Contactar</button>
                    </form></td>
                </tr>
                @endforeach
            </table>
        </div>
    </main>
    @include('template.footer')
</body>
</html>