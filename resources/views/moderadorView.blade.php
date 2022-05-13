@include('template.header')
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{!! asset('css/moderador/moderador.css') !!}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="{!! asset('js/moderador/moderadorAjax.js') !!}"></script>
    <title>Vista Moderador</title>
</head>
<body class="zonamoderador">
    <main>
        <center>
            <div class="region region1">
                <div class="menu">
                    <div class="content-menu">
                        <h1>Vista Moderador</h1>
                        {{-- <form action='{{url('logout')}}' method='get'>
                            <button class="btn btn-secondary">Logout</button>
                        </form> --}}
                        <button class="boton-menu cgradient-1" return false">Denuncias</button>
                    </div>
                </div>
            </div>
        {{-- <form action='{{url('logout')}}' method='get'>
            <button class="btn btn-secondary">Logout</button>
        </form> --}}
        <div class="region region2">
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="admin-content-glassland">
                            <div class="tablas">
                                <div class="content-tablas">
                                    <div class="">
                                        <table class="table table-striped">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Acusado</th>
                                                <th scope="col">Demandante</th>
                                                <th scope="col" colspan="2">Acciones</th>
                                            </tr>
                                            @foreach($moderador as $registro)
                                            <tr>
                                                <td scope="row"><b>{{$registro->id}}</b></td>
                                                <td>{{$registro->tipus_denuncia}}</td>
                                                <td>{{$registro->desc_denuncia}}</td>
                                                <td>{{$registro->acusado}}</td>
                                                <td>{{$registro->demandante}}</td>
                                                <td><button class="btn btn-secondary" type="submit" value="Edit" onclick="opciones('{{$registro->id}}');return false;">Opciones</button></td>
                                                <td><button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar('{{$registro->id}}');return false;">Eliminar</button></td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div id="myModal" class="modal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- @include ('template.footer') --}}
</body>
</html>
