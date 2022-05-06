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
                                <label>NickName</label>
                                <input type="text" name="nick_usu" value="${respuesta.user[i].nick_usu}" placeholder="NickName...">
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
    let nickname = document.getElementById("NickName");
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
                let recargaNick = "";
                for (let i = 0; i < respuesta.user.length; i++) {
                    recarga += `
                    <div class="div-info">${respuesta.user[i].nombre_usu} ${respuesta.user[0].apellido_usu}</div>
                    <div class="div-info">${respuesta.user[i].fecha_nac_usu}</div>
                    <div class="div-info">${respuesta.user[i].correo_usu}</div>
                    <div class="div-info">${respuesta.user[i].nombre_centro}</div>`;
                    recargaNick += respuesta.user[i].nick_usu;
                }
                alertify.success("Información cambiada correctamente");
                contenedor.innerHTML = recarga;
                nickname.innerText = recargaNick;
                cerrarModal();
            } else {
                console.log(respuesta.resultado)
                alertify.error("Ha ocurrido un error");
            }
        }
    }
    ajax.send(formData)
}

/* Cambiar Avatar*/
function modalbox() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

function avatarSelected(img_avatar) {
    document.getElementById("img_avatar_sistema").value = img_avatar;
    console.log(document.getElementById("img_avatar_sistema").value);
}

function chBackcolor(avatar) {
    allAvatar = document.getElementsByClassName("elegiravatar");
    for (let i = 0; i < allAvatar.length; i++) {
        allAvatar[i].style.border = "white";

    }
    avatar.style.border = "1px solid #000";
}

function hasAvatarOrImage() {
    let avatar = document.getElementById("img_avatar_sistema").value;
    let image = document.getElementById("img_avatar_usu").files;

    if (avatar == "" && image.length == 0) {
        alert("Selecciona avatar o imagen");
        return false;
    } else {
        return true;
    }
}

function actualizarAvatarUsu() {

    let contenedor = document.getElementById("imgAvatar");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData(document.getElementById("editarAvatar"));
    formData.append('_token', token);
    formData.append('_method', 'PUT');
    let ajax = llamadaAjax();
    ajax.open("POST", "actualizarAvatar", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                let recarga = "";
                for (let i = 0; i < respuesta.user.length; i++) {
                    recarga += `../storage/${respuesta.user[i].img_avatar}`;
                }
                alertify.success("Avatar cambiado correctamente");
                contenedor.src = recarga;
                closeModal();
            } else {
                console.log(respuesta.resultado)
                alertify.error("Ha ocurrido un error");
                closeModal2();
            }
        }
    }
    ajax.send(formData)
}
/*CONFIGURACIÓN USER*/
function openModalConfig() {
    let modalConfiguracion = document.getElementById("modalConfiguracion");
    modalConfiguracion.style.display = "block";
}

function closeModalConfig() {
    let modalConfiguracion = document.getElementById("modalConfiguracion");
    modalConfiguracion.style.display = "none";
}

function getConfigUser() {
    let modalConfiguracionRecarga = document.getElementById("modalBoxConfiguracion")
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "getConfigUser", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            console.log(respuesta);
            let recarga = "";
            recarga += `
            <span class="close" onclick="closeModalConfig();">&times;</span>
            <div class="">
                <div class="">
                    <div class="">
                    <div class="">
                        <div class="">
                            <form method="post" onsubmit="changeConfigUser(); return false;" class="" id="changeConfig">`
            if (respuesta.configuration == null) {
                recarga += `<input list="cursos" autocomplete="off" name="nombre_curso"/>`
            } else {
                recarga += `<input list="cursos" autocomplete="off" name="nombre_curso" value="${respuesta.configuration}" />`
            }
            recarga += `<datalist id="cursos">`;
            for (z in respuesta.cursos) {
                recarga += `<option value="${respuesta.cursos[z].nombre_curso}">`
            }
            recarga += `</datalist>
                                            <input type="submit" value="Cambiar configuración">
                                        </form> 
                                    </div> 
                                </div>
                            </div>
                        </div>`
            modalConfiguracionRecarga.innerHTML = recarga;
        }
    }
    ajax.send(formData);
}

function changeConfigUser() {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData(document.getElementById('changeConfig'));
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "changeConfigUser", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                alertify.success("Configuracion cambiada correctamente");
                closeModalConfig();
            }
        }
    }
    ajax.send(formData);
}