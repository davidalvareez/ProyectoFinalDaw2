window.onload = function() {
    content = document.getElementById('content');
    token = document.getElementById('token').getAttribute("content");
    let form = document.getElementById("formSubirApuntes");
    let radioYes = document.getElementById('radioYes');
    let radioNo = document.getElementById('radioNo');
    radioYes.onclick = function() {
        document.getElementById('selectTema').style.display = 'none';
        document.getElementById('textNewTema').style.display = 'block';
        form[4][0].selected = true;
    }
    radioNo.onclick = function() {
        document.getElementById('selectTema').style.display = 'block';
        document.getElementById('textNewTema').style.display = 'none';
        document.getElementById('text_tema').value = '';
    }
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

function selectCurso() {
    let form = document.getElementById("formSubirApuntes");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('nombre_centro', form[0].value);
    let ajax = llamadaAjax();
    ajax.open("POST", "misApuntes/centro", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            //Select de curso
            let selectCursoFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.cursos.length; i++) {
                selectCursoFilter += `<option value="${respuesta.cursos[i].nombre_curso}">${respuesta.cursos[i].nombre_curso}`;
            }
            form[1].innerHTML = selectCursoFilter;
            //Select de asignatura
            let selectAsignaturaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.asignaturas.length; i++) {
                selectAsignaturaFilter += `<option value="${respuesta.asignaturas[i].nombre_asignatura}">${respuesta.asignaturas[i].nombre_asignatura}`;
            }
            form[2].innerHTML = selectAsignaturaFilter;

            //Select de tema
            let selectTemaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.temas.length; i++) {
                selectTemaFilter += `<option value="${respuesta.temas[i].nombre_tema}">${respuesta.temas[i].nombre_tema}`;
            }
            form[5].innerHTML = selectTemaFilter;
        }
    }
    ajax.send(formData);
}

function selectAsignatura() {
    let form = document.getElementById("formSubirApuntes");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('nombre_curso', form[1].value);
    formData.append('nombre_centro', form[0].value);
    let ajax = llamadaAjax();
    ajax.open("POST", "misApuntes/curso", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            //Select de asignatura
            let selectAsignaturaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.asignaturas.length; i++) {
                selectAsignaturaFilter += `<option value="${respuesta.asignaturas[i].nombre_asignatura}">${respuesta.asignaturas[i].nombre_asignatura}`;
            }
            form[2].innerHTML = selectAsignaturaFilter;

            //Select de tema
            let selectTemaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.temas.length; i++) {
                selectTemaFilter += `<option value="${respuesta.temas[i].nombre_tema}">${respuesta.temas[i].nombre_tema}`;
            }
            form[5].innerHTML = selectTemaFilter;
        }
    }
    ajax.send(formData);
}

function selectTema() {
    let form = document.getElementById("formSubirApuntes");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('nombre_asignatura', form[2].value);
    formData.append('nombre_curso', form[1].value);
    formData.append('nombre_centro', form[0].value);
    let ajax = llamadaAjax();
    ajax.open("POST", "misApuntes/asignatura", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            let selectTemaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.length; i++) {
                selectTemaFilter += `<option value="${respuesta[i].nombre_tema}">${respuesta[i].nombre_tema}`;
            }
            form[5].innerHTML = selectTemaFilter;
        }
    }
    ajax.send(formData);
}

function apuntesAjax() {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "misApuntes/apuntes", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            let recarga = "";
            recarga = `<tr>
                <th scope="col">Documento</th>
                <th scope="col">Fecha Publicacion</th>
            </tr>`;
            for (let i = 0; i < respuesta.length; i++) {
                recarga += `<tr>
                <td>${respuesta[i].nombre_contenido}${respuesta[i].extension_contenido}</td>
                <td>${respuesta[i].fecha_publicacion_contenido}</td>
                <td>
                    <button class="btn btn-light" type="submit" id="" onclick="eliminarApunte(${respuesta[i].id})">Eliminar</button>
                </td>
            </tr>`;
            }
            content.innerHTML = recarga;
        }
    }
    ajax.send(formData);
}

function subirApuntes() {
    let form = document.getElementById("formSubirApuntes");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData(form);
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "misApuntes/subirapunte", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                alertify.success('Apunte subido correctamente');
                form.reset();
                apuntesAjax();
            } else if (respuesta.resultado == "existApunte") {
                alertify.warning('El apunte ya existe cambie el nombre');
            } else if (respuesta.resultado == "nullTema") {
                alertify.error('Especifique tema');
            }
        }
    }
    ajax.send(formData);
}

function eliminarApunte(id) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    let ajax = llamadaAjax();
    ajax.open("POST", "misApuntes/eliminarapunte/" + id, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                alertify.success('Apunte eliminado correctamente');
                apuntesAjax();
            }
        }
    }
    ajax.send(formData);
}