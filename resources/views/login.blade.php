@include('template.header')
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{!! asset ('css/registro/loginregistro.css')!!}">
    <script src="{!! asset ('js/login/login.js')!!}"></script>
    <title>Login page</title>
</head>

<body class="login-page">
    @if(isset($fail_login))
        @if ($fail_login == true)
            {{$fail_login = false;}}
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Usuario y contraseña incorrecto',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif
    @endif
    @if(isset($fail_validate))
        @if ($fail_validate == true)
            {{$fail_validate = false;}}
            <script>
                Swal.fire({
                icon: 'warning',
                title: 'Cuenta no validada',
                footer: '<a href="validarcorreo">Validar cuenta</a>'
                })
            </script>
        @endif
    @endif
    @if(isset($fail_banned))
        @if ($fail_banned == true)
            {{$fail_validate = false;}}
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Tu cuenta sigue baneada',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            </script>
        @endif
    @endif
    <header>
    </header>
    <main>
        <div class="region region1">
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="login-content-glassland">
                            <img src="{!! asset ('media/3Dicons-dinamicos/icons/png/boy\boy-dynamic-gradient.png') !!}" width="80px" height="80px">
                            <h2>¡Inicia sesión y disfruta de NoteHub!</h2>
                            <br>
                            <form action="{{url('login')}}" method="post">
                                @csrf
                                <div>
                                    <h4 class="pizq">Email o Nickname</h4>
                                    <input class="inputbtn" type="text" name="correo_nick" id="correo_nick" placeholder="&#xf007">
                                    @error('correo_nick')
                                    <p class="errortext">{{$message}}</p>
                                    @enderror
                                </div>
                                <br>
                                <div>
                                    <h4 class="pizq">Contraseña</h4>
                                    <input class="inputbtn" type="password" name="contra_usu" id="contra_usu" placeholder="&#xf023">
                                    @error('contra_usu')
                                    <p class="errortext">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="alienarright">
                                    <a onclick="forgetPassword();">
                                        <p>Contraseña olvidada?</p>
                                    </a>
                                </div> -->
                                <div class="boton-entrar">
                                    <input class="login-btn-absglass" type="submit" value="ENTRAR">
                                </div>
                                <div class="redes-sociales">
                                    <div class="alienarleft-2">
                                        <h4>o inicia sesión con:</h4>
                                    </div>
                                    <div class="botones-distributed">
                                        <div class="botones-right">
                                            <a onclick="{{url('login-facebook')}}"><img src="{!! asset ('media/loginregister/facebook.png') !!}" alt="facebook" class="icono-socialmedia"></a>
                                            <a onclick="{{url('login-twitter')}}"><img src="{!! asset ('media/loginregister/twitter.png') !!}" alt="twitter" class="icono-socialmedia"></a>
                                            <a onclick="{{url('login-google')}}"><img src="{!! asset ('media/loginregister/google.png') !!}" alt="google" class="icono-socialmedia"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="alienarleft">
                                        <p>No estás registrado?</p>
                                    </div>
                                    <div class="alienarleft">
                                        <a href="{{url('register')}}">
                                            <p>Crear cuenta</p>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="imagenrelleno">
                    <img src="{!! asset ('media/loginregister/imagen1.png') !!}" alt="imglogin" class="imgredondeada">
                </div>
            </div>
        </div>
    </main>
    @include ('template.footer')
</body>
</html>
