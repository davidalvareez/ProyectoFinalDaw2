window.onload = function() {
    content = document.getElementById('content');
    token = document.getElementById('token').getAttribute("content")
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
    ajax.open("POST", "admin/users", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* console.log(respuesta);
                return false; */
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                    <table class="table table-striped">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nickname</th>
                    <th scope="col">Nombre y Apellido</th>
                    <th scope="col">Fecha nacimiento</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha habilitado</th>
                    <th scope="col">Centro de estudio</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Imagen Avatar</th>
                    <th scope="col" colspan="3">Acciones</th>
                    </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                        <td scope="row"><b>${respuesta[i].id}</b></td>
                        <td>${respuesta[i].nick_usu}</td>
                        <td>${respuesta[i].nombre_usu} ${respuesta[i].apellido_usu}</td>
                        <td>${respuesta[i].fecha_nac_usu}</td>
                        <td>${respuesta[i].correo_usu}</td>
                        <td>${respuesta[i].deshabilitado}</td>
                        <td>${respuesta[i].tmpdeshabilitado}</td>
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
                    </div>`;
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
                console.log(respuesta);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <button class="boton-tabla" type="submit" value="Create" onclick="modalboxCrearCentro();">Crear</button>
                    <table class="table table-striped">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Comunidad autonoma y Ciudad</th>
                    <th scope="col">Direccion</th>
                    <th scope="col" colspan="3">Acciones</th>
                    </tr>`;
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
                         <button class= "btn btn-warning" type="submit" value="Delete" onclick="showCursos(${respuesta[i].id});return false;">Ver cursos</button>
                         </td>
                         </tr>`
                }
                /* <td>
                 <button class= "btn btn-danger" type="submit" value="Delete" onclick="swalCentros(${respuesta[i].id});return false;">Eliminar</button>
                 </td> */
                recarga += `</table>
                    </div>`;
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
                console.log(respuesta);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <button class="boton-tabla" type="submit" value="Create" onclick="modalboxCrearCurso(${idCentro});">Crear</button>
                <button class="boton-volver" type="submit" value="Edit" onclick="showCentros();">Voler a centros</button>
                    <table class="table table-striped">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Nombre corto</th>
                        <th scope="col">Tipo</th>
                        <th scope="col" colspan="3">Acciones</th>
                        </tr>`;
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
                             <button class= "btn btn-warning" type="submit" value="Delete" onclick="showAsignaturas(${respuesta[i].id}, ${idCentro});return false;">Ver asignaturas</button>
                             </td>
                             </tr>`
                }
                recarga += `</table>
                        </div>`;
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
                console.log(respuesta);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <button class="boton-tabla" type="submit" value="Create" onclick="modalboxCrearAsignatura(${idCurso},${idCentro});">Crear</button>
                <button class="boton-volver" type="submit" value="Edit" onclick="showCursos(${idCentro});">Voler a Cursos</button>
                            <table class="table table-striped">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col" colspan="3">Acciones</th>
                            </tr>`;
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
                                 <button class= "btn btn-warning" type="submit" value="Delete" onclick="showTemas(${respuesta[i].id}, ${idCurso}, ${idCentro} );return false;">Ver temas</button>
                                 </td>
                                 </tr>`
                }
                recarga += `</table>
                            </div>`;
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
                console.log(respuesta);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <button class="boton-tabla" type="submit" value="Create" onclick="modalboxCrearTema(${idAsignatura},${idCurso},${idCentro});">Crear</button>
                <button class="boton-volver" type="submit" value="Edit" onclick="showAsignaturas(${idCurso},${idCentro});">Voler a Asignaturas</button>
                                <table class="table table-striped">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre tema</th>
                                <th scope="col" colspan="3">Acciones</th>
                                </tr>`;
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
                                </div>`;
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
                                <table class="table table-striped">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Documento</th>
                                <th scope="col">Fecha Publicacion</th>
                                <th scope="col">Creador</th>
                                <th scope="col">Acciones</th>
                                </tr>`;
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
                                </div>`;
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
    ajax.open("POST", "admin/denuncias", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                                <table class="table table-striped">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Acusado</th>
                                <th scope="col">Demandante</th>
                                <th scope="col" colspan="2">Acciones</th>
                                </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                                     <td scope="row"><b>${respuesta[i].id}</b></td>
                                     <td>${respuesta[i].tipus_denuncia}</td>
                                     <td>${respuesta[i].desc_denuncia}</td>
                                     <td>${respuesta[i].acusado}</td>
                                     <td>${respuesta[i].demandante}</td>

                                     <td>
                                     <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Opciones</button>
                                     </td>
                                     <td>
                                     <button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminarDenuncias(${respuesta[i].id});return false;">Eliminar</button>
                                     </td>
                                     </tr>`
                }
                recarga += `</table>
                                </div>`;
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
                                <table class="table table-striped">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre Apuntes</th>
                                <th scope="col">Nombre Usuario</th>
                                <th scope="col" colspan="2">Acciones</th>
                                </tr>`;
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
                                </div>`;
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
/* EliminarDenuncias */
function eliminarDenuncias(denuncia_id) {
    var message = document.getElementById('message');
    /* console.log(denuncia_id);
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
    ajax.open("POST", "admin/denuncias/" + denuncia_id, true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                if (respuesta.resultado == "OK") {
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = '<p>Denuncia eliminado correctamente.</p>';
                    showDenuncias();

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
function eliminarCursos(curso_id, idCentro) {
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
    /* console.log(apunte_id);
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
/* function swalCentros(id) {
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
} */

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
/* Cerrar ModalBox */
function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}
/*ModalBox Centro*/
function modalboxCentro(idCentro, nombre, pais, com_auto, ciudad, direccion) {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var recarga = '';
    recarga += `<div class="modal-content">
                    <span class="close" onclick="closeModal();">&times;</span>
                    <form id="formUpdate" method="post" onsubmit="actualizarCentro();closeModal();return false;">
                        <h2 id="nombreCentro">${nombre}</h2>
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
                        <input class="boton-guardar" type="submit" value="Guardar">
                    </form>
                </div>`;
    modal.innerHTML = recarga;
}
/*ModalBox Curso*/
function modalboxCurso(idCentro, id, nombre, nombre_corto_curso, tipo_curso) {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var recarga = '';
    recarga += `<div class="modal-content">
                    <span class="close" onclick="closeModal();">&times;</span>
                    <form id="formUpdateCurso" method="post" onsubmit="actualizarCurso(${idCentro});closeModal();return false;">
                        <h2 id="nombreCurso">${nombre}</h2>
                        <b><span>Nombre Curso:</span>
                        <input class="input-editar" type="text" name="nombre_curso" id="nombre_curso" value="${nombre}"><br>
                        <b><span>Nombre corto:</span>
                        <input class="input-editar" type="text" name="nombre_corto_curso" id="nombre_corto_curso" value="${nombre_corto_curso}"><br>
                        <b><span>Tipo curso:</span>
                        <input class="input-editar" type="text" name="tipo_curso" id="tipo_curso" value="${tipo_curso}"><br>
                        <input type="hidden" name="id" id="id" value="${id}">
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}">
                        <input type="hidden" name="nombre_antiguo" id="nombre_antiguo" value="${nombre}">
                        <input class="boton-guardar" type="submit" value="Guardar">
                    </form>
                </div>`;
    modal.innerHTML = recarga;
}
/*ModalBox Asignatura*/
function modalboxAsignatura(idCentro, idCurso, id, nombre_asignatura) {
    /*  console.log(idCurso);
        console.log(id);
        console.log(nombre_asignatura); */
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var recarga = '';
    recarga += `<div class="modal-content">
                    <span class="close" onclick="closeModal();">&times;</span>
                    <form id="formUpdateAsignatura" method="post" onsubmit="actualizarAsignatura(${idCurso},${idCentro});closeModal();return false;">
                        <h2 id="nombreAsignatura">${nombre_asignatura}</h2>
                        <b><span>Nombre Asignatura:</span>
                        <input class="input-editar" type="text" name="nombre_asignatura" id="nombre_asignatura" value="${nombre_asignatura}"><br>
                        <input type="hidden" name="id" id="id" value="${id}">
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}">
                        <input type="hidden" name="id_curso" id="id_curso" value="${idCurso}">
                        <input type="hidden" name="nombre_antiguo" id="nombre_antiguo" value="${nombre_asignatura}">
                        <input class="boton-guardar" type="submit" value="Guardar">
                    </form>
                </div>`;
    modal.innerHTML = recarga;
}
/*ModalBox Tema*/
function modalboxTema(idCentro, idCurso, idAsignatura, id, nombre_tema) {
    /*  console.log(idAsignatura);
        console.log(id);
        console.log(nombre_tema); */
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var recarga = '';
    recarga += `<div class="modal-content">
                    <span class="close" onclick="closeModal();">&times;</span>
                    <form id="formUpdateTema" method="post" onsubmit="actualizarTema(${idCentro},${idCurso},${idAsignatura});closeModal();return false;">
                        <h2 id="nombreTema">${nombre_tema}</h2>
                        <b><span>Nombre Tema:</span>
                        <input class="input-editar" type="text" name="nombre_tema" id="nombre_tema" value="${nombre_tema}"><br>
                        <input type="hidden" name="id" id="id" value="${id}">
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}">
                        <input type="hidden" name="id_curso" id="id_curso" value="${idCurso}">
                        <input type="hidden" name="id_asignatura" id="id_asignatura" value="${idAsignatura}">
                        <input type="hidden" name="nombre_antiguo" id="nombre_antiguo" value="${nombre_tema}">
                        <input class="boton-guardar" type="submit" value="Guardar">
                    </form>
                </div>`;
    modal.innerHTML = recarga;
}
/*ModalBox User*/
function modalboxUser(id, nombre_usu, apellido_usu, nick_usu, fecha_nac_usu, correo_usu, deshabilitado, tmpdeshabilitado, nombre_rol) {
    /* console.log(id);
    console.log(nombre_usu);
    console.log(apellido_usu);
    console.log(nick_usu);
    console.log(fecha_nac_usu);
    console.log(correo_usu);
    console.log(deshabilitado);
    console.log(nombre_centro);
    console.log(nombre_rol);
    return false; */
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var recarga = '';
    recarga += `<div class="modal-content">
                    <span class="close" onclick="closeModal();">&times;</span>
                    <form id="formUpdateUser" method="post" onsubmit="actualizarUser();closeModal();return false;">
                        <h2 id="nombreUser">${nombre_usu} ${apellido_usu}</h2>
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
                        <input class="boton-guardar" type="submit" value="Guardar">
                    </form>
                </div>`;
    modal.innerHTML = recarga;
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
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var recarga = '';
    recarga += `<div class="modal-content">
                    <span class="close" onclick="closeModal();">&times;</span>
                    <form id="formCrearCentro" method="post" onsubmit="crearCentro();closeModal();return false;" enctype="multipart/form-data">
                        <h2 id="nombreCentro">Crear centro</h2>
                        <b><span>Nombre del Centro:</span>
                        <input type="text" name="nombre_centro" id="nombre_centro" value=""><br>
                        <b><span>Pais del centro:</span>
                        <input type="text" name="pais_centro" id="pais_centro" value=""><br>
                        <b><span>Comunidad autonoma del centro:</span>
                        <input type="text" name="com_auto_centro" id="com_auto_centro" value=""><br>
                        <b><span>Ciudad del centro:</span>
                        <input type="text" name="ciudad_centro" id="ciudad_centro" value=""><br>
                        <b><span>Dirección del centro:</span>
                        <input type="text" name="direccion_centro" id="direccion_centro" value=""><br>
                        <input type="submit" value="Crear">
                    </form>
                </div>`;
    modal.innerHTML = recarga;
}
/*ModalBox Crear Curso*/
function modalboxCrearCurso(idCentro) {
    console.log(idCentro);
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var recarga = '';
    recarga += `<div class="modal-content">
                    <span class="close" onclick="closeModal();">&times;</span>
                    <form id="formCrearCurso" method="post" onsubmit="crearCurso(${idCentro});closeModal();return false;" enctype="multipart/form-data">
                        <h2 id="nombreCurso">Crear Curso</h2>
                        <b><span>Nombre del Curso:</span>
                        <input type="text" name="nombre_curso" id="nombre_curso" value=""><br>
                        <b><span>Abreviación:</span>
                        <input type="text" name="nombre_corto_curso" id="nombre_corto_curso" value=""><br>
                        <b><span>Tipo de curso:</span>
                        <input type="text" name="tipo_curso" id="tipo_curso" value=""><br>
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}"><br>
                        <input type="submit" value="Crear">
                    </form>
                </div>`;
    modal.innerHTML = recarga;
}

/*ModalBox Crear Asignatura*/
function modalboxCrearAsignatura(idCurso, idCentro) {
    /* console.log(idCurso);
    console.log(idCentro); */
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var recarga = '';
    recarga += `<div class="modal-content">
                    <span class="close" onclick="closeModal();">&times;</span>
                    <form id="formCrearAsignatura" method="post" onsubmit="crearAsignatura(${idCurso});closeModal();return false;" enctype="multipart/form-data">
                        <h2 id="nombreAsignatura">Crear Curso</h2>
                        <b><span>Nombre de la Asignatura:</span>
                        <input type="text" name="nombre_asignatura" id="nombre_asignatura" value=""><br>
                        <input type="hidden" name="id_curso" id="id_curso" value="${idCurso}"><br>
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}"><br>
                        <input type="submit" value="Crear">
                    </form>
                </div>`;
    modal.innerHTML = recarga;
}

/*ModalBox Crear Tema*/
function modalboxCrearTema(idAsignatura, idCurso, idCentro) {
    /* console.log(idCurso);
    console.log(idCentro); */
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var recarga = '';
    recarga += `<div class="modal-content">
                    <span class="close" onclick="closeModal();">&times;</span>
                    <form id="formCrearTema" method="post" onsubmit="crearTema(${idAsignatura});closeModal();return false;" enctype="multipart/form-data">
                        <h2 id="nombreTema">Crear Curso</h2>
                        <b><span>Nombre del Tema:</span>
                        <input type="text" name="nombre_tema" id="nombre_tema" value=""><br>
                        <input type="hidden" name="id_asignatura" id="id_asignatura" value="${idAsignatura}"><br>
                        <input type="hidden" name="id_curso" id="id_curso" value="${idCurso}"><br>
                        <input type="hidden" name="id_centro" id="id_centro" value="${idCentro}"><br>
                        <input type="submit" value="Crear">
                    </form>
                </div>`;
    modal.innerHTML = recarga;
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
function crearAsignatura(idCurso) {
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
                showAsignaturas(idCurso);
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
function crearTema(idAsignatura) {
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
                alertify.success("Asignatura creada correctamente");
                showTemas(idAsignatura);
            } else {
                message.innerHTML = respuesta.resultado;
                alertify.error("Ha habido un error");
            }
            /* console.log(respuesta); */
        }
    }
    ajax.send(formData)
}