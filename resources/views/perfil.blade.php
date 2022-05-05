@include('template.header')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <!----------------------------------- AlertifyJS ------------------------------------------------------->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
    <script src="{!! asset('js/perfil/miPerfilAjax.js') !!}"></script>
    <script src="{!! asset('js/buscador/js.js') !!}"></script>
    <link rel="stylesheet" href="{!!asset('css/miPerfil/styles.css')!!}">
    <title>Mi Perfil</title>
</head>
<body class="mi-perfil">
    <main>
        <div class="region-perfil">
            <div class="content-region">
                <div class="region-header">
                    <div class="content-header">
                        <button class="btn-glass" onclick="window.location.href='{{url('buscador')}}'">Inicio</button>
                        <button class="btn-glass" onclick="window.location.href='{{url('misApuntes')}}'">Mis apuntes</button>
                        <button class="btn-glass">Configacion</button>
                        <button class="btn-glass" onclick="window.location.href='{{url('logout')}}'">Cerrar sesion</button>
                    </div>
                </div>
                <div class="region-menu">
                    <div class="content-menu">
                        <h2>INFORMACIÓN PERSONAL</h2>
                        <div class="menu-info-persona">
                            <div id="menu-info-persona">
                                <div class="div-info"><h4>{{$perfilUser[0]->nombre_usu}} {{$perfilUser[0]->apellido_usu}}</h3></div>
                                <div class="div-info"><h4>{{$perfilUser[0]->fecha_nac_usu}}</h4></div>
                                <div class="div-info"><h4>{{$perfilUser[0]->correo_usu}}</h4></div>
                                <div class="div-info"><h4>{{$perfilUser[0]->nombre_centro}}</h4></div>
                            </div>
                            @if (Session::get('user')->nick_usu == $perfilUser[0]->nick_usu)
                                <button class="btn-glass" onclick="modalDatosUser();">Editar información</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="region-avatar">
                    <div class="content-avatar">
                        <div class="region-foto">
                            <div class="content-foto">
                                <img class="foto-perfil"alt="Foto Avatar Usuario" src="{{asset('storage').'/'.$perfilUser[0]->img_avatar}}">
                                <a class="add-button" href="{{url('')}}"><span class="fa-solid fa-pencil"></span></a>
                                <h1 class="user-nickname"><h3>{{$perfilUser[0]->nick_usu}}</h3>
                            </div>
                        </div>
                        <div class="region-datos">
                            <div class="valoracion">
                                <h4>{{$perfilUser[0]->valoracion}}*</h4>
                            </div>
                            <div class="descargas">
                                <h4>{{$perfilUser[0]->descargas}} descargas</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="region-subir-apuntes">
                    <div class="content-subir-apuntes">
                        <h2 class="titular">SUBIR APUNTES</h2>
                        <button class="btn-glass" onclick="window.location.href='{{url('misApuntes')}}'">Comparte tus apuntes</button>
                    </div>
                </div>
                <div class="region-baja">
                    <div class="content-baja">
                        <h2 class="titular">DARSE DE BAJA</h2>
                        <div class="darse-baja">
                            <button class="btn-glass" onclick="window.location.href='{{url('darseDeBaja')}}'">Elimina tu cuenta</button>
                        </div>
                    </div>
                </div>
                <div class="region-mis-apuntes">
                    <div class="content-mis-apuntes">
                        <h2>MIS APUNTES</h2>
                                            <!--- Aqui Empieza Las Cartas--->
                    <div class="owl-carousel owl-carousel-4">
                        @foreach($apuntesUser as $recentnotes)
                        <div class="card resultado card-resultado">
                            <div class="container">
                                <div class="front-card">
                                    <div class="container-front">
                                        <div class="foto img img-apuntes">
                                            <div class="container-foto container-img">
                                                <!-- foto de los apuntes. En el atributo alt hace falta poner el titulo de los apuntes -->
                                                <img class="img foto prev-apunt" src="../media/ejemploApuntes.jpg" alt="Apuntes de la estructura osea">
                                            </div>
                                        </div>
                                        <div class="header-apuntes">
                                            <div class="name-content">
                                                <h3 class="name-content_text"><span class="">{{$recentnotes->nombre_contenido}}{{$recentnotes->extension_contenido}}</span></h3>
                                            </div>
                                            <div class="centro info-centro">
                                                <p><span class="icon-centro"><i class="fa-duotone fa-school"></i></span> <span class="centro">{{$recentnotes->nombre_centro}}</span></p>
                                            </div>
                                            <div class="id-content">
                                                <small class="name-content_text"><span class="">#{{$recentnotes->id_content}}</span></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="reverse-card" style="background-image: url(../media/ejemploApuntes.jpg)">
                                    <div class="container-reverse">
                                        <div class="top">
                                            <div class="user-info left-top">
                                                <div class="container-info">
                                                    <div class="avatar-user user-img">
                                                        <div class="filter">
                                                            <img src="{{asset('storage').'/'.$recentnotes->img_avatar}}" alt="" class="avatar img">
                                                        </div>
                                                    </div>
                                                    <div class="container-text">
                                                        <div class="username">
                                                            <p><span>{{$recentnotes->nick_usu}}</span></p>
                                                        </div>
                                                        <div class="column-2">
                                                            <div class="stars">
                                                                <p><span class="icon-stars"><i class="fa-duotone fa-meteor"></i></span> <span class="stars_text">{{$recentnotes->valoracion}}</span></p>
                                                            </div>
                                                            <div class="down info-stats">
                                                                <p><span class="icon-stats"><i class="fa-duotone fa-download"></i></span> <span class="stats_text">{{$recentnotes->descargas}}</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="date-info left-right">
                                                    <div class="date">
                                                        <p><span class="icon-date"><i class="fa-duotone fa-calendar-days"></i></span> <span class="date-text">{{$recentnotes->fecha_publicacion_contenido}}</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            <div class="content-info">
                                                <div class="name-content">
                                                    <h4 class="name-content_text"><span class="">{{$recentnotes->nombre_contenido}}{{$recentnotes->extension_contenido}}</span></h4>
                                                </div>
                                                <div class="school-content">
                                                    <p class="school-content_text"><span class="">{{$recentnotes->nombre_centro}}</span></p>
                                                </div>
                                                <div class="class-content">
                                                    <p class="class-content_text"><span class="">{{$recentnotes->nombre_asignatura}}</span></p>
                                                </div>
                                                <div class="unit-content">
                                                    <p class="unit-content_text"><span class="">{{$recentnotes->nombre_tema }}</span></p>
                                                </div>
                                            </div>
                                            <div class="buttons-actions">
                                                <div class="download-button">
                                                    <button><a href=""><i class="fa-duotone fa-file-arrow-down"></i></a></button>
                                                </div>
                                                <div class="go-button">
                                                    <button><a href="{{url('apuntes/'.$recentnotes->id_content)}}"><i class="fa-duotone fa-chevrons-right"></i>Ir a la pagina</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!--- Aqui Terminan Las Cartas--->
                    </div>

                </div>
            </div>
        </div>
        <!--- Aqui Empieza El Modal Actualizar--->
        <div class="modal hidden" id="modalActualizar">
            <div class="modalBox" id="modalBox">
                
            </div>
        </div>
        <!--- Aqui Termina El Modal Actualizar--->
    </main>
</body>
</html>
@include ('template.footer')