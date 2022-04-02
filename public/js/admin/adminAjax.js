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

//Mostrar usuarios
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
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <table class="">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nickname</th>
                <th scope="col">Nombre y Apellido</th>
                <th scope="col">Fecha nacimiento</th>
                <th scope="col">Correo</th>
                <th scope="col">Estado</th>
                <th scope="col">Centro de estudio</th>
                <th scope="col">Rol</th>
                <th scope="col">Nivel</th>
                <th scope="col">Imagen Avatar</th>
                <th scope="col" colspan="2">Acciones</th>
                </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                     <td scope="row">${respuesta[i].id}</td>
                     <td>${respuesta[i].nick_usu}</td>
                     <td>${respuesta[i].nombre_usu} ${respuesta[i].apellido_usu}</td>
                     <td>${respuesta[i].fecha_nac_usu}</td>
                     <td>${respuesta[i].correo_usu}</td>
                     <td>${respuesta[i].deshabilitado}</td>
                     <td>${respuesta[i].nombre_centro}</td>
                     <td>${respuesta[i].nombre_rol}</td>
                     <td>${respuesta[i].nombre_nivel}</td>
                     <td>${respuesta[i].img_avatar}</td>
                     <td>
                     <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Editar</button>
                     </td>
                     <td>
                     <button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar('${respuesta[i].id}');return false;">Eliminar</button>
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
//Mostrar centros
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
                console.log(respuesta);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                    <table class="">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Comunidad autonoma y Ciudad</th>
                    <th scope="col">Direccion</th>
                    <th scope="col" colspan="3">Acciones</th>
                    </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                         <td scope="row">${respuesta[i].id}</td>
                         <td>${respuesta[i].nombre_centro}</td>
                         <td>${respuesta[i].com_auto_centro}, ${respuesta[i].ciudad_centro}</td>
                         <td>${respuesta[i].direccion_centro}</td>
                         <td>
                         <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Editar</button>
                         </td>
                         <td>
                         <button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar('${respuesta[i].id}');return false;">Eliminar</button>
                         </td>
                         <td>
                         <button class= "btn btn-danger" type="submit" value="Delete" onclick="showCursos('${respuesta[i].id}');return false;">Ver cursos</button>
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
//Mostrar cursos
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
                        <table class="">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Nombre corto</th>
                        <th scope="col">Tipo</th>
                        <th scope="col" colspan="3">Acciones</th>
                        </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                             <td scope="row">${respuesta[i].id}</td>
                             <td>${respuesta[i].nombre_curso}</td>
                             <td>${respuesta[i].nombre_corto_curso}</td>
                             <td>${respuesta[i].tipo_curso}</td>
                             <td>
                             <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Editar</button>
                             </td>
                             <td>
                             <button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar('${respuesta[i].id}');return false;">Eliminar</button>
                             </td>
                             <td>
                             <button class= "btn btn-danger" type="submit" value="Delete" onclick="showAsignaturas('${respuesta[i].id}');return false;">Ver asignaturas</button>
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
//Mostrar asignaturas
function showAsignaturas(idCurso) {
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
                            <table class="">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col" colspan="3">Acciones</th>
                            </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                                 <td scope="row">${respuesta[i].id}</td>
                                 <td>${respuesta[i].nombre_asignatura}</td>
                                 <td>
                                 <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Editar</button>
                                 </td>
                                 <td>
                                 <button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar('${respuesta[i].id}');return false;">Eliminar</button>
                                 </td>
                                 <td>
                                 <button class= "btn btn-danger" type="submit" value="Delete" onclick="showTemas('${respuesta[i].id}');return false;">Ver temas</button>
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
//Mostrar temas
function showTemas(idAsignatura) {
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
                                <table class="">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre tema</th>
                                <th scope="col" colspan="3">Acciones</th>
                                </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                                     <td scope="row">${respuesta[i].id}</td>
                                     <td>${respuesta[i].nombre_tema}</td>
                                     <td>
                                     <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Editar</button>
                                     </td>
                                     <td>
                                     <button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar('${respuesta[i].id}');return false;">Eliminar</button>
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
//Mostrar apuntes
function showApuntes() {
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
                recarga += '<div class="">';
                recarga += '<table class="">';
                recarga += '<tr>';
                recarga += '<th scope="col">#</th>';
                recarga += '<th scope="col">Nickname</th>';
                recarga += '<th scope="col">Nombre y Apellido</th>';
                recarga += '<th scope="col">Fecha nacimiento</th>';
                recarga += '<th scope="col">Correo</th>';
                recarga += '<th scope="col">Estado</th>';
                recarga += '<th scope="col">Centro de estudio</th>';
                recarga += '<th scope="col">Rol</th>';
                recarga += '<th scope="col">Nivel</th>';
                recarga += '<th scope="col">Imagen Avatar</th>';
                recarga += '<th scope="col" colspan="2">Acciones</th>';
                recarga += '</tr>';
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += '<tr>';
                    recarga += '<td scope="row">' + respuesta[i].id + '</td>';
                    recarga += '<td>' + respuesta[i].nick_usu + '</td>';
                    recarga += '<td>' + respuesta[i].nombre_usu + ' ' + respuesta[i].apellido_usu + '</td>';
                    recarga += '<td>' + respuesta[i].fecha_nac_usu + '</td>';
                    recarga += '<td>' + respuesta[i].correo_usu + '</td>';
                    recarga += '<td>' + respuesta[i].deshabilitado + '</td>';
                    recarga += '<td>' + respuesta[i].nombre_centro + '</td>';
                    recarga += '<td>' + respuesta[i].nombre_rol + '</td>';
                    recarga += '<td>' + respuesta[i].nombre_nivel + '</td>';
                    recarga += '<td>' + respuesta[i].img_avatar + '</td>';
                    recarga += '<td>';
                    // editar
                    recarga += '<button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Editar</button>';
                    recarga += '</td>';
                    recarga += '<td>';
                    // eliminar
                    recarga += '<button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar(' + respuesta[i].id + ');return false;">Eliminar</button>';
                    recarga += '</td>';
                    recarga += '</tr>';
                }
                recarga += '</table>';
                recarga += '</div>';
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
//Mostrar denuncias
function showDenuncias() {
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
                                <table class="">
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
                                     <td scope="row">${respuesta[i].id}</td>
                                     <td>${respuesta[i].tipus_denuncia}</td>
                                     <td>${respuesta[i].desc_denuncia}</td>
                                     <td>${respuesta[i].acusado}</td>
                                     <td>${respuesta[i].demandante}</td>

                                     <td>
                                     <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Editar</button>
                                     </td>
                                     <td>
                                     <button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar('${respuesta[i].id}');return false;">Eliminar</button>
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
//Mostrar historial
function showHistorial() {
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
                                <table class="">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre Apuntes</th>
                                <th scope="col">Nombre Usuario</th>
                                <th scope="col" colspan="2">Acciones</th>
                                </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                                     <td scope="row">${respuesta[i].id}</td>
                                     <td>${respuesta[i].nombre_contenido}</td>
                                     <td>${respuesta[i].nombre_usu} ${respuesta[i].apellido_usu}</td>
                                     <td>
                                     <button class="btn btn-secondary" type="submit" value="Edit" onclick="modalbox();return false;">Editar</button>
                                     </td>
                                     <td>
                                     <button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar('${respuesta[i].id}');return false;">Eliminar</button>
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