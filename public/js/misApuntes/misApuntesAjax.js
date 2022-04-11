window.onload = function() {
    content = document.getElementById('content');
    token = document.getElementById('token').getAttribute("content");
    let radioYes = document.getElementById('radioYes');
    let radioNo = document.getElementById('radioNo');
    radioYes.onclick = function() {
        document.getElementById('selectTema').style.display = 'none';
        document.getElementById('textNewTema').style.display = 'block';
    }
    radioNo.onclick = function() {
        document.getElementById('selectTema').style.display = 'block';
        document.getElementById('textNewTema').style.display = 'none';
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
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('nombre_curso', form[0].value);
    let ajax = llamadaAjax();
    ajax.open("POST", "misApuntes/curso", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            let selectAsignaturaFilter = `<option value="">--</option>`
            for (let i = 0; i < respuesta.length; i++) {
                selectAsignaturaFilter += `<option value="${respuesta[i].nombre_asignatura}">${respuesta[i].nombre_asignatura}`;
            }

            //Select de asignatura
            form[1].innerHTML = selectAsignaturaFilter;

            //Select de tema
            form[4].innerHTML = selectTemaFilter;
        }
    }
    ajax.send(formData);
}