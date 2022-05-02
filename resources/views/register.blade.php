@include('template.header')
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
                                        <div>
                                            <button class="elegiravatar" onclick="avatarSelected('{{$avatar->img_avatar}}'); chBackcolor(this);return false;"><img src={{asset('storage').'/'.$avatar->img_avatar}} width="100px" height="100px"></button>
                                        </div>
                                        @endforeach
                                    </div>
                                    <p style="float: left; padding-left:75px">o sube tu propio avatar:</p>
                                    <input type="file" name="img_avatar_usu" id="img_avatar_usu">
                                    <br><br>
                                    <button onclick="closeModal2();return false;" class="aceptarbtn" value="Aceptar">Aceptar</button>
                                </div>
                            </div>
                            <img src="{!! asset ('media/3Dicons-dinamicos/icons/png/boy\boy-dynamic-gradient.png') !!}" width="80px" height="80px">
                            <h2>¡Regístrate y accede a todas las ventajas de NoteHub!</h2>
                            <br>
                            
                            <form action="{{url('register')}}" id="idRegister" onsubmit="return hasAvatarOrImage();" method="post" enctype="multipart/form-data">
                               
                                @csrf
                                
                                <div class="one-column">
                                    <div class="menudos">
                                        <h4 class="pizq">Nombre</h4>
                                        <div>
                                            <input class="inputbtn" type="text" name="nombre_usu" id="nombre_usu" placeholder="Nombre">
                                        </div>
                                        <div>
                                            @error('nombre_usu')
                                            <p class="errortext">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="menudos">
                                        <h4 class="pizq">Apellido</h4>
                                        <div>
                                            <input class="inputbtn" type="text" name="apellido_usu" id="apellido_usu" placeholder="Apellido">
                                        </div>
                                        <div>
                                            @error('apellido_usu')
                                            <p class="errortext">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="one-column">
                                    <div class="menudos">
                                        <h4 class="pizq">Nickname</h4>
                                        <div>
                                            <input class="inputbtn" type="text" name="nick_usu" id="nick_usu" placeholder="Nickname">
                                        </div>
                                        <div>
                                            @error('nick_usu')
                                            <p class="errortext">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="menudos">
                                        <h4 class="pizq">Fecha de nacimiento</h4>
                                        <div>
                                            <input class="inputbtn" type="date" name="fecha_nac_usu" id="fecha_nac_usu">
                                        </div>
                                        <div>
                                            @error('fecha_nac_usu')
                                            <p class="errortext">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="one-column">
                                    <div class="menudos">
                                        <h4 class="pizq">Centro</h4>
                                        <div>
                                            <select class="inputbtn" name="centro" id="centro">
                                                <option value="">--</option>
                                                @foreach($centros as $centro)
                                                    <option value="{{$centro->id}}">{{$centro->nombre_centro}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            @error('centro')
                                            <p class="errortext">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="menudos">
                                        <h4 class="pizq">Email</h4>
                                        <div>
                                            <input class="inputbtn" type="email" name="correo_usu" id="correo_usu" placeholder="Email">
                                        </div>
                                        <div>
                                            @error('correo_usu')
                                            <p class="errortext">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="menudos">
                                        <h4 class="pizq">Contraseña</h4>
                                        <div>
                                            <input class="inputbtn" type="password" name="contra_usu" id="contra_usu" placeholder="Contraseña">
                                        </div>
                                        <div>
                                            @error('contra_usu')
                                            <p class="errortext">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="menudos">
                                        <h4 class="pizq">Repetir contraseña</h4>
                                        <div>
                                            <input class="inputbtn" type="password" name="contra_usu_verify" id="contra_usu_verify" placeholder="Repetir contraseña">
                                        </div>
                                        <div>
                                            @error('contra_usu_verify')
                                            <p class="errortext">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="menuuno">
                                    <h4 class="pizq">Avatar</h4>
                                    <div>
                                        <input class="inputbtn-selec" id="clickselec" type="submit" onclick="modalbox();return false;" value="CLICK PARA SELECCIONAR AVATAR">
                                        <input type="hidden" name="img_avatar_sistema" id="img_avatar_sistema" value="">
                                        <input type="file" name="img_avatar_usu2" id="img_avatar_usu2" value="">
                                    </div>
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
                    <img src="{!! asset ('media/fotos_loginregister/imagen2.png') !!}" alt="imgregistro" class="imgredondeada2">
                </div>
            </div>
        </div>
    </main>
</body>
</html>
@include ('template.footer')