<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{!! asset('css/zonaadmin/zonaadmin.css') !!}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
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
                    <button class="boton-menu cgradient-1" onclick="showUsers();return false">Users</button>
                    <button class="boton-menu cgradient-1" onclick="showCentros();return false">Centros</button>
                    <button class="boton-menu cgradient-1" onclick="showApuntes();return false">Apuntes</button>
                    <button class="boton-menu cgradient-1" onclick="showDenuncias();return false">Denuncias</button>
                    <button class="boton-menu cgradient-1" onclick="showHistorial();return false">Historial</button>
                    <div id="message" style="color:green"></div>
                </div>
            </div>
        </div>
        <div class="region region2">
            <div class="tablas">
                <div class="content-tablas">
                    <div id="content">
    
                    </div>
                    <div id="myModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal();">&times;</span>
                            <form id="formUpdate" method="post" onsubmit="actualizarCentros();closeModal();return false;">
                                <h2 id="nombreCentro"></h2>
                                <b><span>Nombre centro:</span>
                                <input type="text" name="nombre" id="nombreUpdate"><br>
                                <b><span>Pais centro:</span>
                                <input type="text" name="pais" id="paisUpdate"><br>
                                <b><span>Comunidad autonoma:</span>
                                <input type="text" name="com_auto" id="com_autoUpdate"><br>
                                <b><span>Ciudad:</span>
                                <input type="text" name="ciudad" id="ciudadUpdate"><br>
                                <b><span>Dirección:</span>
                                <input type="text" name="direccion" id="direccionUpdate"><br>
                                <input type="hidden" name="id" id="idUpdate">
                                <input type="submit" value="Editar">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
