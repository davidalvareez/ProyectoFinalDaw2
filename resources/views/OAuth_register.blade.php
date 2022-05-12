@include('template.header')
    <script src="{!! asset ('js/oauth_register/registro.js')!!}"></script>
    <link rel="stylesheet" href="{!! asset ('css/oauth_register/loginregistro.css')!!}">
    <link rel="stylesheet" href="{!! asset ('css/oauth_register/styles.css')!!}">
    <script src="{!! asset ('js/fontawesomePRO.js')!!}"></script>
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
                        <button class="btn-glass" onclick="closeModalSeleccion()">Seleccionar</button>
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
                          <button class="btn-glass" onclick="modalProfe();closeModalSeleccion();">Seleccionar</button>
                        </div>
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
                            <img src="{!! asset ('media/3Dicons-dinamicos/icons/png/boy\boy-dynamic-gradient.png') !!}" width="80px" height="80px">
                            <h2>¡Regístrate y accede a todas las ventajas de NoteHub!</h2>
                            <br>
                            
                            <form action="{{url('oauth-register-alumno')}}" class="formulario-grid" id="idRegister" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="menudos">
                                    <h4 class="pizq">Fecha de nacimiento</h4>
                                    <div>
                                        <input class="inputbtn" type="date" name="fecha_nac_usu" id="fecha_nac_usu">
                                    </div>
                                    <div>
                                        @error('fecha_nac_usu')
                                        <p class="errortext">{{$message}}</p>
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
                                        <p class="errortext">{{$message}}</p>
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
                                    <h4 class="pizq">Contraseña</h4>
                                    <div>
                                        <input class="inputbtn" type="password" name="contra_usu" id="contra_usu" placeholder="Contraseña">
                                    </div>
                                    <div>
                                        @error('contra_usu')
                                        <p class="errortext">{{$message}}</p>
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
                                        <p class="errortext">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- <div class="alienarright">
                                    <a href="">
                                        <p>Contraseña olvidada?</p>
                                    </a>
                                </div> -->
                                <div class="menuuno">
                                    <input type="hidden" name="id_rol" value="3">
                                    <input type="hidden" name="id" value="{{$id}}">
                                    <input class="login-btn-absglass" type="submit" value="ENTRAR"></input>
                                </div>
                            </form>
{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
                            <form action="{{url('oauth-register-profesor')}}" class="formulario-grid" id="idRegister2" method="post" enctype="multipart/form-data">                       
                                @csrf
                                <div class="menudos">
                                    <h4 class="pizq">Fecha de nacimiento</h4>
                                    <div>
                                        <input class="inputbtn" type="date" name="fecha_nac_usu" id="fecha_nac_usu">
                                    </div>
                                    <div>
                                        @error('fecha_nac_usu')
                                        <p class="errortext">{{$message}}</p>
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
                                        <p class="errortext">{{$message}}</p>
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
                                    <h4 class="pizq">Contraseña</h4>
                                    <div>
                                        <input class="inputbtn" type="password" name="contra_usu" id="contra_usu" placeholder="Contraseña">
                                    </div>
                                    <div>
                                        @error('contra_usu')
                                        <p class="errortext">{{$message}}</p>
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
                                        <p class="errortext">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="menuuno">
                                    <h4 class="pizq">Curriculum</h4>
                                    <div>
                                        <input type="hidden" name="curriculum_profe" id="curriculum_profe" value="">
                                        <input type="file" name="curriculum_profe2" id="curriculum_profe2" value="">
                                    </div>
                                </div>
                                <!-- <div class="alienarright">
                                    <a href="">
                                        <p>Contraseña olvidada?</p>
                                    </a>
                                </div> -->
                                <div class="menuuno">
                                    <input type="hidden" name="id_rol" value="4">
                                    <input type="hidden" name="id" value="{{$id}}">
                                    <input class="login-btn-absglass" type="submit" value="ENTRAR"></input>
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
