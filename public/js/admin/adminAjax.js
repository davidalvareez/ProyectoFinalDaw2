window.onload = function() {
    content = document.getElementById('content');
    token = document.getElementById('token').getAttribute("content")
    input_container = document.getElementById("filter");
    //widthpantalla = window.innerWidth;
}

function llamadaAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

//Mostrar
/*Mostrar usuarios*/
function getInputUsers() {
    let input = `<input type="search" id="search" name="titulo" class="form-control" placeholder="Buscar por nickname..." aria-label="Search" onkeyup="showUsers(); return false;"/>`
    input_container.innerHTML = input;
}

function getInputCentros() {
    let input = `<input type="search" id="search" name="titulo" class="form-control" placeholder="Buscar por nombre de centro o ciudad..." aria-label="Search" onkeyup="showCentros(); return false;"/>`
    input_container.innerHTML = input;
}

function getInputApuntes() {
    let input = `<input type="search" id="search" name="titulo" class="form-control" placeholder="Buscar por apunte..." aria-label="Search" onkeyup="showApuntes(); return false;"/>`
    input_container.innerHTML = input;
}

function getInputCursos(idCentro) {
    let input = `<input type="search" id="search" name="titulo" class="form-control" placeholder="Buscar por curso..." aria-label="Search" onkeyup="showCursos(${idCentro}); return false;"/>`
    input_container.innerHTML = input;
}

function getInputAsignatura(idCurso, idCentro) {
    let input = `<input type="search" id="search" name="titulo" class="form-control" placeholder="Buscar por asignatura..." aria-label="Search" onkeyup="showAsignaturas(${idCurso},${idCentro}); return false;"/>`
    input_container.innerHTML = input;
}

function getInputTema(idAsignatura, idCurso, idCentro) {
    let input = `<input type="search" id="search" name="titulo" class="form-control" placeholder="Buscar por tema..." aria-label="Search" onkeyup="showTemas(${idAsignatura},${idCurso},${idCentro}); return false;"/>`
    input_container.innerHTML = input;
}

function getInputDenuncias() {
    let input = `<div style="padding: 17px"></div>`
    input_container.innerHTML = input;
}

function getInputHistorial() {
    let input = `<div style="padding: 17px"></div>`
    input_container.innerHTML = input;
}

function showUsers() {
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    /* 
        Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
        var token = document.getElementById('token').getAttribute("content");
        
        
        Usar el objeto FormData para guardar los parámetros que se enviarán:
        var formData = new FormData();
        formData.append('_token', token);
        formData.append('clave', valor);
        */
    console.log(document.getElementById('search').value);
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('filter', document.getElementById('search').value);
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */

    ajax.open("POST", "admin/users", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                console.log(respuesta);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                //Encabezado
                let recarga = ``;
                recarga += `<div class="">
                    <div class="table-responsive">             
                    <table class="table table-striped">
                    <th scope="col">#</th>
                    <th scope="col">Nickname</th>
                    <th scope="col">Nombre y Apellido</th>
                    <th scope="col">Fecha nacimiento</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Fecha habilitado</th>
                    <th scope="col">Centro de estudio</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Imagen Avatar</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                    <tr>`;
                //Cuerpoelse
                if (respuesta.length == 0) {
                    recarga += `<h1>No se han encontrado registros...</h1>`
                } else {
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<tr>
                            <td scope="row"><b>${respuesta[i].id}</b></td>
                            <td>${respuesta[i].nick_usu}</td>
                            <td>${respuesta[i].nombre_usu} ${respuesta[i].apellido_usu}</td>
                            <td>${respuesta[i].fecha_nac_usu}</td>
                            <td>${respuesta[i].correo_usu}</td>
                            <td>${respuesta[i].deshabilitado}</td>
                            <td>${respuesta[i].nombre_centro}</td>
                            <td>${respuesta[i].nombre_rol}</td>
                            <td><img class="imgavatar" src="storage/${respuesta[i].img_avatar}"></td>
                            <td>
                            <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalboxUser(${respuesta[i].id},'${respuesta[i].nombre_usu}','${respuesta[i].apellido_usu}','${respuesta[i].nick_usu}','${respuesta[i].fecha_nac_usu}','${respuesta[i].correo_usu}','${respuesta[i].deshabilitado}','${respuesta[i].tmpdeshabilitado}','${respuesta[i].nombre_rol}');return false;">Modificar</button>
                            </td>
                            <td>
                            <button class= "btn btn-danger" type="submit" value="Delete" onclick="swalUsers(${respuesta[i].id});return false;">Eliminar</button>
                            </td>
                            </tr>`
                    }
                    recarga += `</table>
                        </div>
                        </div>`;
                }
                content.innerHTML = recarga;
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/*Mostrar centros*/
function showCentros() {
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    /* 
        Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
        var token = document.getElementById('token').getAttribute("content");
    
    
        Usar el objeto FormData para guardar los parámetros que se enviarán:
        var formData = new FormData();
        formData.append('_token', token);
        formData.append('clave', valor);
        */
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('filter', document.getElementById('search').value);
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/centros", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                centros = respuesta;
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <button style="float: left; margin: 5px;" class="btn btn-warning" type="submit" value="Create" onclick="modalboxCrearCentro();">Crear</button>
                <div class="table-responsive">    
                    <table class="table table-striped">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Comunidad autonoma y Ciudad</th>
                    <th scope="col">Direccion</th>
                    <th scope="col" colspan="3">Acciones</th>
                    </tr>`;
                if (respuesta.length == 0) {
                    recarga += `<h1>No se han encontrado registros...</h1>`
                } else {
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<tr>
                        <td scope="row"><b>${respuesta[i].id}</b></td>
                        <td>${respuesta[i].nombre_centro}</td>
                        <td>${respuesta[i].com_auto_centro}, ${respuesta[i].ciudad_centro}</td>
                        <td>${respuesta[i].direccion_centro}</td>
                        <td>
                        <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalboxCentro(${respuesta[i].id},'${respuesta[i].nombre_centro}','${respuesta[i].pais_centro}','${respuesta[i].com_auto_centro}','${respuesta[i].ciudad_centro}','${respuesta[i].direccion_centro}');return false;">Editar</button>
                        </td>
                        <td>
                        <button class= "btn btn-warning" type="submit" value="Delete" onclick="getInputCursos(${respuesta[i].id});showCursos(${respuesta[i].id});return false;">Ver cursos</button>
                        </td>
                        <td>
                        <button class= "btn btn-danger" type="submit" value="Delete" onclick="swalCentros(${respuesta[i].id});return false;">Eliminar</button>
                        </td>
                        </tr>`
                    }
                    recarga += `</table>
                        </div>
                        </div>`;
                }
                content.innerHTML = recarga;
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/*Mostrar cursos*/
function showCursos(idCentro) {
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    /* 
            Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
            var token = document.getElementById('token').getAttribute("content");
    
    
            Usar el objeto FormData para guardar los parámetros que se enviarán:
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('clave', valor);
            */
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'GET');
    formData.append('filter', document.getElementById('search').value);
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/cursos/" + idCentro, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <button style="float: left; margin: 5px;" class="btn btn-warning" type="submit" value="Create" onclick="modalboxCrearCurso(${idCentro});">Crear</button>
                <button class="boton-volver" type="submit" value="Edit" onclick="getInputCentros();showCentros();">Voler a centros</button>
                <div class="table-responsive">     
                    <table class="table table-striped">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Nombre corto</th>
                        <th scope="col">Tipo</th>
                        <th scope="col" colspan="3">Acciones</th>
                        </tr>`;
                if (respuesta.length == 0) {
                    recarga += `<h1>No se han encontrado registros...</h1>`
                } else {
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<tr>
                        <td scope="row"><b>${respuesta[i].id}</b></td>
                        <td>${respuesta[i].nombre_curso}</td>
                        <td>${respuesta[i].nombre_corto_curso}</td>
                        <td>${respuesta[i].tipo_curso}</td>
                        <td>
                        <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalboxCurso(${idCentro},${respuesta[i].id},'${respuesta[i].nombre_curso}','${respuesta[i].nombre_corto_curso}','${respuesta[i].tipo_curso}');return false;">Editar</button>
                        </td>
                        <td>
                        <button class= "btn btn-danger" type="submit" value="Delete" onclick="swalCursos(${respuesta[i].id},${idCentro});return false;">Eliminar</button>
                        </td>
                        <td>
                        <button class= "btn btn-warning" type="submit" value="Delete" onclick="getInputAsignatura(${respuesta[i].id}, ${idCentro});showAsignaturas(${respuesta[i].id}, ${idCentro});return false;">Ver asignaturas</button>
                        </td>
                        </tr>`
                    }
                    recarga += `</table>
                        </div>
                        </div>`;
                }
                content.innerHTML = recarga;
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/*Mostrar asignaturas*/
function showAsignaturas(idCurso, idCentro) {
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    /* 
            Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
            var token = document.getElementById('token').getAttribute("content");
    
    
            Usar el objeto FormData para guardar los parámetros que se enviarán:
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('clave', valor);
            */
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'GET');
    formData.append('filter', document.getElementById('search').value);
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/asignaturas/" + idCurso, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <button style="float: left; margin: 5px;" class="btn btn-warning" type="submit" value="Create" onclick="modalboxCrearAsignatura(${idCurso},${idCentro});">Crear</button>
                <button class="boton-volver" type="submit" value="Edit" onclick="getInputCursos(${idCentro});showCursos(${idCentro});">Voler a Cursos</button>
                <div class="table-responsive">             
                    <table class="table table-striped">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col" colspan="3">Acciones</th>
                            </tr>`;
                if (respuesta.length == 0) {
                    recarga += `<h1>No se han encontrado registros...</h1>`
                } else {
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<tr>
                        <td scope="row"><b>${respuesta[i].id}</b></td>
                        <td>${respuesta[i].nombre_asignatura}</td>
                        <td>
                        <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalboxAsignatura(${idCentro},${idCurso},${respuesta[i].id},'${respuesta[i].nombre_asignatura}','${respuesta[i].id_curso}');return false;">Editar</button>
                        </td>
                        <td>
                        <button class= "btn btn-danger" type="submit" value="Delete" onclick="swalAsignaturas(${respuesta[i].id},${idCurso},${idCentro});return false;">Eliminar</button>
                        </td>
                        <td>
                        <button class= "btn btn-warning" type="submit" value="Delete" onclick="getInputTema(${respuesta[i].id}, ${idCurso}, ${idCentro});showTemas(${respuesta[i].id}, ${idCurso}, ${idCentro} );return false;">Ver temas</button>
                        </td>
                        </tr>`
                    }
                    recarga += `</table>
                        </div>
                        </div>`;
                }
                content.innerHTML = recarga;
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/*Mostrar temas*/
function showTemas(idAsignatura, idCurso, idCentro) {
    var message = document.getElementById('message');
    message.innerHTML = '';
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    /* 
            Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
            var token = document.getElementById('token').getAttribute("content");
    
    
            Usar el objeto FormData para guardar los parámetros que se enviarán:
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('clave', valor);
            */
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'GET');
    formData.append('filter', document.getElementById('search').value);
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/temas/" + idAsignatura, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <button style="float: left; margin: 5px;" class="btn btn-warning" type="submit" value="Create" onclick="modalboxCrearTema(${idAsignatura},${idCurso},${idCentro});">Crear</button>
                <button class="boton-volver" type="submit" value="Edit" onclick="getInputAsignatura(${idCurso},${idCentro});showAsignaturas(${idCurso},${idCentro});">Voler a Asignaturas</button>
                <div class="table-responsive">                             
                    <table class="table table-striped">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre tema</th>
                                <th scope="col" colspan="3">Acciones</th>
                                </tr>`;
                if (respuesta.length == 0) {
                    recarga += `<h1>No se han encontrado registros...</h1>`
                } else {
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<tr>
                        <td scope="row"><b>${respuesta[i].id}</b></td>
                        <td>${respuesta[i].nombre_tema}</td>
                        <td>
                        <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalboxTema(${idCentro},${idCurso},${idAsignatura},${respuesta[i].id},'${respuesta[i].nombre_tema}');return false;">Editar</button>
                        </td>
                        <td>
                        <button class= "btn btn-danger" type="submit" value="Delete" onclick="swalTemas(${respuesta[i].id},${idAsignatura}, ${idCurso}, ${idCentro});return false;">Eliminar</button>
                        </td>
                        </tr>`
                    }
                    recarga += `</table>
                        </div>
                        </div>`;
                }
                content.innerHTML = recarga;
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/*Mostrar apuntes*/
function showApuntes() {
    var message = document.getElementById('message');
    message.innerHTML = '';
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    /* 
                Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
                var token = document.getElementById('token').getAttribute("content");
    
    
                Usar el objeto FormData para guardar los parámetros que se enviarán:
                var formData = new FormData();
                formData.append('_token', token);
                formData.append('clave', valor);
                */
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('filter', document.getElementById('search').value);
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/apuntes", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                                <div class="table-responsive">             
                                <table class="table table-striped">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Documento</th>
                                <th scope="col">Fecha Publicacion</th>
                                <th scope="col">Creador</th>
                                <th scope="col">Acciones</th>
                                </tr>`;
                if (respuesta.length == 0) {
                    recarga += `<h1>No se han encontrado registros...</h1>`
                } else {
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<tr>
                        <td scope="row"><b>${respuesta[i].id}</b></td>
                        <td>${respuesta[i].nombre_contenido}${respuesta[i].extension_contenido}</td>
                        <td>${respuesta[i].fecha_publicacion_contenido}</td>
                        <td>${respuesta[i].nombre_usu} ${respuesta[i].apellido_usu}</td>
                        <td>
                        <button class= "btn btn-danger" type="submit" value="Delete" onclick="swalApuntes(${respuesta[i].id});return false;">Eliminar</button>
                        </td>
                        </tr>`
                    }
                    recarga += `</table>
                        </div>
                        </div>`;
                }

                content.innerHTML = recarga;
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/*Mostrar denuncias*/
function showDenuncias() {
    var message = document.getElementById('message');
    message.innerHTML = '';
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    /* 
                Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
                var token = document.getElementById('token').getAttribute("content");
    
    
                Usar el objeto FormData para guardar los parámetros que se enviarán:
                var formData = new FormData();
                formData.append('_token', token);
                formData.append('clave', valor);
                */
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "moderador/denuncias", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                console.log(respuesta);
                recarga = "";
                recarga += `<div class="table-responsive">             
                <table class="table table-striped">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tipo</th>
                <th scope="col">Descripción</th>
                <th scope="col">Acusado</th>
                <th scope="col">Demandante</th>
                <th scope="col" colspan="2">Acciones</th>
            </tr>`;
                if (respuesta.length == 0) {
                    recarga += `<h1>No se han encontrado registros...</h1>`
                } else {
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += ` <tr>
            <td scope="row"><b>${respuesta[i].id}</b></td>
            <td>${respuesta[i].tipus_denuncia}</td>
            <td>${respuesta[i].desc_denuncia}</td>
            <td>${respuesta[i].acusado}</td>
            <td>${respuesta[i].demandante}</td>
            <td><button class="btn btn-secondary" type="submit" value="Edit" onclick="opcionesDenuncia(${respuesta[i].id},'${respuesta[i].nick_acusado}');return false;">Opciones</button></td>
            <td><button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminarDenuncia(${respuesta[i].id},'${respuesta[i].nick_demandante}');return false;">Eliminar</button></td>
        </tr>`;
                    }
                    recarga += `</table>
            </div>`;
                }

                content.innerHTML = recarga;
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}

function opcionesDenuncia(id_denuncia, acusado) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    formData.append('id_denuncia', id_denuncia);
    formData.append('nick_usu', acusado);
    let ajax = llamadaAjax();
    Swal.fire({
        title: "Opciones denuncia",
        text: "¿Que deseas hacer?",
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: "Eliminar contenido",
        denyButtonText: "Banear usuario",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        //Elimina el contenido despues del ajax ejecutamos el swal
        if (result.isConfirmed) {
            ajax.open("POST", "moderador/eliminarcontent", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "OK") {
                        alertify.success("Contenido eliminado correctamente");
                        //Preguntamos si tambien quiere banear al usuario
                        Swal.fire({
                            title: "Opciones denuncia",
                            text: "¿Deseas tambien denunciar al usuario?",
                            showCancelButton: true,
                            confirmButtonText: "Banear usuario",
                            cancelButtonText: "Cancelar"
                        }).then((result) => {
                            //Si quiere denunciar al usuario le mostramos un input en formato fecha ya que cogemos la hora actual del sistema
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "Opciones denuncia",
                                    text: "¿Hasta que día desea banearlo?",
                                    html: `<input type="date" id="fecha_denuncia"/>`,
                                    showCancelButton: true,
                                    confirmButtonText: "Enviar",
                                    cancelButtonText: "Cancelar",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        fechaDenuncia = document.getElementById("fecha_denuncia").value;
                                        formData.append("fecha_denuncia", fechaDenuncia);
                                        ajax.open("POST", "moderador/banearUser", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                let respuesta = JSON.parse(this.responseText);
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("Baneo realizado correctamente");
                                                    showDenuncias();
                                                } else {
                                                    console.log(respuesta.resultado);
                                                }
                                            }
                                        }
                                        ajax.send(formData);
                                    }
                                });
                            } else if (result.isDismissed) {
                                showDenuncias();
                            }
                        });
                    } else {
                        console.log(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
            //Decide banear
        } else if (result.isDenied) {
            Swal.fire({
                title: "Opciones denuncia",
                text: "¿Hasta que día desea banearlo?",
                html: `<input type="date" id="fecha_denuncia"/>`,
                showCancelButton: true,
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    //Ejecutamos ajax para banear
                    fechaDenuncia = document.getElementById("fecha_denuncia").value;
                    formData.append("fecha_denuncia", fechaDenuncia);
                    ajax.open("POST", "moderador/banearUser", true);
                    ajax.onreadystatechange = function() {
                        if (ajax.readyState == 4 && ajax.status == 200) {
                            let respuesta = JSON.parse(this.responseText);
                            if (respuesta.resultado == "OK") {
                                alertify.success("Baneo realizado correctamente");
                                //Preguntamos si tambien quiere eliminar el contenido
                                Swal.fire({
                                    title: "Opciones denuncia",
                                    text: "¿Deseas tambien eliminar el contenido?",
                                    showCancelButton: true,
                                    confirmButtonText: "Eliminar contenido",
                                    cancelButtonText: "Cancelar"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        ajax.open("POST", "moderador/eliminarcontent", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("Contenido eliminado correctamente");
                                                    showDenuncias();
                                                }
                                            } else {
                                                console.log(respuesta.resultado);
                                            }
                                        }
                                        ajax.send(formData);
                                    } else if (result.isDismissed) {
                                        ajax.open("POST", "moderador/quitardenuncia", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("La denuncia se ha quitado");
                                                    showDenuncias();
                                                } else {
                                                    console.log(respuesta.resultado);
                                                }
                                            }
                                        }
                                        ajax.send(formData);
                                    }
                                });
                            } else {
                                console.log(respuesta.resultado);
                            }
                        }
                    }
                    ajax.send(formData);
                    //En caso que cancele ya una vez baneado eliminamos tambien la denuncia
                }
            });
        }
    });
}

function eliminarDenuncia(id_denuncia, demandante) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    formData.append('id_denuncia', id_denuncia);
    formData.append('nick_usu', demandante);
    let ajax = llamadaAjax();
    ajax.open("POST", "moderador/eliminar", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                alertify.success("Denuncia eliminada correctamente");
                showDenuncias();
            } else {
                console.log(respuesta.resultado);
            }
        }
    }
    ajax.send(formData);
}
/*Mostrar historial*/
function showHistorial() {
    var message = document.getElementById('message');
    message.innerHTML = '';
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    /* 
            Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
            var token = document.getElementById('token').getAttribute("content");
        
        
            Usar el objeto FormData para guardar los parámetros que se enviarán:
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('clave', valor);
            */
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/historial", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                                <div class="table-responsive">             
                                    <table class="table table-striped">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre Apuntes</th>
                                    <th scope="col">Nombre Usuario</th>
                                    <th scope="col" colspan="2">Acciones</th>
                                    </tr>`;
                if (respuesta.length == 0) {
                    recarga += `<h1>No se han encontrado registros...</h1>`
                } else {
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<tr>
                        <td scope="row"><b>${respuesta[i].id}</b></td>
                        <td>${respuesta[i].nombre_contenido}</td>
                        <td>${respuesta[i].nombre_usu} ${respuesta[i].apellido_usu}</td>
                        <td>
                        <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Editar</button>
                        </td>
                        <td>
                        <button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminarHistorial(${respuesta[i].id});return false;">Eliminar</button>
                        </td>
                        </tr>`
                    }
                    recarga += `</table>
                        </div>
                        </div>`;
                }

                content.innerHTML = recarga;
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}

//Eliminar
/* EliminarUsers */
function eliminarUsers(user_id) {
    var message = document.getElementById('message');

    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */

    /* 
            Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
            var token = document.getElementById('token').getAttribute("content");
        
            Usar el objeto FormData para guardar los parámetros que se enviarán:
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('clave', valor);
            */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', "DELETE");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/users/" + user_id, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.resultado == "OK") {
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = '<p>Usario eliminado correctamente.</p>';
                    showUsers();

                } else {
                    //    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    message.innerHTML = respuesta.resultado;
                    alertify.error("Ha habido un error");
                    console.log(respuesta)
                }
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/* EliminarHistorial */
function eliminarHistorial(historial_id) {
    var message = document.getElementById('message');
    /* console.log(historial_id);
    return false; */

    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */

    /* 
            Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
            var token = document.getElementById('token').getAttribute("content");
        
            Usar el objeto FormData para guardar los parámetros que se enviarán:
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('clave', valor);
            */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', "DELETE");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/historial/" + historial_id, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.resultado == "OK") {
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = '<p>Historial eliminado correctamente.</p>';
                    showHistorial();

                } else {
                    //    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    message.innerHTML = respuesta.resultado;
                    alertify.error("Ha habido un error");
                    console.log(respuesta)
                }
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/* EliminaCursos */
function eliminarCentro(idCentro) {
    var message = document.getElementById('message');
    /* console.log(curso_id);
    console.log(idCentro);
    return false; */

    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */

    /* 
            Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
            var token = document.getElementById('token').getAttribute("content");
        
            Usar el objeto FormData para guardar los parámetros que se enviarán:
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('clave', valor);
            */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', "DELETE");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/centro/" + idCentro, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* console.log(respuesta);
                return false */
                if (respuesta.resultado == "OK") {
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = '<p>Curso eliminado correctamente.</p>';
                    showCentros();
                } else {
                    //    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    message.innerHTML = respuesta.resultado;
                    alertify.error("Ha habido un error");
                    console.log(respuesta)
                }
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/* EliminaCursos */
function eliminarCursos(curso_id, idCentro) {
    var message = document.getElementById('message');
    /* console.log(curso_id);
    console.log(idCentro);
    return false; */

    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', "DELETE");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/cursos/" + curso_id, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* console.log(respuesta);
                return false */
                if (respuesta.resultado == "OK") {
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = '<p>Curso eliminado correctamente.</p>';
                    showCursos(idCentro);
                } else {
                    //    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    message.innerHTML = respuesta.resultado;
                    alertify.error("Ha habido un error");
                    console.log(respuesta)
                }
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/* EliminarAsignaturas */
function eliminarAsignaturas(asignatura_id, idCurso, idCentro) {
    var message = document.getElementById('message');
    /* console.log(asignatura_id);
    return false; */

    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */

    /* 
            Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
            var token = document.getElementById('token').getAttribute("content");
        
            Usar el objeto FormData para guardar los parámetros que se enviarán:
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('clave', valor);
            */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', "DELETE");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/asignaturas/" + asignatura_id, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.resultado == "OK") {
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = '<p>Asignatura eliminado correctamente.</p>';
                    showAsignaturas(idCurso, idCentro);
                } else {
                    //    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    message.innerHTML = respuesta.resultado;
                    alertify.error("Ha habido un error");
                    console.log(respuesta)
                }
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/* EliminarTemas */
function eliminarTemas(tema_id, idAsignatura, idCurso, idCentro) {
    var message = document.getElementById('message');
    /* console.log(tema_id);
    return false; */

    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */

    /* 
            Obtener elemento/s que se pasarán como parámetros: token, method, inputs... 
            var token = document.getElementById('token').getAttribute("content");
        
            Usar el objeto FormData para guardar los parámetros que se enviarán:
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('clave', valor);
            */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', "DELETE");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/temas/" + tema_id, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.resultado == "OK") {
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = '<p>Tema eliminado correctamente.</p>';
                    showTemas(idAsignatura, idCurso, idCentro);
                } else {
                    //    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    message.innerHTML = respuesta.resultado;
                    alertify.error("Ha habido un error");
                    console.log(respuesta)
                }
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}
/* EliminarApuntes */
function eliminarApuntes(apunte_id) {
    var message = document.getElementById('message');
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', "DELETE");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "admin/apuntes/" + apunte_id, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.resultado == "OK") {
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = '<p>Apunte eliminado correctamente.</p>';
                    showApuntes();

                } else {
                    //    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    message.innerHTML = respuesta.resultado;
                    alertify.error("Ha habido un error");
                    console.log(respuesta)
                }
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}

//SweetAlerts
/*Cerrar ModalBox*/
function swalCentros(id) {
    swal({
            title: "Estas seguro de eliminar este centro?",
            text: "Una vez eliminado, no podras recuperar este centro!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal("Eliminaste el centro correctamente!", {
                    icon: "success",

                });
                eliminarCentro(id);
            }
        });
}

function swalCursos(id, idCentro) {
    swal({
            title: "Estas seguro de eliminar este curso?",
            text: "Una vez eliminado, no podras recuperar este curso!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal("Eliminaste el curso correctamente!", {
                    icon: "success",

                });
                eliminarCursos(id, idCentro);
            }
        });
}

function swalAsignaturas(id, idCurso, idCentro) {
    swal({
            title: "Estas seguro de eliminar esta asignatura?",
            text: "Una vez eliminado, no podras recuperar esta asignatura!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal("Eliminaste la asignatura correctamente!", {
                    icon: "success",

                });
                eliminarAsignaturas(id, idCurso, idCentro);
            }
        });
}

function swalTemas(id, idAsignatura, idCurso, idCentro) {
    swal({
            title: "Estas seguro de eliminar este tema?",
            text: "Una vez eliminado, no podras recuperar este tema!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal("Eliminaste el tema correctamente!", {
                    icon: "success",

                });
                eliminarTemas(id, idAsignatura, idCurso, idCentro);
            }
        });
}

function swalApuntes(id) {
    swal({
            title: "Estas seguro de eliminar este archivo?",
            text: "Una vez eliminado, no podras recuperar este archivo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal("Eliminaste el registro correctamente!", {
                    icon: "success",

                });
                eliminarApuntes(id);
            }
        });
}

function swalUsers(id) {
    swal({
            title: "Estas seguro de eliminar este usuario?",
            text: "Una vez eliminado, no podras recuperar este usuario!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal("Eliminaste el usuario correctamente!", {
                    icon: "success",

                });
                eliminarUsers(id);
            }
        });
}

//ModalBox
/*ModalBox Centro*/
function modalboxCentro(idCentro, nombre, pais, com_auto, ciudad, direccion) {
    var recarga = '';
    recarga += `<form id="formUpdate" method="post">
                        <b><span>Nombre centro:</span>
                        <input class="input-editar" type="text" name="nombre" id="nombre" value="${nombre}"><br>
                        <b><span>Pais centro:</span>
                        <input class="input-editar" type="text" name="pais" id="pais" value="${pais}"><br>
                        <b><span>Comunidad autonoma:</span>
                        <input class="input-editar" type="text" name="com_auto" id="com_auto" value="${com_auto}"><br>
                        <b><span>Ciudad:</span>
                        <input class="input-editar" type="text" name="ciudad" id="ciudad" value="${ciudad}"><br>
                        <b><span>Dirección:</span>
                        <input class="input-editar" type="text" name="direccion" id="direccion" value="${direccion}"><br>
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}">
                        <input type="hidden" name="nombre_antiguo" id="nombre_antiguo" value="${nombre}">
                    </form>`;
    Swal.fire({
        title: `Actualizar centro: ${nombre}`,
        html: recarga,
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            actualizarCentro();
        }
    });
}
/*ModalBox Curso*/
function modalboxCurso(idCentro, id, nombre, nombre_corto_curso, tipo_curso) {
    var recarga = '';
    recarga += `<form id="formUpdateCurso" method="post">
                        <b><span>Nombre Curso:</span>
                        <input class="input-editar" type="text" name="nombre_curso" id="nombre_curso" value="${nombre}"><br>
                        <b><span>Nombre corto:</span>
                        <input class="input-editar" type="text" name="nombre_corto_curso" id="nombre_corto_curso" value="${nombre_corto_curso}"><br>
                        <b><span>Tipo curso:</span>
                        <input class="input-editar" type="text" name="tipo_curso" id="tipo_curso" value="${tipo_curso}"><br>
                        <input type="hidden" name="id" id="id" value="${id}">
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}">
                        <input type="hidden" name="nombre_antiguo" id="nombre_antiguo" value="${nombre}">
                    </form>`;
    Swal.fire({
        title: `Actualizar curso: ${nombre}`,
        html: recarga,
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            actualizarCurso(idCentro);
        }
    });
}
/*ModalBox Asignatura*/
function modalboxAsignatura(idCentro, idCurso, id, nombre_asignatura) {
    var recarga = '';
    recarga += `<form id="formUpdateAsignatura" method="post">
                        <b><span>Nombre Asignatura:</span>
                        <input class="input-editar" type="text" name="nombre_asignatura" id="nombre_asignatura" value="${nombre_asignatura}"><br>
                        <input type="hidden" name="id" id="id" value="${id}">
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}">
                        <input type="hidden" name="id_curso" id="id_curso" value="${idCurso}">
                        <input type="hidden" name="nombre_antiguo" id="nombre_antiguo" value="${nombre_asignatura}">
                    </form>`;
    Swal.fire({
        title: `Actualizar asignatura: ${nombre_asignatura}`,
        html: recarga,
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            actualizarAsignatura(idCurso, idCentro);
        }
    });
}
/*ModalBox Tema*/
function modalboxTema(idCentro, idCurso, idAsignatura, id, nombre_tema) {
    var recarga = '';
    recarga += `<form id="formUpdateTema" method="post">
                        <b><span>Nombre Tema:</span>
                        <input class="input-editar" type="text" name="nombre_tema" id="nombre_tema" value="${nombre_tema}"><br>
                        <input type="hidden" name="id" id="id" value="${id}">
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}">
                        <input type="hidden" name="id_curso" id="id_curso" value="${idCurso}">
                        <input type="hidden" name="id_asignatura" id="id_asignatura" value="${idAsignatura}">
                        <input type="hidden" name="nombre_antiguo" id="nombre_antiguo" value="${nombre_tema}">
                    </form>`;
    Swal.fire({
        title: `Actualizar tema: ${nombre_tema}`,
        html: recarga,
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            actualizarTema(idCentro, idCurso, idAsignatura);
        }
    });
}
/*ModalBox User*/
function modalboxUser(id, nombre_usu, apellido_usu, nick_usu, fecha_nac_usu, correo_usu, deshabilitado, tmpdeshabilitado, nombre_rol) {
    let recarga = '';
    recarga += `<form id="formUpdateUser" method="post" onsubmit="actualizarUser();return false;">
                        <b><span>Nombre usuario:</span>
                        <input class="input-editar" type="text" name="nombre_usu" id="nombre_usu" value="${nombre_usu}"><br>
                        <b><span>Apellido usuario:</span>
                        <input class="input-editar" type="text" name="apellido_usu" id="apellido_usu" value="${apellido_usu}"><br>
                        <b><span>Nickname usuario:</span>
                        <input class="input-editar" type="text" name="nick_usu" id="nick_usu" value="${nick_usu}"><br>
                        <b><span>Fecha nacimiento usuario:</span>
                        <input class="input-editar" type="date" name="fecha_nac_usu" id="fecha_nac_usu" value="${fecha_nac_usu}"><br>
                        <b><span>Correo usuario:</span>
                        <input class="input-editar" type="text" name="correo_usu" id="correo_usu" value="${correo_usu}"><br>
                        <b><span>Fecha deshabilitado:</span>
                        <input class="input-editar" type="date" name="deshabilitado" id="deshabilitado" value="${deshabilitado}"><br>
                        <b><span>Hora deshabilitado:</span>
                        <input class="input-editar" type="time" name="tmpdeshabilitado" id="tmpdeshabilitado" value="${tmpdeshabilitado}"><br>
                        <b><span>Rol usuario:</span>
                        <select class="input-editar" name="nombre_rol" id="nombre_rol">
                            <option value="${nombre_rol}" selected>${nombre_rol}</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Moderador">Moderador</option>  
                            <option value="Cliente">Cliente</option>
                            <option value="Profesor">Profesor</option>  
                            <option value="Empresa">Empresa</option>                              
                        </select><br>
                        <input type="hidden" name="id" id="id" value="${id}">
                    </form>`;
    Swal.fire({
        title: `Actualizar usuario: ${nick_usu}`,
        html: recarga,
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            actualizarUser();
        }
    });
}

//Actualizar
/* ActualizarCentro */
function actualizarCentro() {
    var message = document.getElementById('message');
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData(document.getElementById('formUpdate'));
    formData.append('_token', token);
    formData.append('_method', "PUT");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/centro", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                //message.innerHTML = '<p>Centro modificado correctamente.</p>';
                alertify.success("Centro modificado correctamente");
                showCentros();
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}
/* ActualizarCurso */
function actualizarCurso(idCentro) {
    var message = document.getElementById('message');
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData(document.getElementById('formUpdateCurso'));
    formData.append('_token', token);
    formData.append('_method', "PUT");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/curso", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                //message.innerHTML = '<p>Curso modificado correctamente.</p>';
                alertify.success("Curso modificado correctamente");
                showCursos(idCentro);
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}
/* ActualizarAsiganuta */
function actualizarAsignatura(idCurso, idCentro) {
    var message = document.getElementById('message');
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData(document.getElementById('formUpdateAsignatura'));
    formData.append('_token', token);
    formData.append('_method', "PUT");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/asignatura", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                //message.innerHTML = '<p>Asignatura modificada correctamente.</p>';
                alertify.success("Asignatura modificada correctamente");
                showAsignaturas(idCurso, idCentro);
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}
/* ActualizarTema */
function actualizarTema(idCentro, idCurso, idAsignatura) {
    var message = document.getElementById('message');
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData(document.getElementById('formUpdateTema'));
    formData.append('_token', token);
    formData.append('_method', "PUT");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/tema", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                //message.innerHTML = '<p>Tema modificado correctamente.</p>';
                alertify.success("Tema modificado correctamente");
                showTemas(idAsignatura, idCurso, idCentro);
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}
/* ActualizarUser */
function actualizarUser() {

    var message = document.getElementById('message');
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData(document.getElementById('formUpdateUser'));
    formData.append('_token', token);
    formData.append('_method', "PUT");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/user", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            /* console.log(respuesta);
            return false; */
            if (respuesta.resultado == "OK") {
                //message.innerHTML = '<p>Usuario modificado correctamente.</p>';
                alertify.success("Usuario modificado correctamente");
                showUsers();
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}

/*ModalBox Crear Centro*/
function modalboxCrearCentro() {
    var recarga = '';
    recarga += `<form id="formCrearCentro" method="post" enctype="multipart/form-data">
                        <b><span>Nombre del Centro:</span>
                        <input class="input-editar-admin" type="text" name="nombre_centro" id="nombre_centro" value=""><br>
                        <b><span>Pais del centro:</span>
                        <input class="input-editar-admin" type="text" name="pais_centro" id="pais_centro" value=""><br>
                        <b><span>Comunidad autonoma del centro:</span>
                        <input class="input-editar-admin" type="text" name="com_auto_centro" id="com_auto_centro" value=""><br>
                        <b><span>Ciudad del centro:</span>
                        <input class="input-editar-admin" type="text" name="ciudad_centro" id="ciudad_centro" value=""><br>
                        <b><span>Dirección del centro:</span>
                        <input class="input-editar-admin" type="text" name="direccion_centro" id="direccion_centro" value=""><br>
                    </form>`;
    Swal.fire({
        title: `Crear centro`,
        html: recarga,
        showCancelButton: true,
        confirmButtonText: "Crear",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            crearCentro();
        }
    });
}
/*ModalBox Crear Curso*/
function modalboxCrearCurso(idCentro) {
    var recarga = '';
    recarga += `<form id="formCrearCurso" method="post" enctype="multipart/form-data">
                        <b><span>Nombre del Curso:</span>
                        <input type="text" name="nombre_curso" id="nombre_curso" value=""><br>
                        <b><span>Abreviación:</span>
                        <input type="text" name="nombre_corto_curso" id="nombre_corto_curso" value=""><br>
                        <b><span>Tipo de curso:</span>
                        <input type="text" name="tipo_curso" id="tipo_curso" value=""><br>
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}"><br>
                    </form>`;
    Swal.fire({
        title: `Crear curso`,
        html: recarga,
        showCancelButton: true,
        confirmButtonText: "Crear",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            crearCurso(idCentro);
        }
    });
}

/*ModalBox Crear Asignatura*/
function modalboxCrearAsignatura(idCurso, idCentro) {
    var recarga = '';
    recarga += `<form id="formCrearAsignatura" method="post" enctype="multipart/form-data">
                        <b><span>Nombre de la Asignatura:</span>
                        <input type="text" name="nombre_asignatura" id="nombre_asignatura" value=""><br>
                        <input type="hidden" name="id_curso" id="id_curso" value="${idCurso}"><br>
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}"><br>
                    </form>`;
    Swal.fire({
        title: `Crear asignatura`,
        html: recarga,
        showCancelButton: true,
        confirmButtonText: "Crear",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            crearAsignatura(idCurso, idCentro);
        }
    });
}

/*ModalBox Crear Tema*/
function modalboxCrearTema(idAsignatura, idCurso, idCentro) {
    var recarga = '';
    recarga += `<form id="formCrearTema" method="post" enctype="multipart/form-data">
                        <b><span>Nombre del Tema:</span>
                        <input type="text" name="nombre_tema" id="nombre_tema" value=""><br>
                        <input type="hidden" name="id_asignatura" id="id_asignatura" value="${idAsignatura}"><br>
                        <input type="hidden" name="id_curso" id="id_curso" value="${idCurso}"><br>
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}"><br>
                    </form>`;
    Swal.fire({
        title: `Crear tema`,
        html: recarga,
        showCancelButton: true,
        confirmButtonText: "Crear",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            crearTema(idAsignatura, idCurso, idCentro);
        }
    });
}

/* CrearCentro */
function crearCentro() {
    /* console.log(nombre_usu);
    console.log(apellido_usu);
    console.log(nick_usu);
    console.log(fecha_nac_usu);
    console.log(correo_usu);
    console.log(nombre_rol);
    return false; */
    var message = document.getElementById('message');
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData(document.getElementById('formCrearCentro'));
    formData.append('_token', token);
    formData.append('_method', "POST");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/crearcentro", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            /* console.log(respuesta);
            return false; */
            if (respuesta.resultado == "OK") {
                //message.innerHTML = '<p>Usuario modificado correctamente.</p>';
                alertify.success("Centro creado correctamente");
                showCentros();
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}

/* CrearCurso */
function crearCurso(idCentro) {
    /* console.log(nombre_usu);
    console.log(apellido_usu);
    console.log(nick_usu);
    console.log(fecha_nac_usu);
    console.log(correo_usu);
    console.log(nombre_rol);
    return false; */
    var message = document.getElementById('message');
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData(document.getElementById('formCrearCurso'));
    formData.append('_token', token);
    formData.append('_method', "POST");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/crearcurso", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            /* console.log(respuesta);
            return false; */
            if (respuesta.resultado == "OK") {
                //message.innerHTML = '<p>Usuario modificado correctamente.</p>';
                alertify.success("Curso creado correctamente");
                showCursos(idCentro);
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}

/* CrearAsignatura */
function crearAsignatura(idCurso, idCentro) {
    var message = document.getElementById('message');
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData(document.getElementById('formCrearAsignatura'));
    formData.append('_token', token);
    formData.append('_method', "POST");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/crearasignatura", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            /* console.log(respuesta);
            return false; */
            if (respuesta.resultado == "OK") {
                //message.innerHTML = '<p>Usuario modificado correctamente.</p>';
                alertify.success("Asignatura creada correctamente");
                showAsignaturas(idCurso, idCentro);
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}

/* CrearAsignatura */
function crearTema(idAsignatura, idCurso, idCentro) {
    var message = document.getElementById('message');
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    var token = document.getElementById('token').getAttribute("content");
    var formData = new FormData(document.getElementById('formCrearTema'));
    formData.append('_token', token);
    formData.append('_method', "POST");
    /* Inicializar un objeto AJAX */
    var ajax = llamadaAjax();

    ajax.open("POST", "admin/creartema", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            /* console.log(respuesta);
            return false; */
            if (respuesta.resultado == "OK") {
                //message.innerHTML = '<p>Usuario modificado correctamente.</p>';
                alertify.success("Tema creado correctamente");
                showTemas(idAsignatura, idCurso, idCentro);
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}
setCookie("darkmode", 1, 365);