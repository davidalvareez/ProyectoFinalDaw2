window.onload = function() {
    content = document.getElementById('contenedor');
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

//Filtro Múltiple
function multiplyFilter() {
    let checkbox = document.getElementsByName("cursos");
    for (let i = 0; i < checkbox.length; i++) {
        checkbox[i].checked = false;
    }
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('filter', document.getElementById("multiplysearch").value)
    var ajax = llamadaAjax();
    ajax.open("POST", "profesores/multiplyfilter", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                if (respuesta.length == 0) {
                    recarga += `<div class="no-results">No se han encontrado resultados</div>`;
                } else {
                    recarga += `<div class="container-grid">
                    <div class="grid-cartas">`;
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<div class="user-card">
                                        <div class="image-user">
                                            <img src="storage/${respuesta[i].img_avatar}" alt="">
                                        </div>
                                        <div class="name-surname">
                                            <span class="name">${respuesta[i].nombre_usu}</span>
                                            <span class="surname"> ${respuesta[i].apellido_usu}</span>
                                        </div>
                                        <div class="actions-user">
                                            <div class="two">
                                                <button class="btn-glass" onclick="mostrarEstudios(${respuesta[i].id});">Estudios</button>
                                                ${respuesta[i].nombre_curriculum != null
                                                    ? `<button class="btn-glass" type="submit" onclick="mostrarCurriculum(${respuesta[i].id});">Curriculum</button>`
                                                    : ``
                                                }
                                            </div>
                                            <div class="one">
                                                <button class="btn-glass" onclick="window.location.href = 'notehub-chat/${respuesta[i].uuid}'">Contactar</button>
                                            </div>
                                        </div>
                                    </div>`;
                    }
                    recarga += `</div>
                    </div>`;
                }
                content.innerHTML = recarga;
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}

//Función advancedFilterProfesores
function advancedFilterProfesores() {
    document.getElementById("multiplysearch").value = "";
    let cursos = document.getElementsByName("cursos");
    let arrayCursosChecked = [];
    for (let i = 0; i < cursos.length; i++) {
        if (cursos[i].checked) {
            arrayCursosChecked.push(cursos[i].value);
        }
    }
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('cursos', arrayCursosChecked);
    var ajax = llamadaAjax();
    ajax.open("POST", "profesores/advancedfilter", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                if (respuesta.length == 0) {
                    recarga += `<div class="no-results">No se han encontrado resultados</div>`;
                }else{
                    recarga += `<div class="container-grid">
                    <div class="grid-cartas">`;
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<div class="user-card">
                                        <div class="image-user">
                                            <img src="storage/${respuesta[i].img_avatar}" alt="">
                                        </div>
                                        <div class="name-surname">
                                            <span class="name">${respuesta[i].nombre_usu}</span>
                                            <span class="surname"> ${respuesta[i].apellido_usu}</span>
                                        </div>
                                        <div class="actions-user">
                                            <div class="two">
                                                <button class="btn-glass" onclick="mostrarEstudios(${respuesta[i].id});">Estudios</button>
                                                ${respuesta[i].nombre_curriculum != null
                                                    ? `<button class="btn-glass" type="submit" onclick="mostrarCurriculum(${respuesta[i].id});">Curriculum</button>`
                                                    : ``
                                                }
                                            </div>
                                            <div class="one">
                                                <button class="btn-glass" onclick="window.location.href = 'notehub-chat/${respuesta[i].uuid}'">Contactar</button>
                                            </div>
                                        </div>
                                    </div>`;
                    }
                    recarga += `</div>
                    </div>`;
                }
                content.innerHTML = recarga;
            }
        }
        /*
        send(string)->Sends the request to the server (used for POST)
        */
    ajax.send(formData)
}

function mostrarEstudios(id) {
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    var ajax = llamadaAjax();
    ajax.open("POST", "profesores/mostrarEstudios/" + id, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            /* Crear la estructura html que se devolverá dentro de una variable recarga*/
            var recarga = "";
            recarga += "<ul>";
            for (let i = 0; i < respuesta.length; i++) {
                recarga += `<li>${respuesta[i].nombre_curso}</li>`
            }
            recarga += "</ul>";
            swal.fire({
                title: "Lista de estudios",
                html: recarga,
                icon: "info"
            });
        }
    }
    ajax.send(formData)
}

function mostrarCurriculum(id) {
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    var ajax = llamadaAjax();
    ajax.open("POST", "profesores/mostrarCurriculum/" + id, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            /* Crear la estructura html que se devolverá dentro de una variable recarga*/
            var recarga = "";
            for (let i = 0; i < respuesta.length; i++) {
                recarga += `<iframe id="framePDF" src="storage/${respuesta[i].nombre_curriculum}" type="application/pdf"></iframe>`;
            }
            swal.fire({
                title: `Curriculum de  ${respuesta[0].nick_usu}`,
                html: recarga,
                icon: "info"
            });
        }
    }
    ajax.send(formData)
}