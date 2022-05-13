@include('template.header')
    <script src="../public/js/registro/registro.js"></script>
    <link rel="stylesheet" href="{!! asset ('css/registro/loginregistro.css')!!}">
    <link rel="stylesheet" href="{!! asset ('css/registro/styles.css')!!}">
    <title>Register</title>
</head>

<body class="registro-page">
    <header>
    </header>
    <main> 
        
        <div id="myModal2" class="modal2">
            <div class="modal-content2">
                <div class="cards">
                  <h1 class="titulo">SELECCIONA TU PERFIL</h1>
                  <div class="card">
                    <div class="card__image-holder">
                      <img class="card__image" src="./img/alumno.jpg"/>
                    </div>
                    <div class="card-title">
                      <a href="#" class="toggle-info btn">
                        <span class="left"></span>
                        <span class="right"></span>
                      </a>
                      <h2>
                          Alumno
                      </h2>
                    </div>
                    <div class="card-flap flap1">
                      <div class="card-description">
                          <p>Visualiza, comparte, comenta y descarga apuntes de la comunidad de estudiantes de NoteHub. Además tendras acceso a profesores con los que podrás tener clases particulares</p>
                      </div>
                      <div class="card-flap flap2">
                        <div class="card-actions">
                        <button class="btn-glass" onclick="closeModalSeleccion(3);">Seleccionar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card__image-holder">
                      <img class="card__image" src="./img/profesor.jpg"/>
                    </div>
                    <div class="card-title">
                      <a href="#" class="toggle-info btn">
                        <span class="left"></span>
                        <span class="right"></span>
                      </a>
                      <h2>
                          Profesor
                      </h2>
                    </div>
                    <div class="card-flap flap1">
                      <div class="card-description">
                          <p>Imparte clases a la comunidad de estudiantes de NoteHub. Sube tus apuntes y date a conocer dentro de nuestra comunidad</p>
                          <p>Una vez completado el registro, nuestro equipo validará tu propuesta de ser un profesor y te habilitará la cuenta.</p>
                      </div>
                      <div class="card-flap flap2">
                        <div class="card-actions">
                          <button class="btn-glass" onclick="modalProfe();closeModalSeleccion(4);">Seleccionar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="redes-sociales">
                    <div class="alienar-2">
                        <h4>o comienza a regístrarte con:</h4>
                    </div>
                    <div class="botones-distributed">
                        <div class="botones-right">
                            <a onclick="{{url('login-facebook')}}"><img src="{!! asset ('media/loginregister/facebook.png') !!}" alt="facebook" class="icono-socialmedia"></a>
                            <a onclick="{{url('login-twitter')}}"><img src="{!! asset ('media/loginregister/twitter.png') !!}" alt="twitter" class="icono-socialmedia"></a>
                            <a onclick="{{url('login-google')}}"><img src="{!! asset ('media/loginregister/google.png') !!}" alt="google" class="icono-socialmedia"></a>
                        </div>
                    </div>
                </div>
                </div>
              </div>
        </div>
        <div class="region region1">
            <div class="content-region">
                <div class="glassland">
                    <div class="content-glassland">
                        <div class="registro-content-glassland">
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal();">&times;</span>
                                    <br><br>
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
                                    <input type="file" name="img_avatar_usu" id="img_avatar_usu" onchange="deselectAvatar();">
                                    <br><br>
                                    <button onclick="closeModal2();return false;" class="aceptarbtn" value="Aceptar">Aceptar</button>
                                </div>
                            </div>
                            <img src="{!! asset ('media/3Dicons-dinamicos/icons/png/boy\boy-dynamic-gradient.png') !!}" width="80px" height="80px">
                            <h2>¡Regístrate y accede a todas las ventajas de NoteHub!</h2>
                            <br>
                            
                            <form action="{{url('register')}}" class="formulario-grid" id="idRegister" onsubmit="return hasAvatarOrImage();" method="post" enctype="multipart/form-data">
                                
                                @csrf

                                <div class="menudos">
                                    <h4 class="pizq">Nombre</h4>
                                    <div>
                                        <input class="inputbtn" type="text" name="nombre_usu" id="nombre_usu" placeholder="Nombre">
                                    </div>
                                    <div>
                                        @error('nombre_usu')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                                                
                                <div class="menudos">
                                    <h4 class="pizq">Apellido</h4>
                                    <div>
                                        <input class="inputbtn" type="text" name="apellido_usu" id="apellido_usu" placeholder="Apellido">
                                    </div>
                                    <div>
                                        @error('apellido_usu')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                                                
                                <div class="menudos">
                                    <h4 class="pizq">Nickname</h4>
                                    <div>
                                        <input class="inputbtn" type="text" name="nick_usu" id="nick_usu" placeholder="Nickname">
                                    </div>
                                    <div>
                                        
                                        @error('nick_usu')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                                                
                                <div class="menudos">
                                    <h4 class="pizq">Fecha de nacimiento</h4>
                                    <div>
                                        <input class="inputbtn" type="date" name="fecha_nac_usu" id="fecha_nac_usu">
                                    </div>
                                    <div>
                                        @error('fecha_nac_usu')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                                                
                                <div class="menudos">
                                    <h4 class="pizq">Centro</h4>
                                    <div>
                                        <input class="inputbtn" autocomplete="off" list="browsers" name="centro" id="centro" placeholder="Seleccionar centro" >
                                        <datalist id="browsers">
                                            @foreach($centros as $centro)
                                                <option value="{{$centro->nombre_centro}}">{{$centro->nombre_centro}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div>
                                        @error('centro')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                    <div>
                                        <div style="float: left">
                                            <a href="mailto:notehubdaw2@gmail.com?subject=Petición de centro&body=(INSERTE NOMBRE DEL CENTRO) no se encuentra en el selector de centros.">
                                                <p>No encuentras tu centro?</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                                                
                                <div class="menudos">
                                    <h4 class="pizq">Email</h4>
                                    <div>
                                        <input class="inputbtn" type="email" name="correo_usu" id="correo_usu" placeholder="Email">
                                    </div>
                                    <div>
                                        @error('correo_usu')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                                                
                                <div class="menudos">
                                    <h4 class="pizq">Contraseña</h4>
                                    <div>
                                        <input class="inputbtn" type="password" name="contra_usu" id="contra_usu" placeholder="Contraseña">
                                    </div>
                                    <div>
                                        @error('contra_usu')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                                                
                                <div class="menudos">
                                    <h4 class="pizq">Repetir contraseña</h4>
                                    <div>
                                        <input class="inputbtn" type="password" name="contra_usu_verify" id="contra_usu_verify" placeholder="Repetir contraseña">
                                    </div>
                                    <div>
                                        @error('contra_usu_verify')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                                                
                                <div class="menuuno">
                                    <h4 class="pizq">Avatar</h4>
                                    <div>
                                        <input class="inputbtn-selec" id="clickselec" type="submit" onclick="modalbox();return false;" value="CLICK PARA SELECCIONAR AVATAR">
                                        <input type="hidden" name="img_avatar_sistema" id="img_avatar_sistema" value="">
                                        <input type="file" name="img_avatar_usu2" id="img_avatar_usu2" value="">
                                        <input type="hidden" name="tipo_usuario" id="tipo_usuario2" value="">
                                    </div>
                                </div>

                                <div class="menuuno">
                                    <input class="login-btn-absglass" type="submit" value="ENTRAR"></input>
                                </div>
                                <div class="">
                                    <div class="alienarleft">
                                        <p>Ya estás registrado?</p>
                                    </div>
                                    <div class="alienarleft">
                                        <a href="{{url('login')}}">
                                            <p>Inicia sesión</p>
                                        </a>
                                    </div>
                                </div>
                            </form>
{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

<form action="{{url('registerProfe')}}" class="formulario-grid" id="idRegister2" onsubmit="return hasAvatarOrImage();" method="post" enctype="multipart/form-data">
                                
    @csrf
                                <div class="menudos">
                                    <h4 class="pizq">Nombre</h4>
                                    <div>
                                        <input class="inputbtn" type="text" name="nombre_profe" id="nombre_profe" placeholder="Nombre">
                                    </div>
                                    <div>
                                        @error('nombre_profe')
                                        <script>
                                            alertify.error("Falta nombre");
                                        </script>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                    
                                <div class="menudos">
                                    <h4 class="pizq">Apellido</h4>
                                    <div>
                                        <input class="inputbtn" type="text" name="apellido_profe" id="apellido_profe" placeholder="Apellido">
                                    </div>
                                    <div>
                                        @error('apellido_profe')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="menudos">
                                    <h4 class="pizq">Nickname</h4>
                                    <div>
                                        <input class="inputbtn" type="text" name="nick_usu" id="nick_usu" placeholder="Nickname">
                                    </div>
                                    {{-- <div>
                                        @error('nick_usu')
                                        <script>
                                            alertify.error("Falta nickname");
                                        </script>
                                        {{-- <p class="errortext">{{$message}}</p>
                                        @enderror
                                    </div> --}}
                                </div>
                                
                                <div class="menudos">
                                    <h4 class="pizq">Fecha de nacimiento</h4>
                                    <div>
                                        <input class="inputbtn" type="date" name="fecha_nac_profe" id="fecha_nac_profe">
                                    </div>
                                    <div>
                                        @error('fecha_nac_profe')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="menudos">
                                    <h4 class="pizq">Centro</h4>
                                    <div>
                                        <input class="inputbtn" autocomplete="off" list="browsers" name="centro" id="centro" placeholder="Seleccionar centro" >
                                        <datalist id="browsers">
                                            @foreach($centros as $centro)
                                                <option value="{{$centro->nombre_centro}}">{{$centro->nombre_centro}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    {{-- <div>
                                        @error('centro')
                                        <script>
                                            alertify.error("Falta centro");
                                        </script>
                                        {{-- <p class="errortext">{{$message}}</p>
                                        @enderror
                                    </div> --}}
                                    <div>
                                        <div style="float: left">
                                            <a href="mailto:notehubdaw2@gmail.com?subject=Petición de centro&body=(INSERTE NOMBRE DEL CENTRO) no se encuentra en el selector de centros.">
                                                <p>No encuentras tu centro?</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="menudos">
                                    <h4 class="pizq">Email</h4>
                                    <div>
                                        <input class="inputbtn" type="email" name="correo_usu" id="correo_usu" placeholder="Email">
                                    </div>
                                    {{-- <div>
                                        @error('correo_usu')
                                        <script>
                                            alertify.error("Falta email");
                                        </script>
                                        {{-- <p class="errortext">{{$message}}</p>
                                        @enderror
                                    </div> --}}
                                </div>
                                
                                <div class="menudos">
                                    <h4 class="pizq">Contraseña</h4>
                                    <div>
                                        <input class="inputbtn" type="password" name="contra_profe" id="contra_profe" placeholder="Contraseña">
                                    </div>
                                    <div>
                                        @error('contra_profe')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="menudos">
                                    <h4 class="pizq">Repetir contraseña</h4>
                                    <div>
                                        <input class="inputbtn" type="password" name="contra_profe_verify" id="contra_profe_verify" placeholder="Repetir contraseña">
                                    </div>
                                    <div>
                                        @error('contra_profe_verify')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="menuuno">
                                    <h4 class="pizq">Avatar</h4>
                                    <div>
                                        <input class="inputbtn-selec" id="clickselec" type="submit" onclick="modalbox();return false;" value="CLICK PARA SELECCIONAR AVATAR">
                                        <input type="hidden" name="img_avatar_sistema" id="img_avatar_sistema_profe" value="">
                                        <input type="file" onchange="deselectAvatar();" name="img_avatar_usu2" id="img_avatar_usu_profe" value="">
                                    </div>
                                    <div>
                                        @error('img_avatar_usu')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                        @error('img_avatar_usu2')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>

                                <div class="menuuno">
                                    <h4 class="pizq">Curriculum</h4>
                                    <div>
                                        <input type="hidden" name="curriculum_profe" id="curriculum_profe" value="">
                                        <input type="file" name="curriculum_profe2" id="curriculum_profe2" value="">
                                        <input type="hidden" name="tipo_usuario" id="tipo_usuario2" value="4">
                                    </div>
                                    <div>
                                        @error('curriculum_profe2')
                                        <?php
                                        //echo $message;
                                        
                                        echo "<script>";
                                        echo    "alertify.error('".$message."')";
                                        echo "</script>";
                                        
                                        ?>
                                        {{-- <p class="errortext">{{$message}}</p> --}}
                                        @enderror
                                    </div>
                                </div>
                                <!-- <div class="alienarright">
                                    <a href="">
                                        <p>Contraseña olvidada?</p>
                                    </a>
                                </div> -->
                                <div class="menuuno">
                                    <input class="login-btn-absglass" type="submit" value="ENTRAR"></input>
                                </div>
                                <div class="">
                                    <div class="alienarleft">
                                        <p>Ya estás registrado?</p>
                                    </div>
                                    <div class="alienarleft">
                                        <a href="{{url('login')}}">
                                            <p>Inicia sesión</p>
                                        </a>
                                    </div>
                                </div>
                            </form>
{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
                        </div>
                    </div>
                </div>
                <div class="imagenrelleno">
                    <img src="{!! asset ('media/loginregister/imagen2.png') !!}" alt="imgregistro" class="imgredondeada2">
                </div>
            </div>
        </div>
    </main>
    @include ('template.footer')
</body>
</html>