@include('template.header')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{!! asset ('css/validarcorreo/validarcorreo.css')!!}">
    <script src="{!! asset ('js/fontawesomePRO.js')!!}"></script>
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">
    <title>Validar correo</title>
</head>

<body class="validarcorreo-page">
    <header>
    </header>
    <main>
        <div class="region region1">
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="validarcorreo-content-glassland">
                            <img src="{!! asset ('media/3Dicons-dinamicos/icons/png/mail\mail-dynamic-gradient.png') !!}" width="80px" height="80px">
                            <h2>¡Verifica tu correo!</h2>
                            <br>
                            <form action="{{url('validarcorreo')}}" method="post">
                                @csrf
                                <div>
                                    <h4 class="pizq">Email</h4>
                                    <input class="inputbtn" type="text" name="correo" id="correo" placeholder="&#xf007">
                                    @error('correo')
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
                                <!-- <div class="alienarright">
                                    <a href="">
                                        <p>Contraseña olvidada?</p>
                                    </a>
                                </div> -->
                                <input class="validarcorreo-btn-absglass" type="submit" value="VALIDAR"></input>
                                <div class="">
                                    <div class="alienarleft">
                                        <p>Volver a la página de inicio?</p>
                                    </div>
                                    <div class="alienarleft">
                                        <a href="{{url('/')}}">
                                            <p>Click aquí</p>
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
                    <img src="{!! asset ('media/validarcorreo/img2validar.png') !!}" alt="imglogin" class="imgvalidacion">
                </div>
            </div>
        </div>
    </main>
</body>
</html>
<div style="padding-bottom: 91px"></div>
@include ('template.footer')