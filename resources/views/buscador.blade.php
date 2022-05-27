@include('template.header')
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{!!asset('css/buscador/styles.css')!!}">
    <script src="{!! asset('js/buscador/buscadorAjax.js') !!}"></script>
    <script src="{!! asset('js/buscador/js.js') !!}"></script>
    <title>Buscador</title>
</head>
<body class="main-page">
    @include('template.menu')  
    <header></header>
    <div class="region-header">
        <div class="content-header">
            <div class="widget-search">
                <div class="container widget-search-container">
                    <div class="searchbar">

                        <form action="">
                            <div class="row input-box"><input type="text" name="BusquedaMultiple" id="multiplysearch"></div>
                            <div class="row s-cover" id="">
                                <button type="submit" onclick="multiplyFilter();return false;"><div class="s-circle"></div><span></span></button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div class="advancedSearch">
                <div class="container">
                    <button class="btn-abrirPop btn-glass">
                        Busqueda avanzada
                    </button>
                    {{-- <form action='{{url('logout')}}' method='get'>
                        <button class="btn btn-secondary">Logout</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
    <main>

    <!--RESULTADO DE BUSQUEDA TANTO AVANZADA COMO NORMAL-->
    <div id="contentFilter">

    </div>

    <!--APUNTES MÁS RECIENTES-->
    <div class="title">
        <h2>Los más nuevos</h2>
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
                                            @if ($recentnotes->extension_contenido == ".pdf")
                                                @if ($recentnotes->id_tema != null)
                                                    <img class="img foto prev-apunt" src="{{asset('storage').'/uploads/apuntes/'.$recentnotes->nombre_centro.'/'.$recentnotes->nombre_curso.'/'.$recentnotes->nombre_asignatura.'/'.$recentnotes->nombre_tema.'/'.$recentnotes->nombre_contenido.'.png'}}" alt="Apuntes">
                                                @else
                                                <img class="img foto prev-apunt" src="{{asset('storage').'/uploads/apuntes_reciclados/'.$recentnotes->nombre_tema.'/'.$recentnotes->nombre_contenido.'.png'}}" alt="Apuntes">
                                                @endif
                                            @else
                                                @if ($recentnotes->id_tema != null)
                                                    <img class="img foto prev-apunt" src="{{asset('storage').'/uploads/apuntes/'.$recentnotes->nombre_centro.'/'.$recentnotes->nombre_curso.'/'.$recentnotes->nombre_asignatura.'/'.$recentnotes->nombre_tema.'/'.$recentnotes->nombre_contenido.$recentnotes->extension_contenido}}" alt="Apuntes">
                                                @else
                                                    <img class="img foto prev-apunt" src="{{asset('storage').'/uploads/apuntes_reciclados/'.$recentnotes->nombre_contenido.$recentnotes->extension_contenido}}" alt="Apuntes">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="header-apuntes">
                                        <div class="name-content">
                                            <h3 class="name-content_text"><span class="">{{$recentnotes->nombre_contenido}}</span></h3>
                                        </div>
                                        @if ($recentnotes->id_tema != null)
                                        <div class="centro info-centro">
                                            <p><span class="icon-centro"><i class="fa-duotone fa-school"></i></span> <span class="centro">{{$recentnotes->nombre_centro}}</span></p>
                                        </div>
                                        @endif
                                        <div class="id-content">
                                            <small class="name-content_text"><span class="">#{{$recentnotes->id_content}}</span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($recentnotes -> id_tema != null){
                                $nombre_centro = str_replace(" ","%20",$recentnotes->nombre_centro);
                                $nombre_curso = str_replace(" ","%20",$recentnotes->nombre_curso);
                                $nombre_asignatura = str_replace(" ","%20",$recentnotes->nombre_asignatura);
                                $nombre_tema = str_replace(" ","%20",$recentnotes->nombre_tema);
                            }
                                $nombre_contenido = str_replace(" ","%20",$recentnotes->nombre_contenido);
                                $split_img = explode(":",$recentnotes->img_avatar);
                            ?>
                            @if ($recentnotes->extension_contenido == ".pdf")
                                @if ($recentnotes->id_tema != null)
                                    <div class="reverse-card" style="background-image: url({{asset('storage').'/uploads/apuntes/'.$nombre_centro.'/'.$nombre_curso.'/'.$nombre_asignatura.'/'.$nombre_tema.'/'.$nombre_contenido.'.png'}})">
                                @else
                                    <div class="reverse-card" style="background-image: url({{asset('storage').'/uploads/apuntes_reciclados/'.$nombre_contenido.'.png'}})">
                                @endif
                            @else
                                @if ($recentnotes->id_tema != null)
                                    <div class="reverse-card" style="background-image: url({{asset('storage').'/uploads/apuntes/'.$nombre_centro.'/'.$nombre_curso.'/'.$nombre_asignatura.'/'.$nombre_tema.'/'.$nombre_contenido.$recentnotes->extension_contenido}})">
                                @else
                                <div class="reverse-card" style="background-image: url({{asset('storage').'/uploads/apuntes_reciclados/'.$nombre_contenido.$recentnotes->extension_contenido}})">
                                @endif
                            @endif
                                <div class="container-reverse">
                                    <div class="top">
                                        <div class="user-info left-top">
                                            <div class="container-info">
                                                <div class="avatar-user user-img">
                                                    <div class="filter">
                                                        @if ($split_img[0] == "https" || $split_img[0] == "http")
                                                        <img src="{{$recentnotes->img_avatar}}" onclick="window.location.href='{{url('perfil/'.$recentnotes->nick_usu)}}'" alt="" class="avatar img">
                                                        @else
                                                        <img src="{{asset('storage').'/'.$recentnotes->img_avatar}}" onclick="window.location.href='{{url('perfil/'.$recentnotes->nick_usu)}}'" alt="" class="avatar img">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="container-text">
                                                    <div class="username">
                                                        <p><span onclick="window.location.href='{{url('perfil/'.$recentnotes->nick_usu)}}'">{{$recentnotes->nick_usu}}</span></p>
                                                    </div>
                                                    <div class="column-2">
                                                        @if ($recentnotes->valoracion != null)
                                                        <div class="stars">
                                                            <p><span class="icon-stars"><i class="fa-duotone fa-meteor"></i></span> <span class="stars_text">{{$recentnotes->valoracion}}</span></p>
                                                        </div>
                                                        @endif
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
                                                <h4 class="name-content_text"><span class="">{{$recentnotes->nombre_contenido}}</span></h4>
                                            </div>
                                            @if ($recentnotes->id_tema != null)
                                            <div class="school-content">
                                                <p class="school-content_text"><span class="">{{$recentnotes->nombre_centro}}</span></p>
                                            </div>
                                            <div class="class-content">
                                                <p class="class-content_text"><span class="">{{$recentnotes->nombre_asignatura}}</span></p>
                                            </div>
                                            <div class="unit-content">
                                                <p class="unit-content_text"><span class="">{{$recentnotes->nombre_tema }}</span></p>
                                            </div>
                                            @endif
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
        <h2>Los más populares</h2>
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
                                            @if ($popularnotes->extension_contenido == ".pdf")
                                                @if ($popularnotes->id_tema != null)
                                                    <img class="img foto prev-apunt" src="{{asset('storage').'/uploads/apuntes/'.$popularnotes->nombre_centro.'/'.$popularnotes->nombre_curso.'/'.$popularnotes->nombre_asignatura.'/'.$popularnotes->nombre_tema.'/'.$popularnotes->nombre_contenido.'.png'}}" alt="Apuntes">
                                                @else
                                                <img class="img foto prev-apunt" src="{{asset('storage').'/uploads/apuntes_reciclados/'.$popularnotes->nombre_tema.'/'.$popularnotes->nombre_contenido.'.png'}}" alt="Apuntes">
                                                @endif
                                            @else
                                                @if ($popularnotes->id_tema != null)
                                                    <img class="img foto prev-apunt" src="{{asset('storage').'/uploads/apuntes/'.$popularnotes->nombre_centro.'/'.$popularnotes->nombre_curso.'/'.$popularnotes->nombre_asignatura.'/'.$popularnotes->nombre_tema.'/'.$popularnotes->nombre_contenido.$popularnotes->extension_contenido}}" alt="Apuntes">
                                                @else
                                                    <img class="img foto prev-apunt" src="{{asset('storage').'/uploads/apuntes_reciclados/'.$popularnotes->nombre_contenido.$popularnotes->extension_contenido}}" alt="Apuntes">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="header-apuntes">
                                        <div class="name-content">
                                            <h3 class="name-content_text"><span class="">{{$popularnotes->nombre_contenido}}</span></h3>
                                        </div>
                                        @if ($popularnotes->id_tema != null)
                                        <div class="centro info-centro">
                                            <p><span class="icon-centro"><i class="fa-duotone fa-school"></i></span> <span class="centro">{{$popularnotes->nombre_centro}}</span></p>
                                        </div>
                                        @endif
                                        <div class="id-content">
                                            <small class="name-content_text"><span class="">#{{$popularnotes->id_content}}</span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($popularnotes->id_tema != null) {
                                $nombre_centro = str_replace(" ","%20",$popularnotes->nombre_centro);
                                $nombre_curso = str_replace(" ","%20",$popularnotes->nombre_curso);
                                $nombre_asignatura = str_replace(" ","%20",$popularnotes->nombre_asignatura);
                                $nombre_tema = str_replace(" ","%20",$popularnotes->nombre_tema);
                            }
                                $nombre_contenido = str_replace(" ","%20",$popularnotes->nombre_contenido);
                                $split_img = explode(":",$recentnotes->img_avatar);
                            ?>
                            @if ($popularnotes->extension_contenido == ".pdf")
                                @if ($popularnotes->id_tema != null)
                                    <div class="reverse-card" style="background-image: url({{asset('storage').'/uploads/apuntes/'.$nombre_centro.'/'.$nombre_curso.'/'.$nombre_asignatura.'/'.$nombre_tema.'/'.$nombre_contenido.'.png'}})">
                                @else
                                    <div class="reverse-card" style="background-image: url({{asset('storage').'/uploads/apuntes_reciclados/'.$nombre_contenido.'.png'}})">
                                @endif
                            @else
                                @if ($popularnotes->id_tema != null)
                                    <div class="reverse-card" style="background-image: url({{asset('storage').'/uploads/apuntes/'.$nombre_centro.'/'.$nombre_curso.'/'.$nombre_asignatura.'/'.$nombre_tema.'/'.$nombre_contenido.$popularnotes->extension_contenido}})">
                                @else
                                <div class="reverse-card" style="background-image: url({{asset('storage').'/uploads/apuntes_reciclados/'.$nombre_contenido.$popularnotes->extension_contenido}})">
                                @endif
                            @endif
                                <div class="container-reverse">

                                    <div class="top">
                                        <div class="user-info left-top">
                                            <div class="container-info">
                                                <div class="avatar-user user-img">
                                                    <div class="filter">
                                                        @if ($split_img[0] == "https" || $split_img[0] == "http")
                                                        <img src="{{$popularnotes->img_avatar}}" onclick="window.location.href='{{url('perfil/'.$popularnotes->nick_usu)}}'" alt="" class="avatar img">
                                                        @else
                                                        <img src="{{asset('storage').'/'.$popularnotes->img_avatar}}" onclick="window.location.href='{{url('perfil/'.$popularnotes->nick_usu)}}'" alt="" class="avatar img">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="container-text">
                                                    <div class="username">
                                                        <p><span onclick="window.location.href='{{url('perfil/'.$popularnotes->nick_usu)}}'">{{$popularnotes->nick_usu}}</span></p>
                                                    </div>
                                                    <div class="column-2">
                                                        @if ($popularnotes->valoracion != null)
                                                        <div class="stars">
                                                            <p><span class="icon-stars"><i class="fa-duotone fa-meteor"></i></span> <span class="stars_text">{{$popularnotes->valoracion}}</span></p>
                                                        </div>
                                                        @endif
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
                                                <h4 class="name-content_text"><span class="">{{$popularnotes->nombre_contenido}}</span></h4>
                                            </div>
                                            @if ($popularnotes->id_tema != null)
                                            <div class="school-content">
                                                <p class="school-content_text"><span class="">{{$popularnotes->nombre_centro}}</span></p>
                                            </div>
                                            <div class="class-content">
                                                <p class="class-content_text"><span class="">{{$popularnotes->nombre_asignatura}}</span></p>
                                            </div>
                                            <div class="unit-content">
                                                <p class="unit-content_text"><span class="">{{$popularnotes->nombre_tema }}</span></p>
                                            </div>
                                            @endif
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
@include('template.footer')  
    
<div class="background">
    <div class="container-bg">
        <div class="coso coso0">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:rgba(241, 242, 243, 0);display:block;z-index:1;position:relative" width="2013" height="141" preserveAspectRatio="xMidYMid" viewBox="0 0 2013 141">
            <g transform="translate(1006.5,70.5) scale(1,1) translate(-1006.5,-70.5)"><linearGradient id="lg-0.6281374458194822" x1="0" x2="1" y1="0" y2="0">
              <stop stop-color="var(--svgColor1)" offset="0"></stop>
              <stop stop-color="var(--svgColor1a)" offset="1"></stop>
            </linearGradient><path d="" fill="url(#lg-0.6281374458194822)" opacity="0.4">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="0s" values="M0 0M 0 119.33409972671022Q 91.5 127.53122002708163 183 126.36437726040174T 366 127.27566438012389T 549 126.1765465474211T 732 110.98387409111817T 915 114.20795842422558T 1098 118.74879210515178T 1281 113.10713401400716T 1464 114.30320669276311T 1647 105.48273748468375T 1830 111.60087388248036T 2013 107.15512647893098L 2013 31.274266772716125Q 1921.5 33.60290184516776 1830 30.81030191639008T 1647 29.368866932360465T 1464 35.91287198456842T 1281 24.55405115670368T 1098 29.456940047747693T 915 23.062182277866224T 732 16.867406043381415T 549 14.11876599427778T 366 23.23011305761102T 183 10.627825947941052T 0 20.758706229397404Z;M0 0M 0 127.12174187492819Q 91.5 125.24894961230594 183 123.15662981816087T 366 128.7133193111463T 549 120.74014999877167T 732 123.21576231767042T 915 112.52916048541233T 1098 106.85836253371886T 1281 112.58054730700192T 1464 112.48309345232558T 1647 104.20030579271831T 1830 103.22646585376174T 2013 105.81260338644287L 2013 43.686286139941856Q 1921.5 37.75898828659668 1830 35.50544713283667T 1647 27.843372219234258T 1464 38.93271370216631T 1281 34.35979405435021T 1098 27.494013051116298T 915 34.05804578937553T 732 20.97429587872849T 549 19.383008107283956T 366 18.069065197205624T 183 11.727716451550375T 0 9.438347595987487Z;M0 0M 0 129.57465196181633Q 91.5 124.98028358532417 183 124.1803427465851T 366 122.90740684589301T 549 128.1185780042298T 732 114.93540168995708T 915 114.0070506655304T 1098 105.33554592847992T 1281 119.07404381962559T 1464 111.9523825794298T 1647 100.99479503559098T 1830 104.8518608621174T 2013 103.84720172250783L 2013 38.0117764311423Q 1921.5 36.89992747409161 1830 32.81608211219707T 1647 41.1120813331128T 1464 25.93861423055114T 1281 23.6489664070126T 1098 20.33857256747254T 915 20.117372985904094T 732 21.925670996971483T 549 25.423473474344448T 366 20.29951089176641T 183 11.141217626086249T 0 8.971448779042085Z;M0 0M 0 119.33409972671022Q 91.5 127.53122002708163 183 126.36437726040174T 366 127.27566438012389T 549 126.1765465474211T 732 110.98387409111817T 915 114.20795842422558T 1098 118.74879210515178T 1281 113.10713401400716T 1464 114.30320669276311T 1647 105.48273748468375T 1830 111.60087388248036T 2013 107.15512647893098L 2013 31.274266772716125Q 1921.5 33.60290184516776 1830 30.81030191639008T 1647 29.368866932360465T 1464 35.91287198456842T 1281 24.55405115670368T 1098 29.456940047747693T 915 23.062182277866224T 732 16.867406043381415T 549 14.11876599427778T 366 23.23011305761102T 183 10.627825947941052T 0 20.758706229397404Z"></animate>
            </path><path d="" fill="url(#lg-0.6281374458194822)" opacity="0.4">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-6.25s" values="M0 0M 0 132.01137790833388Q 91.5 134.14012772410183 183 130.93586058760005T 366 126.40334488158626T 549 128.39432510641723T 732 124.46749053315133T 915 120.52423973547093T 1098 120.02351932879728T 1281 105.4358827903188T 1464 103.3425525651607T 1647 98.77770738485205T 1830 103.64088650042338T 2013 106.51269157955227L 2013 45.55013674695089Q 1921.5 31.096846392881957 1830 30.919330793691742T 1647 39.023028144282705T 1464 40.67867158050465T 1281 28.781984140559494T 1098 35.7353010549661T 915 32.41723335594091T 732 26.755262373007312T 549 20.03345134624559T 366 19.07675913897772T 183 19.2838087468464T 0 21.938016569625255Z;M0 0M 0 125.58099118729311Q 91.5 126.0964250327298 183 117.92102412981114T 366 113.94576944584679T 549 124.91133206474244T 732 125.96584993407004T 915 122.42192858018487T 1098 115.44418025436627T 1281 104.71649031328548T 1464 104.85068844846T 1647 112.9851333925531T 1830 112.24631947941T 2013 105.88582812344401L 2013 42.150698335292816Q 1921.5 38.65555730710899 1830 29.30038858584654T 1647 28.598023580312212T 1464 33.87213748953977T 1281 28.90248786797742T 1098 25.796625888775665T 915 19.531951507300757T 732 31.78778896067012T 549 17.587869908041412T 366 20.92828339194103T 183 18.857046440345183T 0 13.97870571271504Z;M0 0M 0 129.06639317149188Q 91.5 130.3978120308932 183 129.64424394862533T 366 126.73516485264454T 549 114.28033464279916T 732 122.59599396964433T 915 122.91656534462858T 1098 105.5093757090913T 1281 106.51044906386093T 1464 112.31151499300718T 1647 109.6608831747496T 1830 104.01777969712984T 2013 103.35255886514268L 2013 42.689142840049854Q 1921.5 43.04270353486981 1830 33.07651408969764T 1647 34.484506254766245T 1464 29.700381911899818T 1281 36.36997629404814T 1098 24.49889243011603T 915 31.37785928198799T 732 21.642888559301667T 549 16.028509372149742T 366 25.439257327251426T 183 16.362050477401933T 0 10.415415583891729Z;M0 0M 0 132.01137790833388Q 91.5 134.14012772410183 183 130.93586058760005T 366 126.40334488158626T 549 128.39432510641723T 732 124.46749053315133T 915 120.52423973547093T 1098 120.02351932879728T 1281 105.4358827903188T 1464 103.3425525651607T 1647 98.77770738485205T 1830 103.64088650042338T 2013 106.51269157955227L 2013 45.55013674695089Q 1921.5 31.096846392881957 1830 30.919330793691742T 1647 39.023028144282705T 1464 40.67867158050465T 1281 28.781984140559494T 1098 35.7353010549661T 915 32.41723335594091T 732 26.755262373007312T 549 20.03345134624559T 366 19.07675913897772T 183 19.2838087468464T 0 21.938016569625255Z"></animate>
            </path><path d="" fill="url(#lg-0.6281374458194822)" opacity="0.4">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-12.5s" values="M0 0M 0 122.79616939565537Q 91.5 127.95261694373926 183 127.22929796380954T 366 125.9201973346234T 549 125.20960652021027T 732 114.71172432719803T 915 114.5674833896949T 1098 120.43195682730708T 1281 114.3241772602027T 1464 101.03290751608883T 1647 106.41031533935278T 1830 111.84112427088927T 2013 100.614501318115L 2013 42.38027803214411Q 1921.5 46.04909383719906 1830 37.99181999110033T 1647 31.404508339784268T 1464 39.38860073517188T 1281 33.41992677620586T 1098 27.79150491429902T 915 24.256628599037807T 732 14.924118235928844T 549 25.515918893729825T 366 11.718782656335698T 183 17.225412001996336T 0 17.404003067650393Z;M0 0M 0 123.31464999210277Q 91.5 137.37645711541498 183 129.26216900430657T 366 113.83969680417263T 549 128.40433446201416T 732 124.46488798317057T 915 108.4837668493372T 1098 113.14087547641255T 1281 112.9704670969509T 1464 102.63418318409167T 1647 106.1278671527702T 1830 111.9576808734514T 2013 102.5109521315841L 2013 35.934292158759554Q 1921.5 42.568793494881994 1830 36.11575968378593T 1647 36.430023059968704T 1464 36.29374435731573T 1281 27.527982614818946T 1098 19.56347774016443T 915 32.98660829375021T 732 20.3406417153129T 549 21.598401677598943T 366 24.739381980731658T 183 22.905604627418068T 0 12.111013293542712Z;M0 0M 0 132.72515197209822Q 91.5 133.08859009485334 183 124.47951581373246T 366 127.4388315862694T 549 123.08280316350893T 732 124.07450275942108T 915 109.99062106491188T 1098 110.03385596659892T 1281 110.64028947797854T 1464 114.50650123224533T 1647 101.75708093370785T 1830 101.79611696938153T 2013 99.29886678827374L 2013 45.513422600015645Q 1921.5 41.94114011426766 1830 40.62673785637657T 1647 37.70084728230975T 1464 32.94347655980438T 1281 22.839826788789296T 1098 29.002690166564996T 915 29.949143498771694T 732 29.311536490076115T 549 23.344432665857042T 366 18.955136652807738T 183 21.72202374748012T 0 19.671327093954147Z;M0 0M 0 122.79616939565537Q 91.5 127.95261694373926 183 127.22929796380954T 366 125.9201973346234T 549 125.20960652021027T 732 114.71172432719803T 915 114.5674833896949T 1098 120.43195682730708T 1281 114.3241772602027T 1464 101.03290751608883T 1647 106.41031533935278T 1830 111.84112427088927T 2013 100.614501318115L 2013 42.38027803214411Q 1921.5 46.04909383719906 1830 37.99181999110033T 1647 31.404508339784268T 1464 39.38860073517188T 1281 33.41992677620586T 1098 27.79150491429902T 915 24.256628599037807T 732 14.924118235928844T 549 25.515918893729825T 366 11.718782656335698T 183 17.225412001996336T 0 17.404003067650393Z"></animate>
            </path><path d="" fill="url(#lg-0.6281374458194822)" opacity="0.4">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-18.75s" values="M0 0M 0 134.79745872762214Q 91.5 137.37912120053957 183 128.3691900146311T 366 115.90046761176086T 549 117.66365905874248T 732 111.82988579011231T 915 121.72982277880405T 1098 113.90546952082579T 1281 117.16085875786382T 1464 104.83710369310249T 1647 107.21268370836864T 1830 102.00029395391302T 2013 99.99127770724567L 2013 38.74906277929008Q 1921.5 37.661556932097945 1830 29.62302655481414T 1647 32.40852991194369T 1464 30.01521398774583T 1281 30.88830536585848T 1098 22.90058211253386T 915 17.564877806203985T 732 25.33074527014724T 549 28.547967107593408T 366 21.137635646092463T 183 10.780021092668864T 0 16.40383375985256Z;M0 0M 0 131.6807234256853Q 91.5 128.9905432241416 183 119.08061261215212T 366 124.00312413428458T 549 119.8372780910481T 732 123.3490837866207T 915 109.19201766880609T 1098 119.79672945426162T 1281 112.91144004169564T 1464 116.56757653283078T 1647 105.89905957969152T 1830 102.33394506258954T 2013 94.1643577123709L 2013 40.49179754918205Q 1921.5 40.57580580346087 1830 35.38151520838009T 1647 32.33434161330659T 1464 28.3170948508113T 1281 31.774093467917133T 1098 29.328763311125726T 915 23.490093675560725T 732 29.546346868644058T 549 29.090914436679T 366 22.134129540129855T 183 14.26713665907425T 0 13.558131435991754Z;M0 0M 0 131.77205278369388Q 91.5 123.21912379260274 183 122.2277315006064T 366 118.56894580049365T 549 124.38038699943276T 732 114.01061683838671T 915 106.91456544908048T 1098 108.18266282965213T 1281 117.94440027551525T 1464 115.89674796024542T 1647 113.92244527748294T 1830 102.80371329966835T 2013 98.43944710803737L 2013 31.538310246765846Q 1921.5 33.732756565806916 1830 32.64655078192581T 1647 26.481387061431246T 1464 27.070084377438775T 1281 37.34770057650666T 1098 31.76472455794311T 915 17.270421876658407T 732 26.68999942220656T 549 26.584390817598297T 366 11.741472196158917T 183 17.94309389625391T 0 18.823180125871644Z;M0 0M 0 134.79745872762214Q 91.5 137.37912120053957 183 128.3691900146311T 366 115.90046761176086T 549 117.66365905874248T 732 111.82988579011231T 915 121.72982277880405T 1098 113.90546952082579T 1281 117.16085875786382T 1464 104.83710369310249T 1647 107.21268370836864T 1830 102.00029395391302T 2013 99.99127770724567L 2013 38.74906277929008Q 1921.5 37.661556932097945 1830 29.62302655481414T 1647 32.40852991194369T 1464 30.01521398774583T 1281 30.88830536585848T 1098 22.90058211253386T 915 17.564877806203985T 732 25.33074527014724T 549 28.547967107593408T 366 21.137635646092463T 183 10.780021092668864T 0 16.40383375985256Z"></animate>
            </path></g>
            </svg>
        </div>
        <div class="coso coso1">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:rgba(255, 255, 255, 0);display:block;z-index:1;position:relative" width="1338" height="993" preserveAspectRatio="xMidYMid" viewBox="0 0 1338 993">
            <g transform="translate(669,496.5) scale(1,1) translate(-669,-496.5)"><linearGradient id="lg-0.89617662972421" x1="0" x2="1" y1="0" y2="0">
              <stop stop-color="var(--svgColor1)" offset="0"></stop>
              <stop stop-color="var(--svgColor2)" offset="1"></stop>
            </linearGradient><path d="M 1240 497 C 1240 603 1053 807 970 873 C 887 939 676 942 573 918 C 470 894 307 789 261 693 C 215 597 140 360 186 264 C 232 168 485 166 588 142 C 691 118 859 88 942 154 C 1025 220 1240 391 1240 497" fill="url(#lg-0.89617662972421)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-10s" values="M 1240 497 C 1240 603 1053 807 970 873 C 887 939 676 942 573 918 C 470 894 307 789 261 693 C 215 597 140 360 186 264 C 232 168 485 166 588 142 C 691 118 859 88 942 154 C 1025 220 1240 391 1240 497;M 1196 497 C 1196 594 967 714 891 775 C 815 836 687 855 592 833 C 497 811 327 770 285 682 C 243 594 179 369 221 281 C 263 193 503 206 598 184 C 693 162 841 124 917 185 C 993 246 1196 400 1196 497;M 1299 497 C 1299 628 1075 796 973 878 C 871 960 704 932 576 903 C 448 874 144 895 87 777 C 30 659 -20 310 37 192 C 94 74 455 147 583 118 C 711 89 942 -55 1044 27 C 1146 109 1299 366 1299 497;M 1240 497 C 1240 603 1053 807 970 873 C 887 939 676 942 573 918 C 470 894 307 789 261 693 C 215 597 140 360 186 264 C 232 168 485 166 588 142 C 691 118 859 88 942 154 C 1025 220 1240 391 1240 497"></animate>
            </path><path d="M 1278 497 C 1278 608 1057 805 970 874 C 883 943 687 915 579 890 C 471 865 185 853 137 753 C 89 653 88 340 136 240 C 184 140 463 91 571 66 C 679 41 909 17 996 86 C 1083 155 1278 386 1278 497" fill="url(#lg-0.89617662972421)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-10s" values="M 1278 497 C 1278 608 1057 805 970 874 C 883 943 687 915 579 890 C 471 865 185 853 137 753 C 89 653 88 340 136 240 C 184 140 463 91 571 66 C 679 41 909 17 996 86 C 1083 155 1278 386 1278 497;M 1275 497 C 1275 613 1103 855 1012 927 C 921 999 677 981 564 955 C 451 929 218 842 168 738 C 118 634 103 352 153 248 C 203 144 474 162 587 136 C 700 110 910 8 1001 80 C 1092 152 1275 381 1275 497;M 1162 497 C 1162 606 1073 828 988 896 C 903 964 681 933 575 909 C 469 885 223 832 176 734 C 129 636 178 380 225 282 C 272 184 471 118 577 94 C 683 70 846 99 931 167 C 1016 235 1162 388 1162 497;M 1278 497 C 1278 608 1057 805 970 874 C 883 943 687 915 579 890 C 471 865 185 853 137 753 C 89 653 88 340 136 240 C 184 140 463 91 571 66 C 679 41 909 17 996 86 C 1083 155 1278 386 1278 497"></animate>
            </path><path d="M 1248 497 C 1248 615 1062 801 970 874 C 878 947 681 975 566 949 C 451 923 217 845 166 739 C 115 633 144 374 195 268 C 246 162 450 69 565 43 C 680 17 855 75 947 148 C 1039 221 1248 379 1248 497" fill="url(#lg-0.89617662972421)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-10s" values="M 1248 497 C 1248 615 1062 801 970 874 C 878 947 681 975 566 949 C 451 923 217 845 166 739 C 115 633 144 374 195 268 C 246 162 450 69 565 43 C 680 17 855 75 947 148 C 1039 221 1248 379 1248 497;M 1324 497 C 1324 625 1078 804 978 884 C 878 964 695 959 570 931 C 445 903 116 904 61 789 C 6 674 92 360 147 245 C 202 130 451 120 576 91 C 701 62 889 16 989 96 C 1089 176 1324 369 1324 497;M 1326 497 C 1326 621 1067 796 970 874 C 873 952 699 922 578 894 C 457 866 239 842 185 730 C 131 618 13 319 67 207 C 121 95 439 49 560 21 C 681 -7 885 26 982 104 C 1079 182 1326 373 1326 497;M 1248 497 C 1248 615 1062 801 970 874 C 878 947 681 975 566 949 C 451 923 217 845 166 739 C 115 633 144 374 195 268 C 246 162 450 69 565 43 C 680 17 855 75 947 148 C 1039 221 1248 379 1248 497"></animate>
            </path><path d="M 1268 497 C 1268 623 1098 833 1000 911 C 902 989 709 889 586 861 C 463 833 215 855 160 742 C 105 629 27 327 81 214 C 135 101 465 169 588 141 C 711 113 866 49 964 127 C 1062 205 1268 371 1268 497" fill="url(#lg-0.89617662972421)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-10s" values="M 1268 497 C 1268 623 1098 833 1000 911 C 902 989 709 889 586 861 C 463 833 215 855 160 742 C 105 629 27 327 81 214 C 135 101 465 169 588 141 C 711 113 866 49 964 127 C 1062 205 1268 371 1268 497;M 1164 497 C 1164 605 1078 835 994 903 C 910 971 687 902 582 878 C 477 854 217 834 170 737 C 123 640 121 352 168 255 C 215 158 482 161 587 137 C 692 113 894 40 979 107 C 1064 174 1164 389 1164 497;M 1237 497 C 1237 615 1031 762 939 836 C 847 910 689 941 574 915 C 459 889 198 854 147 748 C 96 642 129 367 180 261 C 231 155 456 92 571 66 C 686 40 881 42 973 116 C 1065 190 1237 379 1237 497;M 1268 497 C 1268 623 1098 833 1000 911 C 902 989 709 889 586 861 C 463 833 215 855 160 742 C 105 629 27 327 81 214 C 135 101 465 169 588 141 C 711 113 866 49 964 127 C 1062 205 1268 371 1268 497"></animate>
            </path><path d="M 1192 497 C 1192 595 1028 790 951 851 C 874 912 683 879 587 857 C 491 835 326 770 283 682 C 240 594 220 389 263 301 C 306 213 489 149 585 127 C 681 105 819 151 896 212 C 973 273 1192 399 1192 497" fill="url(#lg-0.89617662972421)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-10s" values="M 1192 497 C 1192 595 1028 790 951 851 C 874 912 683 879 587 857 C 491 835 326 770 283 682 C 240 594 220 389 263 301 C 306 213 489 149 585 127 C 681 105 819 151 896 212 C 973 273 1192 399 1192 497;M 1092 497 C 1092 592 1001 761 927 820 C 853 879 694 816 601 795 C 508 774 317 772 276 686 C 235 600 268 409 309 323 C 350 237 499 182 592 161 C 685 140 820 154 895 213 C 970 272 1092 402 1092 497;M 1202 497 C 1202 599 1056 817 976 881 C 896 945 687 873 588 850 C 489 827 251 811 207 719 C 163 627 185 377 229 285 C 273 193 483 139 582 116 C 681 93 851 104 931 168 C 1011 232 1202 395 1202 497;M 1192 497 C 1192 595 1028 790 951 851 C 874 912 683 879 587 857 C 491 835 326 770 283 682 C 240 594 220 389 263 301 C 306 213 489 149 585 127 C 681 105 819 151 896 212 C 973 273 1192 399 1192 497"></animate>
            </path></g>
            </svg>
        </div>
        <div class="coso coso2">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:rgba(255, 255, 255, 0);display:block;z-index:1;position:relative" width="1395" height="1050" preserveAspectRatio="xMidYMid" viewBox="0 0 1395 1050">
            <g transform="translate(697.5,525) scale(1,1) translate(-697.5,-525)"><linearGradient id="lg-0.4071668219799969" x1="0" x2="1" y1="0" y2="0">
              <stop stop-color="var(--svgColor1a)" offset="0"></stop>
              <stop stop-color="var(--svgColor2a)" offset="1"></stop>
            </linearGradient><path d="M 1293 525 C 1293 676 1058 850 928 925 C 798 1000 597 999 467 924 C 337 849 96 676 96 525 C 96 374 277 97 407 22 C 537 -53 841 -23 971 52 C 1101 127 1293 374 1293 525" fill="url(#lg-0.4071668219799969)" opacity="0.49">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-8.333333333333334s" values="M 1293 525 C 1293 676 1058 850 928 925 C 798 1000 597 999 467 924 C 337 849 96 676 96 525 C 96 374 277 97 407 22 C 537 -53 841 -23 971 52 C 1101 127 1293 374 1293 525;M 1311 525 C 1311 654 1050 877 938 941 C 826 1005 572 1001 460 937 C 348 873 186 654 186 525 C 186 396 344 170 456 106 C 568 42 786 114 898 178 C 1010 242 1311 396 1311 525;M 1327 525 C 1327 661 1063 885 945 953 C 827 1021 610 950 492 882 C 374 814 164 661 164 525 C 164 389 320 144 438 76 C 556 8 807 63 925 131 C 1043 199 1327 389 1327 525;M 1293 525 C 1293 676 1058 850 928 925 C 798 1000 597 999 467 924 C 337 849 96 676 96 525 C 96 374 277 97 407 22 C 537 -53 841 -23 971 52 C 1101 127 1293 374 1293 525"></animate>
            </path><path d="M 1335 525 C 1335 663 1028 823 909 892 C 790 961 546 1062 427 993 C 308 924 163 663 163 525 C 163 387 376 244 495 175 C 614 106 818 41 937 110 C 1056 179 1335 387 1335 525" fill="url(#lg-0.4071668219799969)" opacity="0.49">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-8.333333333333334s" values="M 1335 525 C 1335 663 1028 823 909 892 C 790 961 546 1062 427 993 C 308 924 163 663 163 525 C 163 387 376 244 495 175 C 614 106 818 41 937 110 C 1056 179 1335 387 1335 525;M 1207 525 C 1207 660 1052 869 935 936 C 818 1003 557 1038 440 971 C 323 904 78 660 78 525 C 78 390 336 168 453 101 C 570 34 848 -5 965 62 C 1082 129 1207 390 1207 525;M 1272 525 C 1272 653 1048 876 937 940 C 826 1004 609 934 498 870 C 387 806 168 653 168 525 C 168 397 348 176 459 112 C 570 48 797 96 908 160 C 1019 224 1272 397 1272 525;M 1335 525 C 1335 663 1028 823 909 892 C 790 961 546 1062 427 993 C 308 924 163 663 163 525 C 163 387 376 244 495 175 C 614 106 818 41 937 110 C 1056 179 1335 387 1335 525"></animate>
            </path><path d="M 1218 525 C 1218 660 1061 884 944 951 C 827 1018 551 1048 434 981 C 317 914 92 660 92 525 C 92 390 346 186 463 119 C 580 52 797 83 914 150 C 1031 217 1218 390 1218 525" fill="url(#lg-0.4071668219799969)" opacity="0.49">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-8.333333333333334s" values="M 1218 525 C 1218 660 1061 884 944 951 C 827 1018 551 1048 434 981 C 317 914 92 660 92 525 C 92 390 346 186 463 119 C 580 52 797 83 914 150 C 1031 217 1218 390 1218 525;M 1227 525 C 1227 662 1022 812 903 881 C 784 950 575 1011 456 942 C 337 873 93 662 93 525 C 93 388 352 202 471 133 C 590 64 788 93 907 162 C 1026 231 1227 388 1227 525;M 1285 525 C 1285 675 1087 899 957 974 C 827 1049 558 1067 428 992 C 298 917 89 675 89 525 C 89 375 307 149 437 74 C 567 -1 843 -28 973 47 C 1103 122 1285 375 1285 525;M 1218 525 C 1218 660 1061 884 944 951 C 827 1018 551 1048 434 981 C 317 914 92 660 92 525 C 92 390 346 186 463 119 C 580 52 797 83 914 150 C 1031 217 1218 390 1218 525"></animate>
            </path><path d="M 1224 525 C 1224 663 1045 851 925 920 C 805 989 572 1017 453 948 C 334 879 129 663 129 525 C 129 387 314 137 433 68 C 552 -1 804 63 924 132 C 1044 201 1224 387 1224 525" fill="url(#lg-0.4071668219799969)" opacity="0.49">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-8.333333333333334s" values="M 1224 525 C 1224 663 1045 851 925 920 C 805 989 572 1017 453 948 C 334 879 129 663 129 525 C 129 387 314 137 433 68 C 552 -1 804 63 924 132 C 1044 201 1224 387 1224 525;M 1112 525 C 1112 633 984 804 890 858 C 796 912 592 925 498 871 C 404 817 273 633 273 525 C 273 417 395 218 489 164 C 583 110 763 195 857 249 C 951 303 1112 417 1112 525;M 1110 525 C 1110 633 949 746 856 800 C 763 854 589 927 496 873 C 403 819 212 633 212 525 C 212 417 420 260 513 206 C 606 152 786 157 879 211 C 972 265 1110 417 1110 525;M 1224 525 C 1224 663 1045 851 925 920 C 805 989 572 1017 453 948 C 334 879 129 663 129 525 C 129 387 314 137 433 68 C 552 -1 804 63 924 132 C 1044 201 1224 387 1224 525"></animate>
            </path><path d="M 1271 525 C 1271 653 1010 811 900 875 C 790 939 595 957 485 893 C 375 829 166 653 166 525 C 166 397 376 223 486 159 C 596 95 799 95 909 159 C 1019 223 1271 397 1271 525" fill="url(#lg-0.4071668219799969)" opacity="0.49">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-8.333333333333334s" values="M 1271 525 C 1271 653 1010 811 900 875 C 790 939 595 957 485 893 C 375 829 166 653 166 525 C 166 397 376 223 486 159 C 596 95 799 95 909 159 C 1019 223 1271 397 1271 525;M 1199 525 C 1199 654 1047 872 935 937 C 823 1002 573 1000 461 935 C 349 870 189 654 189 525 C 189 396 331 150 443 85 C 555 20 781 121 893 186 C 1005 251 1199 396 1199 525;M 1324 525 C 1324 665 1024 811 903 881 C 782 951 600 974 479 904 C 358 834 97 665 97 525 C 97 385 359 218 480 148 C 601 78 790 85 911 155 C 1032 225 1324 385 1324 525;M 1271 525 C 1271 653 1010 811 900 875 C 790 939 595 957 485 893 C 375 829 166 653 166 525 C 166 397 376 223 486 159 C 596 95 799 95 909 159 C 1019 223 1271 397 1271 525"></animate>
            </path><path d="M 1137 525 C 1137 641 988 796 887 854 C 786 912 610 910 509 852 C 408 794 207 641 207 525 C 207 409 412 264 513 206 C 614 148 772 163 873 221 C 974 279 1137 409 1137 525" fill="url(#lg-0.4071668219799969)" opacity="0.49">
              <animate attributeName="d" dur="25s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-8.333333333333334s" values="M 1137 525 C 1137 641 988 796 887 854 C 786 912 610 910 509 852 C 408 794 207 641 207 525 C 207 409 412 264 513 206 C 614 148 772 163 873 221 C 974 279 1137 409 1137 525;M 1281 525 C 1281 673 1117 955 989 1029 C 861 1103 591 1005 463 931 C 335 857 83 673 83 525 C 83 377 300 132 428 58 C 556 -16 803 47 931 121 C 1059 195 1281 377 1281 525;M 1209 525 C 1209 659 1046 860 930 927 C 814 994 599 963 483 896 C 367 829 179 659 179 525 C 179 391 365 217 481 150 C 597 83 842 7 958 74 C 1074 141 1209 391 1209 525;M 1137 525 C 1137 641 988 796 887 854 C 786 912 610 910 509 852 C 408 794 207 641 207 525 C 207 409 412 264 513 206 C 614 148 772 163 873 221 C 974 279 1137 409 1137 525"></animate>
            </path></g>
            </svg>
        </div>
        <div class="coso coso3">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:rgba(241, 242, 243, 0);display:block;z-index:1;position:relative" width="1107" height="897" preserveAspectRatio="xMidYMid" viewBox="0 0 1107 897">
            <g transform="translate(553.5,448.5) scale(1,1) translate(-553.5,-448.5)"><linearGradient id="lg-0.23118890192512165" x1="0" x2="1" y1="0" y2="0">
              <stop stop-color="var(--svgColor1a)" offset="0"></stop>
              <stop stop-color="var(--svgColor2a)" offset="1"></stop>
            </linearGradient><path d="M 828 449 C 828 536 703 627 620 654 C 537 681 367 692 316 621 C 265 550 280 358 331 287 C 382 216 552 170 635 197 C 718 224 828 362 828 449" fill="url(#lg-0.23118890192512165)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 828 449 C 828 536 703 627 620 654 C 537 681 367 692 316 621 C 265 550 280 358 331 287 C 382 216 552 170 635 197 C 718 224 828 362 828 449;M 905 449 C 905 544 714 632 623 662 C 532 692 356 710 300 633 C 244 556 218 323 274 246 C 330 169 529 215 620 244 C 711 273 905 354 905 449;M 967 449 C 967 559 759 728 655 762 C 551 796 347 734 283 645 C 219 556 228 348 292 259 C 356 170 541 132 645 166 C 749 200 967 339 967 449;M 828 449 C 828 536 703 627 620 654 C 537 681 367 692 316 621 C 265 550 280 358 331 287 C 382 216 552 170 635 197 C 718 224 828 362 828 449"></animate>
            </path><path d="M 900 449 C 900 554 743 689 643 722 C 543 755 334 738 272 653 C 210 568 192 316 254 231 C 316 146 544 137 644 169 C 744 201 900 344 900 449" fill="url(#lg-0.23118890192512165)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 900 449 C 900 554 743 689 643 722 C 543 755 334 738 272 653 C 210 568 192 316 254 231 C 316 146 544 137 644 169 C 744 201 900 344 900 449;M 1033 449 C 1033 588 779 695 647 738 C 515 781 265 830 183 718 C 101 606 126 309 208 197 C 290 85 528 78 660 121 C 792 164 1033 310 1033 449;M 1071 449 C 1071 584 779 709 651 750 C 523 791 253 833 174 724 C 95 615 95 282 174 173 C 253 64 549 26 677 67 C 805 108 1071 314 1071 449;M 900 449 C 900 554 743 689 643 722 C 543 755 334 738 272 653 C 210 568 192 316 254 231 C 316 146 544 137 644 169 C 744 201 900 344 900 449"></animate>
            </path><path d="M 1018 449 C 1018 595 819 794 680 839 C 541 884 228 866 142 748 C 56 630 77 283 163 165 C 249 47 518 86 657 131 C 796 176 1018 303 1018 449" fill="url(#lg-0.23118890192512165)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1018 449 C 1018 595 819 794 680 839 C 541 884 228 866 142 748 C 56 630 77 283 163 165 C 249 47 518 86 657 131 C 796 176 1018 303 1018 449;M 950 449 C 950 550 745 711 649 742 C 553 773 329 736 270 654 C 211 572 204 320 264 238 C 324 156 530 194 626 225 C 722 256 950 348 950 449;M 1025 449 C 1025 587 779 696 648 739 C 517 782 241 846 160 734 C 79 622 142 319 223 208 C 304 97 542 37 673 80 C 804 123 1025 311 1025 449;M 1018 449 C 1018 595 819 794 680 839 C 541 884 228 866 142 748 C 56 630 77 283 163 165 C 249 47 518 86 657 131 C 796 176 1018 303 1018 449"></animate>
            </path><path d="M 1026 449 C 1026 586 796 752 666 794 C 536 836 250 839 169 728 C 88 617 87 279 168 168 C 249 57 530 78 660 120 C 790 162 1026 312 1026 449" fill="url(#lg-0.23118890192512165)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1026 449 C 1026 586 796 752 666 794 C 536 836 250 839 169 728 C 88 617 87 279 168 168 C 249 57 530 78 660 120 C 790 162 1026 312 1026 449;M 1000 449 C 1000 562 752 695 645 730 C 538 765 348 737 282 646 C 216 555 197 329 263 238 C 329 147 527 165 634 200 C 741 235 1000 336 1000 449;M 902 449 C 902 542 712 634 623 663 C 534 692 389 684 334 608 C 279 532 232 331 287 255 C 342 179 528 224 617 253 C 706 282 902 356 902 449;M 1026 449 C 1026 586 796 752 666 794 C 536 836 250 839 169 728 C 88 617 87 279 168 168 C 249 57 530 78 660 120 C 790 162 1026 312 1026 449"></animate>
            </path><path d="M 945 449 C 945 555 746 698 645 731 C 544 764 323 747 261 661 C 199 575 231 345 293 259 C 355 173 539 151 640 184 C 741 217 945 343 945 449" fill="url(#lg-0.23118890192512165)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 945 449 C 945 555 746 698 645 731 C 544 764 323 747 261 661 C 199 575 231 345 293 259 C 355 173 539 151 640 184 C 741 217 945 343 945 449;M 870 449 C 870 541 720 663 632 691 C 544 719 344 714 290 640 C 236 566 262 350 316 276 C 370 202 542 184 630 212 C 718 240 870 357 870 449;M 964 449 C 964 569 749 662 635 699 C 521 736 302 780 231 683 C 160 586 149 303 219 206 C 289 109 531 131 645 168 C 759 205 964 329 964 449;M 945 449 C 945 555 746 698 645 731 C 544 764 323 747 261 661 C 199 575 231 345 293 259 C 355 173 539 151 640 184 C 741 217 945 343 945 449"></animate>
            </path><path d="M 1049 449 C 1049 574 775 726 656 765 C 537 804 303 785 229 684 C 155 583 120 288 194 187 C 268 86 524 135 643 174 C 762 213 1049 324 1049 449" fill="url(#lg-0.23118890192512165)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1049 449 C 1049 574 775 726 656 765 C 537 804 303 785 229 684 C 155 583 120 288 194 187 C 268 86 524 135 643 174 C 762 213 1049 324 1049 449;M 1046 449 C 1046 586 782 710 652 752 C 522 794 286 813 205 702 C 124 591 156 329 236 218 C 316 107 541 44 671 86 C 801 128 1046 312 1046 449;M 1026 449 C 1026 583 800 776 673 817 C 546 858 269 821 190 713 C 111 605 90 277 168 169 C 246 61 520 121 647 162 C 774 203 1026 315 1026 449;M 1049 449 C 1049 574 775 726 656 765 C 537 804 303 785 229 684 C 155 583 120 288 194 187 C 268 86 524 135 643 174 C 762 213 1049 324 1049 449"></animate>
            </path><path d="M 1010 449 C 1010 576 792 770 671 809 C 550 848 292 796 217 693 C 142 590 136 303 211 200 C 286 97 535 93 656 132 C 777 171 1010 322 1010 449" fill="url(#lg-0.23118890192512165)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1010 449 C 1010 576 792 770 671 809 C 550 848 292 796 217 693 C 142 590 136 303 211 200 C 286 97 535 93 656 132 C 777 171 1010 322 1010 449;M 936 449 C 936 551 723 641 626 672 C 529 703 349 722 289 640 C 229 558 202 319 262 237 C 322 155 528 197 625 228 C 722 259 936 347 936 449;M 1043 449 C 1043 597 815 774 674 820 C 533 866 291 823 204 703 C 117 583 27 249 114 129 C 201 9 516 83 657 129 C 798 175 1043 301 1043 449;M 1010 449 C 1010 576 792 770 671 809 C 550 848 292 796 217 693 C 142 590 136 303 211 200 C 286 97 535 93 656 132 C 777 171 1010 322 1010 449"></animate>
            </path></g>
            </svg>
        </div>
        <div class="coso coso4">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:rgba(241, 242, 243, 0);display:block;z-index:1;position:relative" width="1595" height="1658" preserveAspectRatio="xMidYMid" viewBox="0 0 1595 1658">
            <g transform="translate(797.5,829) scale(1,1) translate(-797.5,-829)"><linearGradient id="lg-0.2255543724015865" x1="0" x2="1" y1="0" y2="0">
              <stop stop-color="var(--svgColor1a)" offset="0"></stop>
              <stop stop-color="var(--svgColor2a)" offset="1"></stop>
            </linearGradient><path d="M 1481 829 C 1481 1015 1149 1307 972 1365 C 795 1423 437 1321 328 1170 C 219 1019 228 646 337 495 C 446 344 753 363 930 420 C 1107 477 1481 643 1481 829" fill="url(#lg-0.2255543724015865)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1481 829 C 1481 1015 1149 1307 972 1365 C 795 1423 437 1321 328 1170 C 219 1019 228 646 337 495 C 446 344 753 363 930 420 C 1107 477 1481 643 1481 829;M 1299 829 C 1299 974 1037 1098 899 1143 C 761 1188 498 1225 413 1108 C 328 991 349 682 434 565 C 519 448 771 441 909 486 C 1047 531 1299 684 1299 829;M 1474 829 C 1474 1029 1144 1245 953 1307 C 762 1369 393 1371 275 1209 C 157 1047 113 580 231 418 C 349 256 752 324 942 386 C 1132 448 1474 629 1474 829;M 1481 829 C 1481 1015 1149 1307 972 1365 C 795 1423 437 1321 328 1170 C 219 1019 228 646 337 495 C 446 344 753 363 930 420 C 1107 477 1481 643 1481 829"></animate>
            </path><path d="M 1283 829 C 1283 979 1063 1158 920 1205 C 777 1252 454 1264 366 1142 C 278 1020 296 651 384 529 C 472 407 766 440 909 487 C 1052 534 1283 679 1283 829" fill="url(#lg-0.2255543724015865)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1283 829 C 1283 979 1063 1158 920 1205 C 777 1252 454 1264 366 1142 C 278 1020 296 651 384 529 C 472 407 766 440 909 487 C 1052 534 1283 679 1283 829;M 1300 829 C 1300 963 1023 1089 895 1130 C 767 1171 522 1195 443 1087 C 364 979 334 657 413 549 C 492 441 784 435 912 476 C 1040 517 1300 695 1300 829;M 1367 829 C 1367 980 1054 1129 910 1176 C 766 1223 455 1265 366 1143 C 277 1021 360 699 449 576 C 538 453 784 379 928 426 C 1072 473 1367 678 1367 829;M 1283 829 C 1283 979 1063 1158 920 1205 C 777 1252 454 1264 366 1142 C 278 1020 296 651 384 529 C 472 407 766 440 909 487 C 1052 534 1283 679 1283 829"></animate>
            </path><path d="M 1348 829 C 1348 972 1039 1109 903 1153 C 767 1197 489 1230 405 1114 C 321 998 292 639 376 523 C 460 407 782 413 918 457 C 1054 501 1348 686 1348 829" fill="url(#lg-0.2255543724015865)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1348 829 C 1348 972 1039 1109 903 1153 C 767 1197 489 1230 405 1114 C 321 998 292 639 376 523 C 460 407 782 413 918 457 C 1054 501 1348 686 1348 829;M 1272 829 C 1272 970 1037 1111 903 1155 C 769 1199 496 1222 413 1108 C 330 994 292 636 375 522 C 458 408 770 456 904 500 C 1038 544 1272 688 1272 829;M 1257 829 C 1257 969 1049 1150 916 1193 C 783 1236 524 1201 442 1087 C 360 973 321 657 403 543 C 485 429 791 395 924 438 C 1057 481 1257 689 1257 829;M 1348 829 C 1348 972 1039 1109 903 1153 C 767 1197 489 1230 405 1114 C 321 998 292 639 376 523 C 460 407 782 413 918 457 C 1054 501 1348 686 1348 829"></animate>
            </path><path d="M 1433 829 C 1433 1006 1112 1224 944 1279 C 776 1334 422 1320 318 1177 C 214 1034 240 643 344 500 C 448 357 758 378 926 433 C 1094 488 1433 652 1433 829" fill="url(#lg-0.2255543724015865)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1433 829 C 1433 1006 1112 1224 944 1279 C 776 1334 422 1320 318 1177 C 214 1034 240 643 344 500 C 448 357 758 378 926 433 C 1094 488 1433 652 1433 829;M 1397 829 C 1397 985 1056 1122 908 1170 C 760 1218 492 1244 400 1118 C 308 992 337 687 428 561 C 519 435 774 398 922 446 C 1070 494 1397 673 1397 829;M 1272 829 C 1272 968 1027 1083 894 1126 C 761 1169 549 1182 467 1069 C 385 956 367 689 449 576 C 531 463 777 440 910 483 C 1043 526 1272 690 1272 829;M 1433 829 C 1433 1006 1112 1224 944 1279 C 776 1334 422 1320 318 1177 C 214 1034 240 643 344 500 C 448 357 758 378 926 433 C 1094 488 1433 652 1433 829"></animate>
            </path><path d="M 1307 829 C 1307 967 1040 1128 909 1171 C 778 1214 483 1228 402 1116 C 321 1004 356 679 437 567 C 518 455 796 386 927 429 C 1058 472 1307 691 1307 829" fill="url(#lg-0.2255543724015865)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1307 829 C 1307 967 1040 1128 909 1171 C 778 1214 483 1228 402 1116 C 321 1004 356 679 437 567 C 518 455 796 386 927 429 C 1058 472 1307 691 1307 829;M 1482 829 C 1482 1004 1108 1220 942 1274 C 776 1328 457 1292 354 1151 C 251 1010 257 652 360 511 C 463 370 756 393 922 447 C 1088 501 1482 654 1482 829;M 1517 829 C 1517 1045 1157 1234 951 1301 C 745 1368 363 1412 236 1237 C 109 1062 113 599 240 424 C 367 249 754 262 960 329 C 1166 396 1517 613 1517 829;M 1307 829 C 1307 967 1040 1128 909 1171 C 778 1214 483 1228 402 1116 C 321 1004 356 679 437 567 C 518 455 796 386 927 429 C 1058 472 1307 691 1307 829"></animate>
            </path><path d="M 1306 829 C 1306 978 1075 1203 934 1249 C 793 1295 482 1241 395 1121 C 308 1001 339 679 426 559 C 513 439 763 456 904 502 C 1045 548 1306 680 1306 829" fill="url(#lg-0.2255543724015865)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1306 829 C 1306 978 1075 1203 934 1249 C 793 1295 482 1241 395 1121 C 308 1001 339 679 426 559 C 513 439 763 456 904 502 C 1045 548 1306 680 1306 829;M 1554 829 C 1554 1022 1119 1192 935 1252 C 751 1312 354 1389 241 1233 C 128 1077 221 648 334 492 C 447 336 781 253 965 313 C 1149 373 1554 636 1554 829;M 1220 829 C 1220 963 1016 1069 889 1110 C 762 1151 537 1184 458 1076 C 379 968 362 678 441 570 C 520 462 781 448 908 489 C 1035 530 1220 695 1220 829;M 1306 829 C 1306 978 1075 1203 934 1249 C 793 1295 482 1241 395 1121 C 308 1001 339 679 426 559 C 513 439 763 456 904 502 C 1045 548 1306 680 1306 829"></animate>
            </path><path d="M 1353 829 C 1353 1005 1127 1276 960 1330 C 793 1384 491 1269 388 1127 C 285 985 219 625 322 483 C 425 341 766 357 933 411 C 1100 465 1353 653 1353 829" fill="url(#lg-0.2255543724015865)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-2.857142857142857s" values="M 1353 829 C 1353 1005 1127 1276 960 1330 C 793 1384 491 1269 388 1127 C 285 985 219 625 322 483 C 425 341 766 357 933 411 C 1100 465 1353 653 1353 829;M 1467 829 C 1467 1006 1127 1269 958 1324 C 789 1379 451 1300 347 1156 C 243 1012 197 611 301 468 C 405 325 764 357 933 412 C 1102 467 1467 652 1467 829;M 1407 829 C 1407 992 1072 1147 917 1197 C 762 1247 509 1239 414 1107 C 319 975 322 684 418 553 C 514 422 786 338 941 388 C 1096 438 1407 666 1407 829;M 1353 829 C 1353 1005 1127 1276 960 1330 C 793 1384 491 1269 388 1127 C 285 985 219 625 322 483 C 425 341 766 357 933 411 C 1100 465 1353 653 1353 829"></animate>
            </path></g>
            </svg>
        </div>
        <div class="coso coso5">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:rgba(241, 242, 243, 0);display:block;z-index:1;position:relative" width="1107" height="691" preserveAspectRatio="xMidYMid" viewBox="0 0 1107 691">
            <g transform="translate(553.5,345.5) scale(1,1) translate(-553.5,-345.5)"><linearGradient id="lg-0.05398456535918772" x1="0" x2="1" y1="0" y2="0">
              <stop stop-color="var(--svgColor1)" offset="0"></stop>
              <stop stop-color="var(--svgColor2)" offset="1"></stop>
            </linearGradient><path d="M 946 346 C 946 470 678 551 554 551 C 430 551 215 470 215 346 C 215 222 430 142 554 142 C 678 142 946 222 946 346" fill="url(#lg-0.05398456535918772)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-4s" values="M 946 346 C 946 470 678 551 554 551 C 430 551 215 470 215 346 C 215 222 430 142 554 142 C 678 142 946 222 946 346;M 857 346 C 857 463 671 577 554 577 C 437 577 241 463 241 346 C 241 229 437 172 554 172 C 671 172 857 229 857 346;M 938 346 C 938 489 697 583 554 583 C 411 583 154 489 154 346 C 154 203 411 125 554 125 C 697 125 938 203 938 346;M 946 346 C 946 470 678 551 554 551 C 430 551 215 470 215 346 C 215 222 430 142 554 142 C 678 142 946 222 946 346"></animate>
            </path><path d="M 957 346 C 957 487 695 621 554 621 C 413 621 178 487 178 346 C 178 205 413 98 554 98 C 695 98 957 205 957 346" fill="url(#lg-0.05398456535918772)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-4s" values="M 957 346 C 957 487 695 621 554 621 C 413 621 178 487 178 346 C 178 205 413 98 554 98 C 695 98 957 205 957 346;M 984 346 C 984 490 698 642 554 642 C 410 642 144 490 144 346 C 144 202 410 47 554 47 C 698 47 984 202 984 346;M 816 346 C 816 450 658 531 554 531 C 450 531 270 450 270 346 C 270 242 450 141 554 141 C 658 141 816 242 816 346;M 957 346 C 957 487 695 621 554 621 C 413 621 178 487 178 346 C 178 205 413 98 554 98 C 695 98 957 205 957 346"></animate>
            </path><path d="M 883 346 C 883 452 660 501 554 501 C 448 501 284 452 284 346 C 284 240 448 160 554 160 C 660 160 883 240 883 346" fill="url(#lg-0.05398456535918772)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-4s" values="M 883 346 C 883 452 660 501 554 501 C 448 501 284 452 284 346 C 284 240 448 160 554 160 C 660 160 883 240 883 346;M 900 346 C 900 469 677 537 554 537 C 431 537 199 469 199 346 C 199 223 431 93 554 93 C 677 93 900 223 900 346;M 876 346 C 876 470 678 587 554 587 C 430 587 242 470 242 346 C 242 222 430 94 554 94 C 678 94 876 222 876 346;M 883 346 C 883 452 660 501 554 501 C 448 501 284 452 284 346 C 284 240 448 160 554 160 C 660 160 883 240 883 346"></animate>
            </path><path d="M 823 346 C 823 440 648 488 554 488 C 460 488 282 440 282 346 C 282 252 460 150 554 150 C 648 150 823 252 823 346" fill="url(#lg-0.05398456535918772)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-4s" values="M 823 346 C 823 440 648 488 554 488 C 460 488 282 440 282 346 C 282 252 460 150 554 150 C 648 150 823 252 823 346;M 847 346 C 847 450 658 526 554 526 C 450 526 238 450 238 346 C 238 242 450 133 554 133 C 658 133 847 242 847 346;M 969 346 C 969 481 689 607 554 607 C 419 607 215 481 215 346 C 215 211 419 129 554 129 C 689 129 969 211 969 346;M 823 346 C 823 440 648 488 554 488 C 460 488 282 440 282 346 C 282 252 460 150 554 150 C 648 150 823 252 823 346"></animate>
            </path><path d="M 1025 346 C 1025 496 704 560 554 560 C 404 560 113 496 113 346 C 113 196 403 29 553 29 C 703 29 1025 196 1025 346" fill="url(#lg-0.05398456535918772)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-4s" values="M 1025 346 C 1025 496 704 560 554 560 C 404 560 113 496 113 346 C 113 196 403 29 553 29 C 703 29 1025 196 1025 346;M 815 346 C 815 446 654 557 554 557 C 454 557 285 446 285 346 C 285 246 454 191 554 191 C 654 191 815 246 815 346;M 1042 346 C 1042 506 714 606 554 606 C 394 606 133 506 133 346 C 133 186 394 47 554 47 C 714 47 1042 186 1042 346;M 1025 346 C 1025 496 704 560 554 560 C 404 560 113 496 113 346 C 113 196 403 29 553 29 C 703 29 1025 196 1025 346"></animate>
            </path></g>
            </svg>
        </div>
        <div class="coso coso6">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:rgba(241, 242, 243, 0);display:block;z-index:1;position:relative" width="332" height="255" preserveAspectRatio="xMidYMid" viewBox="0 0 332 255">
            <g transform="translate(166,127.5) scale(1,1) translate(-166,-127.5)"><linearGradient id="lg-0.5994624562379582" x1="0" x2="1" y1="0" y2="0">
              <stop stop-color="var(--svgColor1)" offset="0"></stop>
              <stop stop-color="var(--svgColor2)" offset="1"></stop>
            </linearGradient><path d="M 311 128 C 311 164 226 194 191 205 C 156 216 80 234 59 205 C 38 176 53 90 74 61 C 95 32 158 35 193 46 C 228 57 311 92 311 128" fill="url(#lg-0.5994624562379582)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="33.333333333333336s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-9.523809523809524s" values="M 311 128 C 311 164 226 194 191 205 C 156 216 80 234 59 205 C 38 176 53 90 74 61 C 95 32 158 35 193 46 C 228 57 311 92 311 128;M 276 128 C 276 157 220 199 192 208 C 164 217 114 201 97 177 C 80 153 73 97 90 73 C 107 49 158 57 186 66 C 214 75 276 99 276 128;M 271 128 C 271 155 210 176 184 184 C 158 192 103 207 87 185 C 71 163 85 102 101 80 C 117 58 162 56 187 64 C 212 72 271 101 271 128;M 311 128 C 311 164 226 194 191 205 C 156 216 80 234 59 205 C 38 176 53 90 74 61 C 95 32 158 35 193 46 C 228 57 311 92 311 128"></animate>
            </path><path d="M 269 128 C 269 154 215 192 190 200 C 165 208 104 204 89 183 C 74 162 71 91 87 70 C 103 49 164 49 189 57 C 214 65 269 102 269 128" fill="url(#lg-0.5994624562379582)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="33.333333333333336s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-9.523809523809524s" values="M 269 128 C 269 154 215 192 190 200 C 165 208 104 204 89 183 C 74 162 71 91 87 70 C 103 49 164 49 189 57 C 214 65 269 102 269 128;M 267 128 C 267 156 213 179 186 188 C 159 197 104 208 87 185 C 70 162 67 91 84 68 C 101 45 164 42 191 51 C 218 60 267 100 267 128;M 254 128 C 254 151 207 179 185 186 C 163 193 115 194 101 175 C 87 156 89 100 103 81 C 117 62 160 71 182 78 C 204 85 254 105 254 128;M 269 128 C 269 154 215 192 190 200 C 165 208 104 204 89 183 C 74 162 71 91 87 70 C 103 49 164 49 189 57 C 214 65 269 102 269 128"></animate>
            </path><path d="M 266 128 C 266 160 219 189 189 199 C 159 209 93 220 74 194 C 55 168 57 88 76 62 C 95 36 163 33 193 43 C 223 53 266 96 266 128" fill="url(#lg-0.5994624562379582)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="33.333333333333336s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-9.523809523809524s" values="M 266 128 C 266 160 219 189 189 199 C 159 209 93 220 74 194 C 55 168 57 88 76 62 C 95 36 163 33 193 43 C 223 53 266 96 266 128;M 301 128 C 301 163 225 196 192 207 C 159 218 87 228 66 200 C 45 172 44 82 64 54 C 84 26 165 18 198 29 C 231 40 301 93 301 128;M 284 128 C 284 162 222 189 190 200 C 158 211 108 211 88 184 C 68 157 61 93 81 66 C 101 39 157 46 189 56 C 221 66 284 94 284 128;M 266 128 C 266 160 219 189 189 199 C 159 209 93 220 74 194 C 55 168 57 88 76 62 C 95 36 163 33 193 43 C 223 53 266 96 266 128"></animate>
            </path><path d="M 269 128 C 269 161 227 211 196 221 C 165 231 109 209 90 183 C 71 157 58 89 77 63 C 96 37 166 22 197 32 C 228 42 269 95 269 128" fill="url(#lg-0.5994624562379582)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="33.333333333333336s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-9.523809523809524s" values="M 269 128 C 269 161 227 211 196 221 C 165 231 109 209 90 183 C 71 157 58 89 77 63 C 96 37 166 22 197 32 C 228 42 269 95 269 128;M 300 128 C 300 166 239 227 202 239 C 165 251 82 236 59 205 C 36 174 46 88 69 57 C 92 26 157 29 194 41 C 231 53 300 90 300 128;M 280 128 C 280 159 222 200 193 210 C 164 220 104 211 86 186 C 68 161 55 85 73 60 C 91 35 166 28 195 38 C 224 48 280 97 280 128;M 269 128 C 269 161 227 211 196 221 C 165 231 109 209 90 183 C 71 157 58 89 77 63 C 96 37 166 22 197 32 C 228 42 269 95 269 128"></animate>
            </path><path d="M 276 128 C 276 158 219 193 190 202 C 161 211 97 214 79 190 C 61 166 75 99 93 75 C 111 51 165 33 194 42 C 223 51 276 98 276 128" fill="url(#lg-0.5994624562379582)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="33.333333333333336s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-9.523809523809524s" values="M 276 128 C 276 158 219 193 190 202 C 161 211 97 214 79 190 C 61 166 75 99 93 75 C 111 51 165 33 194 42 C 223 51 276 98 276 128;M 308 128 C 308 166 238 227 202 239 C 166 251 98 225 75 194 C 52 163 41 84 64 53 C 87 22 161 21 197 33 C 233 45 308 90 308 128;M 263 128 C 263 159 223 205 194 214 C 165 223 98 215 80 190 C 62 165 76 100 94 75 C 112 50 164 34 193 43 C 222 52 263 97 263 128;M 276 128 C 276 158 219 193 190 202 C 161 211 97 214 79 190 C 61 166 75 99 93 75 C 111 51 165 33 194 42 C 223 51 276 98 276 128"></animate>
            </path><path d="M 291 128 C 291 166 229 196 192 208 C 155 220 92 229 69 198 C 46 167 39 83 62 52 C 85 21 162 15 199 27 C 236 39 291 90 291 128" fill="url(#lg-0.5994624562379582)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="33.333333333333336s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-9.523809523809524s" values="M 291 128 C 291 166 229 196 192 208 C 155 220 92 229 69 198 C 46 167 39 83 62 52 C 85 21 162 15 199 27 C 236 39 291 90 291 128;M 240 128 C 240 151 206 176 184 183 C 162 190 112 194 99 176 C 86 158 98 106 111 88 C 124 70 163 61 185 68 C 207 75 240 105 240 128;M 277 128 C 277 161 224 198 192 208 C 160 218 90 224 70 197 C 50 170 48 83 68 56 C 88 29 159 41 191 51 C 223 61 277 95 277 128;M 291 128 C 291 166 229 196 192 208 C 155 220 92 229 69 198 C 46 167 39 83 62 52 C 85 21 162 15 199 27 C 236 39 291 90 291 128"></animate>
            </path><path d="M 251 128 C 251 154 212 183 187 191 C 162 199 119 195 103 174 C 87 153 78 96 93 75 C 108 54 165 45 190 53 C 215 61 251 102 251 128" fill="url(#lg-0.5994624562379582)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="33.333333333333336s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-9.523809523809524s" values="M 251 128 C 251 154 212 183 187 191 C 162 199 119 195 103 174 C 87 153 78 96 93 75 C 108 54 165 45 190 53 C 215 61 251 102 251 128;M 267 128 C 267 157 217 189 189 198 C 161 207 103 209 86 186 C 69 163 69 92 86 69 C 103 46 159 53 187 62 C 215 71 267 99 267 128;M 270 128 C 270 157 218 196 191 205 C 164 214 107 205 90 182 C 73 159 65 89 82 66 C 99 43 164 40 191 49 C 218 58 270 99 270 128;M 251 128 C 251 154 212 183 187 191 C 162 199 119 195 103 174 C 87 153 78 96 93 75 C 108 54 165 45 190 53 C 215 61 251 102 251 128"></animate>
            </path></g>
            </svg>
        </div>
        <div class="coso coso7">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:rgba(241, 242, 243, 0);display:block;z-index:1;position:relative" width="659" height="492" preserveAspectRatio="xMidYMid" viewBox="0 0 659 492">
            <g transform="translate(329.5,246) scale(1,1) translate(-329.5,-246)"><linearGradient id="lg-0.2212741192481451" x1="0" x2="1" y1="0" y2="0">
              <stop stop-color="var(--svgColor1)" offset="0"></stop>
              <stop stop-color="var(--svgColor2)" offset="1"></stop>
            </linearGradient><path d="M 524 246 C 524 286 482 372 450 397 C 418 422 336 395 297 386 C 258 377 161 371 144 335 C 127 299 154 206 172 170 C 190 134 264 138 303 129 C 342 120 403 89 435 114 C 467 139 524 206 524 246" fill="url(#lg-0.2212741192481451)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="14.285714285714286s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-7.142857142857143s" values="M 524 246 C 524 286 482 372 450 397 C 418 422 336 395 297 386 C 258 377 161 371 144 335 C 127 299 154 206 172 170 C 190 134 264 138 303 129 C 342 120 403 89 435 114 C 467 139 524 206 524 246;M 578 246 C 578 296 513 396 474 427 C 435 458 338 434 289 423 C 240 412 132 397 110 352 C 88 307 118 200 140 155 C 162 110 238 69 287 58 C 336 47 407 69 446 100 C 485 131 578 196 578 246;M 536 246 C 536 284 457 346 427 369 C 397 392 332 404 295 395 C 258 386 182 359 166 325 C 150 291 160 206 176 172 C 192 138 262 122 299 114 C 336 106 409 86 438 110 C 467 134 536 208 536 246;M 524 246 C 524 286 482 372 450 397 C 418 422 336 395 297 386 C 258 377 161 371 144 335 C 127 299 154 206 172 170 C 190 134 264 138 303 129 C 342 120 403 89 435 114 C 467 139 524 206 524 246"></animate>
            </path><path d="M 550 246 C 550 288 466 349 433 375 C 400 401 339 391 298 382 C 257 373 174 368 156 330 C 138 292 149 206 167 168 C 185 130 255 110 296 101 C 337 92 402 87 435 113 C 468 139 550 204 550 246" fill="url(#lg-0.2212741192481451)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="14.285714285714286s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-7.142857142857143s" values="M 550 246 C 550 288 466 349 433 375 C 400 401 339 391 298 382 C 257 373 174 368 156 330 C 138 292 149 206 167 168 C 185 130 255 110 296 101 C 337 92 402 87 435 113 C 468 139 550 204 550 246;M 650 246 C 650 304 518 389 473 425 C 428 461 334 488 277 475 C 220 462 82 430 57 377 C 32 324 33 168 58 115 C 83 62 221 31 278 18 C 335 5 444 9 490 45 C 536 81 650 188 650 246;M 549 246 C 549 292 501 388 465 416 C 429 444 339 408 295 398 C 251 388 173 372 153 331 C 133 290 105 189 125 148 C 145 107 246 85 290 75 C 334 65 401 83 437 112 C 473 141 549 200 549 246;M 550 246 C 550 288 466 349 433 375 C 400 401 339 391 298 382 C 257 373 174 368 156 330 C 138 292 149 206 167 168 C 185 130 255 110 296 101 C 337 92 402 87 435 113 C 468 139 550 204 550 246"></animate>
            </path><path d="M 516 246 C 516 287 456 338 424 364 C 392 390 333 413 293 404 C 253 395 157 375 139 338 C 121 301 122 192 140 155 C 158 118 260 127 300 118 C 340 109 415 72 447 98 C 479 124 516 205 516 246" fill="url(#lg-0.2212741192481451)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="14.285714285714286s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-7.142857142857143s" values="M 516 246 C 516 287 456 338 424 364 C 392 390 333 413 293 404 C 253 395 157 375 139 338 C 121 301 122 192 140 155 C 158 118 260 127 300 118 C 340 109 415 72 447 98 C 479 124 516 205 516 246;M 640 246 C 640 308 541 411 492 450 C 443 489 345 458 284 444 C 223 430 55 447 28 391 C 1 335 16 164 43 108 C 70 52 221 52 282 38 C 343 24 423 28 472 67 C 521 106 640 184 640 246;M 613 246 C 613 308 530 398 482 437 C 434 476 340 475 280 461 C 220 447 105 423 78 367 C 51 311 18 165 45 109 C 72 53 216 26 276 12 C 336 -2 429 22 477 61 C 525 100 613 184 613 246;M 516 246 C 516 287 456 338 424 364 C 392 390 333 413 293 404 C 253 395 157 375 139 338 C 121 301 122 192 140 155 C 158 118 260 127 300 118 C 340 109 415 72 447 98 C 479 124 516 205 516 246"></animate>
            </path><path d="M 559 246 C 559 290 493 381 459 408 C 425 435 337 411 294 401 C 251 391 159 377 140 337 C 121 297 131 200 150 160 C 169 120 251 102 294 92 C 337 82 406 81 440 108 C 474 135 559 202 559 246" fill="url(#lg-0.2212741192481451)" opacity="0.41000000000000003">
              <animate attributeName="d" dur="14.285714285714286s" repeatCount="indefinite" keyTimes="0;0.3333333333333333;0.6666666666666666;1" calcmod="spline" keySplines="0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9;0.3 0.1 0.7 0.9" begin="-7.142857142857143s" values="M 559 246 C 559 290 493 381 459 408 C 425 435 337 411 294 401 C 251 391 159 377 140 337 C 121 297 131 200 150 160 C 169 120 251 102 294 92 C 337 82 406 81 440 108 C 474 135 559 202 559 246;M 525 246 C 525 287 479 368 447 393 C 415 418 335 408 295 399 C 255 390 195 356 177 319 C 159 282 126 193 144 156 C 162 119 260 124 300 115 C 340 106 395 99 427 124 C 459 149 525 205 525 246;M 594 246 C 594 298 503 379 462 412 C 421 445 346 410 295 398 C 244 386 147 392 124 345 C 101 298 75 182 98 135 C 121 88 236 69 287 58 C 338 47 427 40 468 72 C 509 104 594 194 594 246;M 559 246 C 559 290 493 381 459 408 C 425 435 337 411 294 401 C 251 391 159 377 140 337 C 121 297 131 200 150 160 C 169 120 251 102 294 92 C 337 82 406 81 440 108 C 474 135 559 202 559 246"></animate>
            </path></g>
            </svg>
        </div>
    </div>
</div> 
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

                    <a href="#" id="btn-cerrar-popup" class="btn-cerrarPop2 btn-glass">Ver resultados</a>
                </form>
            </div>
        </div>
</body>
</html>