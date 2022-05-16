@include('template.header')
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{!! asset('css/zonaadmin/zonaadmin.css') !!}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../public/js/registro/registro.js"></script>
    <script src="{!! asset('js/admin/adminAjax.js') !!}"></script>
    <title>Admin CPanel</title>
</head>
<body class="zonaadmin">
    <main>
        <center>
        <div class="region region1">
            <div class="menu">
                <div class="content-menu">
                    <h1>Panel del administrador</h1>
                    {{-- <form action='{{url('logout')}}' method='get'>
                        <button class="btn btn-secondary">Logout</button>
                    </form> --}}
                    <button class="boton-menu cgradient-1" onclick="showUsers();closeModal();return false">Users</button>
                    <button class="boton-menu cgradient-1" onclick="showCentros();closeModal();return false">Centros</button>
                    <button class="boton-menu cgradient-1" onclick="showApuntes();closeModal();return false">Apuntes</button>
                    <button class="boton-menu cgradient-1" onclick="showDenuncias();closeModal();return false">Denuncias</button>
                    <button class="boton-menu cgradient-1" onclick="showHistorial();closeModal();return false">Historial</button>
                    <div id="message" style="color:green"></div>

                    <div class="filtrador">
                        <form method="post" onsubmit="filtro();return false;">
                            <input type="hidden" name="_method" value="POST" id="postFiltro">
                            <div class="form-outline">
                               <input type="search" id="search" name="titulo" class="form-control" placeholder="Buscar por titulo..." aria-label="Search" onkeyup="filtro(); return false;"/>
                            </div>
                         </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="region region2">
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="admin-content-glassland">
                            <div class="tablas">
                                <div class="content-tablas">
                                    <div id="content">
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
