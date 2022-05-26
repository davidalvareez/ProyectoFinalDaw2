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
        modalActualizar.style.display = 'none';
    }
}

function abrirModal() {
    modalActualizar.style.display = 'block';
}

function cerrarModal() {
    modalActualizar.style.display = 'none';
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
            <div class="contenido-modal">`
            for (let i = 0; i < respuesta.user.length; i++) {
                recarga += `
                            <form class="formmodal" method="post" onsubmit="actualizarUser(); return false;" class="form-mod-perfil" id="editarPerfil">
                                <span class="close" onclick="cerrarModal();">&times;</span>    
                                <input type="text" name="nick_usu" value="${respuesta.user[i].nick_usu}" placeholder="NickName...">
                                <input type="text" class="nombre-etiqueta-crear" name="nombre_usu" value="${respuesta.user[i].nombre_usu}" placeholder="Nombre...">
                                <input type="text" name="apellido_usu" value="${respuesta.user[i].apellido_usu}" placeholder="Apellidos...">
                                <input type="date" name="fecha_nac_usu" value="${respuesta.user[i].fecha_nac_usu}">
                                <input type="text" name="correo_usu" value="${respuesta.user[i].correo_usu}" placeholder="Correo electrónico...">
                                <input type="password" name="contra_usu" placeholder="Contraseña...">
                                <input list="centros" autocomplete="off" name="nombre_centro" value="${respuesta.user[i].nombre_centro}" />
                                <datalist id="centros">`;
                for (z in respuesta.centros) {
                    recarga += `<option value="${respuesta.centros[z].nombre_centro}">`
                }
                recarga += `</datalist>
                                <input type="submit" value="Actualizar">
                            </form>`
            }
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
            } else if (respuesta.resultado == "existNick") {
                alertify.error("Ya existe un nick");
            } else if (respuesta.resultado == "existEmail") {
                alertify.error("Ya existe un correo");
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
    document.getElementById("img_avatar_usu").value = null;
}

function deselectAvatar() {
    allAvatar = document.getElementsByClassName("elegiravatar");
    for (let i = 0; i < allAvatar.length; i++) {
        allAvatar[i].style.border = "white";

    }
    document.getElementById("img_avatar_sistema").value = null;
    document.getElementById("img_avatar_sistema_profe").value = null;
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
function getConfigUser() {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "getConfigUser", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            recarga = '';
            if (respuesta.configuration == null) {
                recarga += `<input list="cursos" autocomplete="off" name="nombre_curso" id="nombre_curso"/>`
            } else {
                recarga += `<input list="cursos" autocomplete="off" name="nombre_curso" id="nombre_curso" value="${respuesta.configuration}" />`
            }
            recarga += `<datalist id="cursos">`;
            for (z in respuesta.cursos) {
                recarga += `<option value="${respuesta.cursos[z].nombre_curso}">`
            }
            recarga += `</datalist>`;
            Swal.fire({
                title: '¿Que estas cursando?',
                html: recarga,
                showCancelButton: true,
                confirmButtonText: 'Cambiar configuracion',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    changeConfigUser();
                }
            })
        }
    }
    ajax.send(formData);
}

function changeConfigUser() {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    formData.append('nombre_curso', document.getElementById('nombre_curso').value);
    let ajax = llamadaAjax();
    ajax.open("POST", "changeConfigUser", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                alertify.success("Configuracion cambiada correctamente");
            }
        }
    }
    ajax.send(formData);
}

function darsedeBaja() {
    Swal.fire({
        title: "Darse de baja",
        text: "Introduce tu contraseña",
        input: 'password',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            let token = document.getElementById('token').getAttribute("content");
            let formData = new FormData();
            formData.append('_token', token);
            formData.append('_method', 'DELETE');
            formData.append('contra_usu', result.value);
            let ajax = llamadaAjax();
            ajax.open("POST", "darseDeBaja", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "IncorrectPassword") {
                        alertify.error("Contraseña incorrecta");
                    } else if (respuesta.resultado == "OK") {
                        window.location.href = respuesta.redirect;
                    } else {
                        alertify.error(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
        }
    });
}

function insertCurriculum() {
    Swal.fire({
        title: 'Inserta curriculum',
        showCancelButton: true,
        confirmButtonText: 'Subir curriculum',
        cancelButtonText: 'Cancelar',
        input: 'file',
    }).then((file) => {
        if (file.value) {
            let token = document.getElementById('token').getAttribute("content");
            let formData = new FormData();
            formData.append('_token', token);
            formData.append('_method', 'POST');
            formData.append("fileupload", file.value);
            let ajax = llamadaAjax();
            ajax.open("POST", "uploadCV", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "OK") {
                        alertify.success("Curriculum insertado correctamente");
                    } else {
                        alertify.error(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
        }
    })
}

function updateCurriculum() {
    Swal.fire({
        title: 'Actualiza curriculum',
        showCancelButton: true,
        confirmButtonText: 'Subir curriculum',
        cancelButtonText: 'Cancelar',
        input: 'file',
    }).then((file) => {
        if (file.value) {
            let token = document.getElementById('token').getAttribute("content");
            let formData = new FormData();
            formData.append('_token', token);
            formData.append('_method', 'POST');
            formData.append("fileupload", file.value);
            let ajax = llamadaAjax();
            ajax.open("POST", "uploadCV", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "OK") {
                        alertify.success("Curriculum actualizado correctamente");
                    } else if (respuesta.resultado == "failExtension") {
                        alertify.error("Tienes que subir un archivo PDF");
                    } else {
                        alertify.error(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
        }
    })
}

function getConfigEstudios() {
    Swal.fire({
        title: "Opciones estudios",
        text: "¿Que deseas hacer?",
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: "Agregar estudios",
        denyButtonText: "Quitar estudios",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            //Mostramos los estudios que puede añadir
            let token = document.getElementById('token').getAttribute("content");
            let formData = new FormData();
            formData.append('_token', token);
            formData.append('_method', 'POST');
            formData.append("add_delete_study", true);
            let ajax = llamadaAjax();
            ajax.open("POST", "showStudies", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    recarga = '';
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<div class="swal-estudios">
                        <input type="checkbox" name="cursos" value="${respuesta[i].id}">
                        <label name="${respuesta[i].nombre_curso}">${respuesta[i].nombre_curso}</label>
                        </div>`;
                    }
                    Swal.fire({
                        title: "Agregar estudios",
                        html: recarga,
                        showCancelButton: true,
                        confirmButtonText: "Agregar",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let token = document.getElementById('token').getAttribute("content");
                            let formData = new FormData();
                            let cursos = document.getElementsByName("cursos");
                            let arrayCursosChecked = [];
                            for (let i = 0; i < cursos.length; i++) {
                                if (cursos[i].checked) {
                                    arrayCursosChecked.push(cursos[i].value);
                                }
                            }
                            formData.append('_token', token);
                            formData.append('_method', 'POST');
                            formData.append("cursos", arrayCursosChecked);
                            let ajax = llamadaAjax();
                            ajax.open("POST", "addStudies", true);
                            ajax.onreadystatechange = function() {
                                if (ajax.readyState == 4 && ajax.status == 200) {
                                    let respuesta = JSON.parse(this.responseText);
                                    if (respuesta.resultado == "OK") {
                                        alertify.success("Estudios agregados correctamente");
                                    } else if (respuesta.resultado == "nullCursos") {
                                        alertify.error("Tienes que seleccionar curso");
                                    } else {
                                        alertify.error("Ha ocurrido un error");
                                    }
                                }
                            }
                            ajax.send(formData)
                        }
                    });
                }
            }
            ajax.send(formData);
        } else if (result.isDenied) {
            //Mostramos los estudios que tiene asignados para eliminar
            let token = document.getElementById('token').getAttribute("content");
            let formData = new FormData();
            formData.append('_token', token);
            formData.append('_method', 'POST');
            formData.append("add_delete_study", false);
            let ajax = llamadaAjax();
            ajax.open("POST", "showStudies", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    recarga = '';
                    for (let i = 0; i < respuesta.length; i++) {
                        recarga += `<div class="swal-estudios">
                        <input type="checkbox" name="cursos" value="${respuesta[i].id}">
                        <label name="${respuesta[i].nombre_curso}">${respuesta[i].nombre_curso}</label>
                        </div>`;
                    }
                    Swal.fire({
                        title: "Eliminar estudios",
                        html: recarga,
                        showCancelButton: true,
                        confirmButtonText: "Eliminar",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let token = document.getElementById('token').getAttribute("content");
                            let formData = new FormData();
                            let cursos = document.getElementsByName("cursos");
                            let arrayCursosChecked = [];
                            for (let i = 0; i < cursos.length; i++) {
                                if (cursos[i].checked) {
                                    arrayCursosChecked.push(cursos[i].value);
                                }
                            }
                            formData.append('_token', token);
                            formData.append('_method', 'DELETE');
                            formData.append("cursos", arrayCursosChecked);
                            let ajax = llamadaAjax();
                            ajax.open("POST", "deleteStudies", true);
                            ajax.onreadystatechange = function() {
                                if (ajax.readyState == 4 && ajax.status == 200) {
                                    let respuesta = JSON.parse(this.responseText);
                                    if (respuesta.resultado == "OK") {
                                        alertify.success("Estudios eliminados correctamente");
                                    } else if (respuesta.resultado == "nullCursos") {
                                        alertify.error("Tienes que seleccionar curso");
                                    } else {
                                        alertify.error("Ha ocurrido un error");
                                    }
                                }
                            }
                            ajax.send(formData)
                        }
                    });
                }
            }
            ajax.send(formData);
        }
    })
}




$(document).ready(function() {
    $('.owl-carousel-1').owlCarousel({
        loop: false,
        margin: 10,
        items: 4,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })
});