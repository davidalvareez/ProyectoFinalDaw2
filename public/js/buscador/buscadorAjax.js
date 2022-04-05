window.onload = function() {
    content = document.getElementById('contentFilter');
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
//Filtro multiple
function multiplyFilter() {
    let form = document.getElementById('formBusquedaAvanzada');
    //Centro
    form[0][0].selected = true;
    //Curso
    form[1][0].selected = true;
    //Asignatura
    form[0].selected = true;
    //Tema
    form[3].value = "";

    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('filter', document.getElementById("multiplysearch").value)
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "buscador/multiplyfilter", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                //console.log(respuesta);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                <table class="">
                <tr>
                <th scope="col">Avatar</th>
                <th scope="col">Nickname</th>
                <th scope="col">Archivo</th>
                <th scope="col">Idioma</th>
                <th scope="col">Fecha publicacion</th>
                </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                     <td>${respuesta[i].img_avatar}</td>
                     <td>${respuesta[i].nick_usu}</td>
                     <td>${respuesta[i].nombre_contenido}${respuesta[i].extension_contenido}</td>
                     <td>${respuesta[i].idioma_contenido}</td>
                     <td>${respuesta[i].fecha_publicacion_contenido}</td>
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
//Busqueda Avanzada
function busquedaAvanzada() {
    document.getElementById("multiplysearch").value = "";
    let form = document.getElementById("formBusquedaAvanzada");
    /* Obtener elemento html donde introduciremos la recarga (datos o mensajes) */
    /*
        Obtener elemento/s que se pasarán como parámetros: token, method, inputs...
        var token = document.getElementById('token').getAttribute("content");
        Usar el objeto FormData para guardar los parámetros que se enviarán:
        var formData = new FormData();
        formData.append('_token', token);
        formData.append('clave', valor);
    */
    var formData = new FormData(form);
    formData.append('_token', token);
    formData.append('_method', 'POST');
    var ajax = llamadaAjax();
    /*
    ajax.open("method", "rutaURL", true);
    GET  -> No envía parámetros
    POST -> Sí envía parámetros
    true -> asynchronous
    */
    ajax.open("POST", "buscador/busquedaAvanzada", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                //console.log(respuesta);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<div class="">
                    <table class="">
                    <tr>
                        <th scope="col">Avatar</th>
                        <th scope="col">Nickname</th>
                        <th scope="col">Archivo</th>
                        <th scope="col">Idioma</th>
                        <th scope="col">Fecha publicacion</th>
                    </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                         <td>${respuesta[i].img_avatar}</td>
                         <td>${respuesta[i].nick_usu}</td>
                         <td>${respuesta[i].nombre_contenido}${respuesta[i].extension_contenido}</td>
                         <td>${respuesta[i].idioma_contenido}</td>
                         <td>${respuesta[i].fecha_publicacion_contenido}</td>
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
//Cambio option de centro
function selectCurso_Asignatura() {
    let form = document.getElementById("formBusquedaAvanzada");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('nombre_centro', form[0].value);
    let ajax = llamadaAjax();
    ajax.open("POST", "buscador/busquedaAvanzada/centro", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            let selectCursoFilter = `<option value="">--</option>`;
            let selectAsignaturaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.cursos.length; i++) {
                selectCursoFilter += `<option value="${respuesta.cursos[i].nombre_curso}">${respuesta.cursos[i].nombre_curso}`;
            }
            form[1].innerHTML = selectCursoFilter;
            for (let i = 0; i < respuesta.asignaturas.length; i++) {
                selectAsignaturaFilter += `<option value="${respuesta.asignaturas[i].nombre_asignatura}">${respuesta.asignaturas[i].nombre_asignatura}`;
            }
            form[2].innerHTML = selectAsignaturaFilter;
        }
    }
    ajax.send(formData);
}
//Cambio option de curso
function selectAsignatura() {
    let form = document.getElementById("formBusquedaAvanzada");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('nombre_curso', form[1].value);
    let ajax = llamadaAjax();
    ajax.open("POST", "buscador/busquedaAvanzada/curso", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            let selectAsignaturaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.length; i++) {
                selectAsignaturaFilter += `<option value="${respuesta[i].nombre_asignatura}">${respuesta[i].nombre_asignatura}`;
            }
            form[2].innerHTML = selectAsignaturaFilter;
        }
    }
    ajax.send(formData);
}