window.onload = function() {
    modalActualizar = document.getElementById("modalActualizar");
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
window.onclick = function(event) {
    if (event.target == modalActualizar) {
        modalActualizar.classList.add("hidden");
    }
}

function abrirModal() {
    modalActualizar.classList.remove("hidden")
}

function cerrarModal() {
    modalActualizar.classList.add("hidden")
}

function modalDatosUser() {
    let contenedor = document.getElementById("modalBox");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "actualizar", true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            var recarga = '';
            recarga += `
            <div class="cerrar-modal">
                <i class="fa-solid fa-xmark" onclick="cerrarModal();"></i>
            </div>
            <div class="contenido-modal">
                <div class="modal-first">
                    <div class="contenido">`
            for (let i = 0; i < respuesta.user.length; i++) {
                recarga += `
                    <div class="item etiqueta">
                        <div class="boton-item">
                            <form method="post" onsubmit="actualizarUser(); return false;" class="form-mod-perfil" id="editarPerfil">
                                <label>Nombre</label>
                                <input type="text" class="nombre-etiqueta-crear" name="nombre_usu" value="${respuesta.user[i].nombre_usu}" placeholder="Nombre...">
                                <label>Apellidos</label>
                                <input type="text" name="apellido_usu" value="${respuesta.user[i].apellido_usu}" placeholder="Apellidos...">
                                <label>Fecha Nacimiento</label>
                                <input type="date" name="fecha_nac_usu" value="${respuesta.user[i].fecha_nac_usu}">
                                <label>Correo</label>
                                <input type="text" name="correo_usu" value="${respuesta.user[i].correo_usu}" placeholder="Correo electrónico...">
                                <label>Contraseña</label>
                                <input type="password" name="contra_usu" placeholder="Contraseña...">
                                <label>Centro</label>
                                <input list="centros" autocomplete="off" name="nombre_centro" value="${respuesta.user[i].nombre_centro}" />
                                <datalist id="centros">`;
                for (z in respuesta.centros) {
                    recarga += `<option value="${respuesta.centros[z].nombre_centro}">`
                }
                recarga += `</datalist>
                                <input type="submit" value="Actualizar">
                            </form> 
                        </div> 
                    </div>`
            }
            recarga += `</div>
            </div>
            `;
            contenedor.innerHTML = recarga;
            abrirModal();
        }
    }
    ajax.send(formData);

}

function actualizarUser() {
    let contenedor = document.getElementById("menu-info-persona");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData(document.getElementById("editarPerfil"));
    formData.append('_token', token);
    formData.append('_method', 'PUT');
    let ajax = llamadaAjax();
    ajax.open("POST", "actualizarPUT", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                let recarga = "";
                for (let i = 0; i < respuesta.user.length; i++) {
                    recarga += `
                    <div class="div-info">${respuesta.user[i].nombre_usu} ${respuesta.user[0].apellido_usu}</div>
                    <div class="div-info">${respuesta.user[i].fecha_nac_usu}</div>
                    <div class="div-info">${respuesta.user[i].correo_usu}</div>
                    <div class="div-info">${respuesta.user[i].nombre_centro}</div>`;
                }
                alertify.success("Información cambiada correctamente");
                contenedor.innerHTML = recarga;
                cerrarModal();
            } else {
                console.log(respuesta.resultado)
                alertify.error("Ha ocurrido un error");
            }
        }
    }
    ajax.send(formData)
}