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

function openformSubirApuntes() {
    document.getElementById("divFormSubirApuntes").style.display = "block";
}

function selectAsignatura() {
    let form = document.getElementById("formSubirApuntes");
    let token = document.getElementById('token').getAttribute("content");
    let id_centro = document.getElementById('id_centro').value;
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('nombre_curso', form[0].value);
    formData.append('id_centro', id_centro);
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
            form[1].innerHTML = selectAsignaturaFilter;

            //Select de tema
            let selectTemaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.temas.length; i++) {
                selectTemaFilter += `<option value="${respuesta.temas[i].nombre_tema}">${respuesta.temas[i].nombre_tema}`;
            }
            form[4].innerHTML = selectTemaFilter;
        }
    }
    ajax.send(formData);
}

function selectTema() {
    let form = document.getElementById("formSubirApuntes");
    let token = document.getElementById('token').getAttribute("content");
    let id_centro = document.getElementById('id_centro').value;
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('nombre_asignatura', form[1].value);
    formData.append('id_centro', id_centro);
    let ajax = llamadaAjax();
    ajax.open("POST", "misApuntes/asignatura", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            let selectTemaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.length; i++) {
                selectTemaFilter += `<option value="${respuesta[i].nombre_tema}">${respuesta[i].nombre_tema}`;
            }
            form[4].innerHTML = selectTemaFilter;
        }
    }
    ajax.send(formData);
}

function subirApuntes() {

}