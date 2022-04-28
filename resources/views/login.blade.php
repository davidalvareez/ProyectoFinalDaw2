@include('template.header')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{!! asset ('css/registro/loginregistro.css')!!}">
    <script src="{!! asset ('js/fontawesomePRO.js')!!}"></script>
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">
    <title>Login page</title>
</head>

<body class="login-page">
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
                                <!-- <div class="alienarright">
                                    <a href="">
                                        <p>Contraseña olvidada?</p>
                                    </a>
                                </div> -->
                                <input class="login-btn-absglass" type="submit" value="ENTRAR"></input>
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
            </div>
            <div class="content-region">
                <div class="imagenrelleno">
                    <img src="{!! asset ('media/fotos_loginregister/imagen1.png') !!}" alt="imglogin" class="imgredondeada">
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
<div style="padding-bottom: 91px"></div>
@include ('template.footer')