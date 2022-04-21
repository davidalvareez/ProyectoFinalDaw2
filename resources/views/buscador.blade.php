@include('template.header')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{!!asset('css/buscador/styles.css')!!}">
    <script src="{!! asset('js/buscador/buscadorAjax.js') !!}"></script>
    <script src="{!! asset('js/buscador/js.js') !!}"></script>
    <title>Buscador</title>
</head>
<body class="main-page">
    <header class="region-header">
        <div class="content-header">
            <div class="widget-search">
                <div class="container widget-search-container">
                    <div class="searchbar">

                        <form action="">
                            <div class="row input-box"><input type="text" onkeyup="multiplyFilter();return false;" name="BusquedaMultiple" id="multiplysearch"></div>
                            <div class="row s-cover" id="">
                                <button type="submit"><div class="s-circle"></div><span></span></button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div class="advancedSearch">
                <div class="container">
                    <button class="btn-abrirPop">
                        Busqueda avanzada
                    </button>
                </div>
            </div>
        </div>
    </header>
    <main>
    <!--RESULTADO DE BUSQUEDA TANTO AVANZADA COMO NORMAL-->
    <div id="contentFilter"></div>
    <!--APUNTES MÁS RECIENTES-->
    <div class="title">
        <h2>Los mas nuevos</h2>
    </div>
    <div class="region-news">
        <div class="content-news">
            <div class="resultados">
                <div class="owl-carousel owl-carousel-2">
                @foreach($recent as $recentnotes)
                    <div class="card resultado card-resultado">
                        <div class="container">
                            <div class="front-card">
                                <div class="container-front">
                                    <div class="foto img img-apuntes">
                                        <div class="container-foto container-img">
                                            <!-- foto de los apuntes. En el atributo alt hace falta poner el titulo de los apuntes -->
                                            <img class="img foto prev-apunt" src="media/ejemploApuntes.jpg" alt="Apuntes de la estructura osea">
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
                            <div class="reverse-card" style="background-image: url(media/ejemploApuntes.jpg)">

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
                                                            <p><span class="icon-stars"><i class="fa-duotone fa-meteor"></i></span> <span class="stars_text">4.5</span></p>
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
            </div>
        </div>
    </div>
                
        
    
    <!--APUNTES MÁS POPULARES-->

    <div class="title">
        <h2>Mas populares</h2>
    </div>
    <div class="region-relationated">
        <div class="content-relationated">
            <div class="resultados">
                <div class="owl-carousel owl-carousel-2">
                @foreach($popular as $popularnotes)
                    <div class="card resultado card-resultado">
                        <div class="container">
                            <div class="front-card">
                                <div class="container-front">
                                    <div class="foto img img-apuntes">
                                        <div class="container-foto container-img">
                                            <!-- foto de los apuntes. En el atributo alt hace falta poner el titulo de los apuntes -->
                                            <img class="img foto prev-apunt" src="media/ejemploApuntes.jpg" alt="Apuntes de la estructura osea">
                                        </div>
                                    </div>
                                    <div class="header-apuntes">
                                        <div class="name-content">
                                            <h3 class="name-content_text"><span class="">{{$popularnotes->nombre_contenido}}{{$popularnotes->extension_contenido}}</span></h3>
                                        </div>
                                        <div class="centro info-centro">
                                            <p><span class="icon-centro"><i class="fa-duotone fa-school"></i></span> <span class="centro">{{$popularnotes->nombre_centro}}</span></p>
                                        </div>
                                        <div class="id-content">
                                            <small class="name-content_text"><span class="">#{{$popularnotes->id_content}}</span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reverse-card" style="background-image: url(media/ejemploApuntes.jpg)">

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
                                                        <p><span>{{$popularnotes->nick_usu}}</span></p>
                                                    </div>
                                                    <div class="column-2">
                                                        <div class="stars">
                                                            <p><span class="icon-stars"><i class="fa-duotone fa-meteor"></i></span> <span class="stars_text">4.5</span></p>
                                                        </div>
                                                        <div class="down info-stats">
                                                            <p><span class="icon-stats"><i class="fa-duotone fa-download"></i></span> <span class="stats_text">{{$popularnotes->descargas}}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="date-info left-right">
                                                <div class="date">
                                                    <p><span class="icon-date"><i class="fa-duotone fa-calendar-days"></i></span> <span class="date-text">{{$popularnotes->fecha_publicacion_contenido}}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="content-info">
                                            <div class="name-content">
                                                <h4 class="name-content_text"><span class="">{{$popularnotes->nombre_contenido}}{{$popularnotes->extension_contenido}}</span></h4>
                                            </div>
                                            <div class="school-content">
                                                <p class="school-content_text"><span class="">{{$popularnotes->nombre_centro}}</span></p>
                                            </div>
                                            <div class="class-content">
                                                <p class="class-content_text"><span class="">{{$popularnotes->nombre_asignatura}}</span></p>
                                            </div>
                                            <div class="unit-content">
                                                <p class="unit-content_text"><span class="">{{$popularnotes->nombre_tema }}</span></p>
                                            </div>
                                        </div>
                                        <div class="buttons-actions">
                                            <div class="download-button">
                                                <button><a href=""><i class="fa-duotone fa-file-arrow-down"></i></a></button>
                                            </div>
                                            <div class="go-button">
                                                <button><a href="{{url('apuntes/'.$popularnotes->id_content)}}"><i class="fa-duotone fa-chevrons-right"></i>Ir a la pagina</a></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</main>
    <div class="overlay" id="overlay">
        <div class="popup" id="popup">
            <a href="#" id="btn-cerrar-popup" class="btn-cerrarPop"><i class="fas fa-times"></i></a>
            <h3>Búsqueda avanzada <span class="numeroEj"></span></h3>
            <div class="contenedor-popup">
                <form class="form-search" method="POST" id="formBusquedaAvanzada" onsubmit="return false;">
                <label>Centro</label>
                <div class="form-group select">
                        <select name="centros" onchange="busquedaAvanzada();selectCurso_Asignatura();">
                            <option value="">--</option>
                            @foreach($listaCentros as $centros)
                                <option value="{{$centros->nombre_centro}}">{{$centros->nombre_centro}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>Curso</label>
                    <div class="form-group select">
                        <select name="cursos" onchange="busquedaAvanzada();selectAsignatura();">
                            <option value="">--</option>
                            @foreach($listaCursos as $cursos)
                                <option value="{{$cursos->nombre_curso}}">{{$cursos->nombre_curso}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>Asignatura</label>
                    <div class="form-group select">
                        <select name="asignaturas" onchange="busquedaAvanzada()">
                            <option value="">--</option>
                            @foreach($listaAsignaturas as $asignaturas)
                                <option value="{{$asignaturas->nombre_asignatura}}">{{$asignaturas->nombre_asignatura}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>Tema</label>
                    <div class="form-group input-text">
                        <input type="text" name="nombre_tema" placeholder="Introduce nombre del tema..." onkeyup="busquedaAvanzada()">
                    </div>

                </form>
            </div>
        </div>
</body>
</html>