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
    var formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('filter', document.getElementById("multiplysearch").value)
    var ajax = llamadaAjax();
    ajax.open("POST", "profesores/multiplyfilter", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                console.log(respuesta);
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/
                var recarga = '';
                recarga += `<table class="table table-striped table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Nombre Y Apellidos</th>
                    <th scope="col">Acciones</th>
                </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                    <td>${respuesta[i].id}</td>
                    <td><img src="storage/${respuesta[i].img_avatar}" width="50"></td>
                    <td>${respuesta[i].nombre_usu} ${respuesta[i].apellido_usu}</td>
                    <td><button class="boton_modificar" type="submit" onclick="mostrarEstudios(${respuesta[i].id});">Mostrar Estudios</button></td>;`
                    if (respuesta[i].nombre_curriculum != null) {
                        recarga += `<td><button class="boton_modificar" type="submit" onclick="mostrarCurriculum({{$Resultados->id}});">Mostrar Curriculum</button></td>`;
                    }
                    recarga += `<td><form  action="" method="GET">
                        <button class="boton_modificar" type="submit" id="">Contactar</button>
                    </form></td>
                </tr>`;
                }
                recarga += `</table>`;
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
                recarga += `<table class="table table-striped table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Nombre Y Apellidos</th>
                    <th scope="col">Acciones</th>
                </tr>`;
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `<tr>
                    <td>${respuesta[i].id}</td>
                    <td><img src="storage/${respuesta[i].img_avatar}" width="50"></td>
                    <td>${respuesta[i].nombre_usu} ${respuesta[i].apellido_usu}</td>
                    <td><button class="boton_modificar" type="submit" onclick="mostrarEstudios(${respuesta[i].id});">Mostrar Estudios</button></td>;`
                    if (respuesta[i].nombre_curriculum != null) {
                        recarga += `<td><button class="boton_modificar" type="submit" onclick="mostrarCurriculum({{$Resultados->id}});">Mostrar Curriculum</button></td>`;
                    }
                    recarga += `<td><button onclick="window.location.href = 'notehub-chat/${respuesta[i].uuid}'" class="boton_modificar" type="submit" id="">Contactar</button></td>
                </tr>`;
                }
                recarga += `</table>`;
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