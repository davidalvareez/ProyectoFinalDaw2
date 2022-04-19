@include('template.header')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{!!asset('css/index/index.css')!!}">
    <title>NoteHub</title>
</head>
<body class="landing-page">
    <main>
        <div class="region-portada">
            <div class="content-region">
                <div class="content-video">
                    <img class="imagen-difuminada" src="{!!asset('css/index/fotos/Logo1.jpg')!!}" alt="" srcset="">
                </div>
                <div class="absglassportada">
                    <div class="content-absglass">
                        <div class="introduccion-content-absglass">
                            <h2>¿xdEres nuevo/a? ¡Desliza para abajo e infórmate sobre lo que NoteHub te proporciona!</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="region region1" >
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="crearcuenta-content-glassland">
                            <img src="media/3Dicons-dinamicos/icons/png/thumb-up\thumb-up-dynamic-gradient.png" width="80px" height="80px"> 
                            <h2>¡Crea una cuenta para poder disfrutar de todas las características que NoteHub te proporciona!</h2>
                            <h4>Comparte archivos, comenta, opina y puntúa los demás apuntes para poder convertirte en VIP para disfrutar de muchas más funcionalidades extra.</h4>
                        </div>
                    </div>
                </div>
                <div class="absglass absglass1">
                    <div class="content-absglass">
                        <div class="crearcuenta-content-absglass">
                            <h2>¡Únete a nuestra comunidad para conseguir apuntes!</h2>
                            <div class="iconoanimacion">
                                <img class="animationbounce" src="media/3Dicons-dinamicos/icons/png/copy/copy-dynamic-gradient.png" width="90px" height="90px">
                            </div>
                            <button class="crearcuenta-btn-absglass" onclick="window.location.href='{{url('register')}}'">Crear cuenta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="region region2" >
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="iniciarsesion-content-glassland">
                            <img src="media/3Dicons-dinamicos/icons/png/explorer/explorer-dynamic-gradient.png" width="80px" height="80px"> 
                            <h2>¡Consulta apuntes de la Universidad, Formación Profesional o Bachillerato!</h2>
                            <h4>Filtra por aquello que estés buscando, matemáticas, física, química, historia, tecnología, medicina, lenguas, arte, programación... tienes un sinfín de cursos y asignaturas.</h4>
                        </div>
                    </div>
                </div>
                <div class="absglass absglass2">
                    <div class="content-absglass">
                        <div class="iniciarsesion-content-absglass">
                            <h2>¡Inicia sesión para consultar apuntes de los usuarios!</h2>
                            <div class="iconoanimacion">
                                <img class="animationbounce" src="media/3Dicons-dinamicos/icons/png/computer/computer-dynamic-gradient.png" width="90px" height="90px">
                            </div>
                            <button class="iniciarsesion-btn-absglass" onclick="window.location.href='{{url('login')}}'">Iniciar sesión</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="region region3" >
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="subirapuntes-content-glassland">
                            <img src="media/3Dicons-dinamicos/icons/png/notebook/notebook-dynamic-gradient.png" width="90px" height="90px">
                            <h2>¡Sube tus apuntes para ayudar a otros estudiantes que se encuentran en la misma situación!</h2>
                            <h4>Podrás compartir tus apuntes con toda la comunidad de estudiantes de España.</h4>
                        </div>
                    </div>
                </div>
                <div class="absglass absglass3">
                    <div class="content-absglass">
                        <div class="subirapuntes-content-absglass">
                            <h2>¡Comparte tus archivos con la comunidad!</h2>
                            <div class="iconoanimacion">
                                <img class="animationbounce" src="media/3Dicons-dinamicos/icons/png/folder-new/new-folder-dynamic-gradient.png" width="90px" height="90px">
                            </div>
                            <button class="subirapuntes-btn-absglass" onclick="window.location.href='{{url('misApuntes')}}'">Subir archivos</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="region region4" >
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="sabermas-content-glassland">
                            <img src="media/3Dicons-dinamicos/icons/png/plus/plus-dynamic-gradient.png" width="80px" height="80px"> 
                            <h2>¿Quieres saber más sobre nosotros?</h2>
                            <h4>¿Quienes somos? ¿Que departamentos tenemos? ¿Por qué hemos creado esta web? ¿Cual es nuestro objetivo?.</h4>
                        </div>
                    </div>
                </div>
                <div class="absglass absglass4">
                    <div class="content-absglass">
                        <div class="sabermas-content-absglass">
                            <h2>¡Descúbrelo todo aquí!</h2>
                            <div class="iconoanimacion">
                                <img class="animationbounce" src="media/3Dicons-dinamicos/icons/png/zoom/zoom-dynamic-gradient.png" width="90px" height="90px">
                            </div>
                            <button class="sabermas-btn-absglass" onclick="window.location.href='{{url('register')}}'">Mas información</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

@include('template.footer')