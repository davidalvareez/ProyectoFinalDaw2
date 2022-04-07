<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../public/js/registro/registro.js"></script>
    <link rel="stylesheet" href="{!! asset ('css/registro/loginregistro.css')!!}">
    <script src="{!! asset ('js/fontawesomePRO.js')!!}"></script>
    <title>Register</title>
</head>
<body class="registro-page">
    <header>
    </header>
    <main> 
        <div class="region region1">
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="registro-content-glassland">
                            <img src="{!! asset ('media/3Dicons-dinamicos/icons/png/boy\boy-dynamic-gradient.png') !!}" width="80px" height="80px">
                            <h2>¡Regístrate y accede a todas las ventajas de NoteHub!</h2>
                            <br>
                            <form action="{{url('register')}}" onsubmit="return hasAvatarOrImage();" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="menudos">
                                    <p class="pizq">Nombre</p>
                                    <input class="inputbtn" type="text" name="nombre_usu" id="nombre_usu" placeholder="Nombre">
                                    @error('nombre_usu')
                                    <p>{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="menudos">
                                    <p class="pizq">Apellido</p>
                                    <input class="inputbtn" type="text" name="apellido_usu" id="apellido_usu" placeholder="Apellido">
                                    @error('apellido_usu')
                                    <p>{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="menudos">
                                    <p class="pizq">Nickname</p>
                                    <input class="inputbtn" type="text" name="nick_usu" id="nick_usu" placeholder="Nickname">
                                    @error('nick_usu')
                                    <p>{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="menudos">
                                    <p class="pizq">Fecha de nacimiento</p>
                                    <input class="inputbtn" type="date" name="fecha_nac_usu" id="fecha_nac_usu">
                                    @error('fecha_nac_usu')
                                    <p>{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="menudos">
                                    <p class="pizq">Centro</p>
                                    <select class="inputbtn" name="centro" id="centro">
                                        <option value="">--</option>
                                        @foreach($centros as $centro)
                                            <option value="{{$centro->id}}">{{$centro->nombre_centro}}</option>
                                        @endforeach
                                    </select>
                                    @error('centro')
                                    <p>{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="menudos">
                                    <p class="pizq">Email</p>
                                    <input class="inputbtn" type="email" name="correo_usu" id="correo_usu" placeholder="Email">
                                    @error('correo_usu')
                                    <p>{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="menudos">
                                    <p class="pizq">Contraseña</p>
                                    <input class="inputbtn" type="password" name="contra_usu" id="contra_usu" placeholder="Contraseña">
                                    @error('contra_usu')
                                    <p>{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="menudos">
                                    <p class="pizq">Repetir contraseña</p>
                                    <input class="inputbtn" type="password" name="contra_usu_verify" id="contra_usu_verify" placeholder="Repetir contraseña">
                                    @error('contra_usu_verify')
                                    <p>{{$message}}</p>
                                    @enderror
                                </div>
                                <div id="myModal" class="modal">
                                    <div class="modal-content">
                                        <span class="close" onclick="closeModal();">&times;</span>
                                        <br><br>
                                        <h1>Escoge tu avatar</h1>
                                        <br>
                                        <p style="float: left; padding-left:75px">Selecciona un avatar predefinido:</p>
                                        <br>
                                        <div class="grid">
                                            @foreach($avatares as $avatar)
                                            <div class="modal-3">
                                                <button onclick="avatarSelected('{{$avatar->img_avatar}}');return false;"><img src={{asset('storage').'/'.$avatar->img_avatar}} width="100px" height="100px"></button>
                                            </div>
                                            @endforeach
                                        </div>
                                        <p style="float: left; padding-left:75px">o sube tu propio avatar:</p>
                                        <input type="file" name="img_avatar_usu" id="img_avatar_usu">
                                        <br><br>
                                        <button onclick="closeModal();return false;" class="aceptarbtn" value="Aceptar">Aceptar</button>
                                    </div>
                                </div>
                                <div class="menuuno">
                                    <p class="pizq">Avatar</p>
                                    <input class="inputbtn-selec" type="submit" onclick="modalbox();return false;" value="CLICK PARA SELECCIONAR AVATAR">
                                    <input type="hidden" name="img_avatar_sistema" id="img_avatar_sistema" value="">
                                </div>
                                <!-- <div class="alienarright">
                                    <a href="">
                                        <p>Contraseña olvidada?</p>
                                    </a>
                                </div> -->
                                <div class="menuuno">
                                    <input class="login-btn-absglass" type="submit" value="ENTRAR"></input>
                                </div>
                                <div class="">
                                    <div class="alienarleft">
                                        <p>Ya estás registrado?</p>
                                    </div>
                                    <div class="alienarleft">
                                        <a href="{{url('login')}}">
                                            <p>Inicia sesión</p>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-region">
                <div class="imagenrelleno">
                    <img src="{!! asset ('media/fotos_loginregister/imagen2.2.png') !!}" alt="imgregistro" class="imgredondeada2">
                </div>
            </div>
        </div>
    </main>
    {{-- <footer class="footer-distributed">

        <div class="footer-right">

            <a href="https://www.facebook.com/notehub.oficial"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://twitter.com/notehub_oficial"><i class="fa-brands fa-twitter"></i></a>
            <a href="https://www.instagram.com/notehub.oficial"><i class="fa-brands fa-instagram"></i></a>

        </div>

        <div class="footer-left">

            <p class="footer-links">

                <a class="link-1">2022</a>

                <a href="https://goo.gl/maps/TVrDESsEywPBnykd6">Hospitalet de Llobregat</a>

                <a href="mailto:notehubdaw2@gmail.com">notehubdaw2@gmail.com</a>
            </p>

            <p>NoteHub &copy; 2022</p>
        </div>

    </footer> --}}
</body>
</html>
@include ('template.footer')