@include('template.header')
    <link rel="stylesheet" href="{!! asset ('css/aboutus/aboutus.css') !!}">
    <title>About Us</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class="about-us">
    <form action='{{url('login')}}' method='get'>
        <button class="btn btn-secondary">Login</button>
    </form>
    <header></header>
    <main>
        <div class="region region1">
            <div class="content-region">
                <div class="presentacion">
                    <div class="content-presentacion">
                        <h1>Nuestro equipo</h1>
                        <div class="alineacion">
                            <div class="carta carta1" data-aos="zoom-in-up">
                                <div class="content-carta">
                                    <img class="img-carta" src="{!! asset ('media/aboutus/img-aboutus/gifdavid.gif') !!}" alt="" srcset="">
                                    <h3>David Álvarez Rodríguez</h3>
                                    <h4>Departamento de Frontend</h4>
                                    <img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/fire/fire-dynamic-gradient.png') !!}" alt="" srcset=""><img class="icono-carta" src="{!! asset('media/3Dicons-dinamicos/icons/png/flash/flash-dynamic-gradient.png') !!}" alt="" srcset="">
                                </div>
                            </div>
                            <div class="carta carta2" data-aos="zoom-in-up">
                                <div class="content-carta">
                                    <img class="img-carta" src="{!! asset ('media/aboutus/img-aboutus/gifmarc.gif') !!}" alt="" srcset="">
                                    <h3>Marc Ortiz García</h3>
                                    <h4>Departamento de Frontend</h4>
                                    <img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/rocket/rocket-dynamic-gradient.png') !!}" alt="" srcset=""><img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/painting-brush/paint-brush-dynamic-gradient.png') !!}" alt="" srcset="">
                                </div>
                            </div>
                            <div class="carta carta3" data-aos="zoom-in-up">
                                <div class="content-carta">
                                    <img class="img-carta" src="{!! asset ('media/aboutus/img-aboutus/gifmiguel.gif') !!}" alt="" srcset="">
                                    <h3>Isaac Ortiz Moncusí </h3>
                                    <h4>Departamento de Frontend</h4>
                                    <img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/crown/crown-dynamic-gradient.png') !!}" alt="" srcset=""><img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/magic-trick/magic-trick-dynamic-gradient.png') !!}" alt="" srcset="">
                                </div>
                            </div>
                            <div class="carta carta4" data-aos="zoom-in-up">
                                <div class="content-carta">
                                    <img class="img-carta" src="{!! asset ('media/aboutus/img-aboutus/gifraul.gif') !!}" alt="" srcset="">
                                    <h3>Raúl Santacruz Cela</h3> 
                                    <h4>Departamento de Backend</h4>
                                    <img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/key/key-dynamic-gradient.png') !!}" alt="" srcset=""><img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/medal/medal-dynamic-gradient.png') !!}" alt="" srcset="">
                                </div>
                            </div>
                            <div class="carta carta5" data-aos="zoom-in-up">
                                <div class="content-carta">
                                    <img class="img-carta" src="{!! asset ('media/aboutus/img-aboutus/gifmiguel.gif') !!}" alt="" srcset="">
                                    <h3>Miguel Gras Garrido</h3>
                                    <h4>Departamento de Backend</h4>
                                    <img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/bulb/bulb-dynamic-gradient.png') !!}" alt="" srcset=""><img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/shield/sheild-dynamic-gradient.png') !!}" alt="" srcset="">
                                </div>
                            </div>
                            <div class="carta carta6" data-aos="zoom-in-up">
                                <div class="content-carta">
                                    <img class="img-carta" src="{!! asset ('media/aboutus/img-aboutus/gifxavi.gif') !!}" alt="" srcset="">
                                    <h3>Xavi Gómez Gallego</h3>  
                                    <h4>Departamento de Backend</h4>
                                    <img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/calculator/calculator-dynamic-gradient.png') !!}" alt="" srcset=""><img class="icono-carta" src="{!! asset ('media/3Dicons-dinamicos/icons/png/gym/gym-dynamic-gradient.png') !!}" alt="" srcset="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="region region2">
            <div class="content-region">
                <h1>Más información</h2>
                <div class="explicacion">
                    <div class="content-explicacion">
                        <div class="preguntas">
                                <div class="carta-explicacion carta1" data-aos="fade-up">
                                    <div class="content-carta">
                                        <h3>¿QUIENES SOMOS?</h3>
                                        <h4>Somos 6 estudiantes de Desarrollo de Aplicaciones Web. El equipo está compuesto por 2 departamentos. Departamento de Frontend, formado por David Álvarez, Isaac Ortiz y Marc Ortiz.
                                        Y departamento de Backend, formado por Xavi Gómez, Miguel Gras y Raúl Santacruz. Unidos hemos creado NoteHub.
                                    </div>
                                </div>
                                <div class="carta-explicacion carta2" data-aos="fade-up">
                                    <div class="content-carta">
                                        <h3>¿POR QUÉ HEMOS CREADO ESTA WEB?</h3>
                                        <h4>Hemos creado esta web porque creemos que se necesitan más herramientas que ayuden a los estudiantes de todos los cursos. 
                                            Tener apuntes es una cosa básica, necesaria y algo que debería tener acceso cualquier persona. Este equipo ha intentado centralizar todo la información posible 
                                            que nos proporcionan los diferentes estudiantes de toda España.
                                        </h4>
                                    </div>
                                </div>
                                <div class="carta-explicacion carta3" data-aos="fade-up">
                                    <div class="content-carta">
                                        <h3>¿CUAL ES NUESTRO OBJETIVO?</h3>
                                        <h4>Nuestro objetivo actualmente es hacer un sitio web donde puedas subir, previsualizar y descargar todo tipo de apuntes. Además, a medida que pasa el tiempo intentamos implementar nuevas características que mejorarán y rellenarán de contenido nuestra web, todo esto junto con una interfaz de usuario simple, visualmente atractiva y moderna.
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </main>
    @include('template.footer') 
</body>
<script>
    AOS.init();
</script>
</html>
