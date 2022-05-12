@include('template.header')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{!! asset ('css/registro/loginregistro.css')!!}">
    <script src="{!! asset ('js/login/login.js')!!}"></script>
    <script src="{!! asset ('js/fontawesomePRO.js')!!}"></script>
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">
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
                                </div> 
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
                                    <div>
                                        <button onclick="{{url('login-google')}}">Login Google</button>
                                        <button onclick="{{url('login-facebook')}}">Login Facebook</button>
                                        <button onclick="{{url('login-twitter')}}">Login Twitter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-region">
                <div class="imagenrelleno">
                    <img src="{!! asset ('media/loginregister/imagen1.png') !!}" alt="imglogin" class="imgredondeada">
                </div>
            </div>
        </div>
    </main>
</body>
</html>
<div style="padding-bottom: 91px"></div>
@include ('template.footer')