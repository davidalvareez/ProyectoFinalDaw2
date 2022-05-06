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
                        <button class="btn-glass" onclick="openModalConfig();getConfigUser();">Configuración</button>
                        <button class="btn-glass" onclick="window.location.href='{{url('logout')}}'">Cerrar sesion</button>
                    </div>
                </div>
                <div class="region-menu">
                    <div class="content-menu">
                        <h2>INFORMACIÓN PERSONAL</h2>
                        <div class="menu-info-persona">
                            <div id="menu-info-persona">
                                <div class="div-info">{{$perfilUser[0]->nombre_usu}} {{$perfilUser[0]->apellido_usu}}</div>
                                <div class="div-info">{{$perfilUser[0]->fecha_nac_usu}}</div>
                                <div class="div-info">{{$perfilUser[0]->correo_usu}}</div>
                                <div class="div-info">{{$perfilUser[0]->nombre_centro}}</div>
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
                            <div class="content-foto" >
                                <img id ="imgAvatar" class="foto-perfil"alt="Foto Avatar Usuario" src="{{asset('storage').'/'.$perfilUser[0]->img_avatar}}">
                                    <a class="add-button" onclick="modalbox();return false;"><span class="fa-solid fa-pencil"></span></a>
                                <h1 class="user-nickname" id="NickName">{{$perfilUser[0]->nick_usu}}</h1>
                            </div>
                        </div>
                        <div class="region-datos">
                            <div class="valoracion">
                                <p>{{$perfilUser[0]->valoracion}}*</p>
                            </div>
                            <div class="descargas">
                                <p>{{$perfilUser[0]->descargas}} descargas</p>
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
                    </div>
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
        <!--- Aqui Empieza El Modal Actualizar--->
        <div class="modal hidden" id="modalActualizar">
            <div class="modal-content" id="modalBox">

            </div>
        </div>
        <!--- Aqui Termina El Modal Actualizar--->
        <!--- Aqui Empieza El Modal Configuración--->
        <div class="modal2" id="modalConfiguracion">
            <div class="modal-content" id="modalBoxConfiguracion">

            </div>
        </div>
        <!--- Aqui Empieza El Modal Configuración--->
        <!--- Aqui Empieza El Modal Actualizar Avatar--->
        <div id="myModal" class="modal2">
            <div class="modal-content">
                <span class="close" onclick="closeModal();">&times;</span>
                <br><br>
                <form id="editarAvatar" onsubmit="actualizarAvatarUsu();return false;" enctype="multipart/form-data">
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
                    <input type="file" name="img_avatar_usu2" id="img_avatar_usu">
                    <br><br>
                    <input type="hidden" name="img_avatar_sistema" id="img_avatar_sistema">
                    <button  type="submit" class="aceptarbtn" value="Aceptar">Aceptar</button>
                </form>
            </div>
        </div>
        <!--- Aqui Termina El Modal Actualizar Avatar--->
    </main>
</body>
</html>
@include ('template.footer')