@include('template.header')
    <link rel="stylesheet" href="{!! asset ('css/cambiarpass/cambiarpass.css')!!}">
    <script src="{!! asset ('js/fontawesomePRO.js')!!}"></script>
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">
    <title>Restablecer contraseña</title>
</head>

<body class="cambiarpass-page">
    @if(isset($user_notfound))
        @if ($user_notfound == true)
            {{$user_notfound = false;}}
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Usuario no encontrado',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif
    @endif
    @if(isset($samepassword))
        @if ($samepassword == true)
            {{$samepassword = false;}}
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'La contraseña no puede ser igual a la antigua',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif
    @endif
    @if(isset($incorrect_code))
        @if ($incorrect_code == true)
            {{$incorrect_code = false;}}
            <script>
                alertify.error("Codigo incorrecto");
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
                        <div class="cambiarpass-content-glassland">
                            <img src="{!! asset ('media/3Dicons-dinamicos/icons/png/key\key-dynamic-gradient.png') !!}" width="80px" height="80px">
                            <h2>¡Restablece tu contraseña!</h2>
                            <br>
                            <form action="{{url('restablecerContraUser')}}" method="POST">
                                @csrf
                                <div>
                                    <h4 class="pizq">Correo</h4>
                                    <input class="inputbtn" type="email" name="correo_usu" id="correo_usu" placeholder="&#xf007">
                                    @error('correo_usu')
                                    <p class="errortext">{{$message}}</p>
                                    @enderror
                                </div>
                                <br>
                                <div>
                                    <h4 class="pizq">Código de verificación</h4>
                                    <input class="inputbtn" type="password" name="codigo_usu" id="codigo_usu" placeholder="&#xf084">
                                    @error('codigo_usu')
                                    <p class="errortext">{{$message}}</p>
                                    @enderror
                                </div>
                                <br>
                                <div>
                                    <h4 class="pizq">Contraseña nueva</h4>
                                    <input class="inputbtn" type="password" name="contra_usu" id="contra_usu" placeholder="&#xf023">
                                    @error('contra_usu')
                                    <p class="errortext">{{$message}}</p>
                                    @enderror
                                </div>
                                <br>
                                <div>
                                    <h4 class="pizq">Confirmar contraseña nueva</h4>
                                    <input class="inputbtn" type="password" name="contra_usu_verify" id="contra_usu_verify" placeholder="&#xf023">
                                    @error('contra_usu_verify')
                                    <p class="errortext">{{$message}}</p>
                                    @enderror
                                </div>
                                <!-- <div class="alienarright">
                                    <a href="">
                                        <p>Contraseña olvidada?</p>
                                    </a>
                                </div> -->
                                <input class="cambiarpass-btn-absglass" type="submit" value="Restablecer contraseña">
                                {{-- <div class="">
                                    <div class="alienarleft">
                                        <p>Cancelar proceso</p>
                                    </div>
                                    <div class="alienarleft">
                                        <a href="{{url('/login')}}">
                                            <p>Click aquí</p>
                                        </a>
                                    </div>
                                </div> --}}
                                <br><br><br>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="imagenrelleno">
                    <img src="{!! asset ('media/cambiarpass/cambiarpass.png') !!}" alt="imgpass" class="imgpass">
                </div>
            </div>
        </div>
    </main>
    @include ('template.footer')
</body>
</html>
