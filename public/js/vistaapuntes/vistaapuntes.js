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

function addcomment(my_id) {
    let form = document.getElementById("formAddComment");
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData(form);
    let container = document.getElementById("comentarios");
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "comentar", true);
    ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                let respuesta = JSON.parse(this.responseText);
                console.log(respuesta);
                if (respuesta.resultado == "OK") {
                    let recarga = "";
                    for (let i = 0; i < respuesta.comentarios.length; i++) {
                        recarga += `<div>
                        <div>
                            <h4>${respuesta.comentarios[i].nick_usu}</h4>
                        </div>
                        <div class="comentario-imagen-box">
                            <img src="../storage/${respuesta.comentarios[i].img_avatar}" alt="avatar" class="comentario-imagen-usuario">
                        </div>
                        <div>
                            <label class="rating-label">
                                <input
                                class="rating-small"
                                max="5"
                                min="0"
                                oninput="this.style.setProperty('--value', this.value)"
                                step="0.5"
                                type="range"
                                value="${respuesta.comentarios[i].val_comentario}"
                                style="--value:${respuesta.comentarios[i].val_comentario}";"
                                disabled
                                >
                            </label>
                        </div>
                    </div>
                    ${respuesta.comentarios[i].id_usu != my_id
                        ? `<div>
                                <img src="../media/vistaapuntes/denuncia.png" onclick="denunciarComentario(${respuesta.comentarios[i].id_usu},${respuesta.comentarios[i].id},${respuesta.comentarios[i].id_contenido});" alt="" width="30px" height="30px" style="cursor: pointer">
                            </div>`
                        : ``
                        }
                    <div class="comentario-texto">
                        <p id="${respuesta.comentarios[i].id}">${respuesta.comentarios[i].desc_comentario}</p>
                    </div>`;
                }
                alertify.success('Comentario publicado correctamente');
                container.innerHTML = recarga;
            } else if (respuesta.resultado == "Comentado") {
                alertify.warning('Ya has comentado en este apunte');
            } else if (respuesta.resultado == "SAME") {
                alertify.error('No puedes comentarte a ti mismo');
            }
            form.reset();
        }
    }
    ajax.send(formData);
}

function denunciarComentario(id_usu_comentario, id_comentario, id_contenido) {
    Swal.fire({
        title: "Denunciar comentario",
        text: "Escribe motivo de denuncia",
        input: 'text',
        confirmButtonText: "Denunciar comentario",
        cancelButtonText: "Cancelar",
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            let token = document.getElementById('token').getAttribute("content");
            let formData = new FormData();
            formData.append('_token', token);
            formData.append('_method', 'POST');
            formData.append('id_acusado', id_usu_comentario);
            formData.append('id_comentario', id_comentario);
            formData.append('id_contenido', id_contenido);
            formData.append('desc_denuncia', result.value);
            let ajax = llamadaAjax();
            ajax.open("POST", "denunciarComentario", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "nullDenuncia") {
                        alertify.error("Escribe el motivo de denuncia");
                    } else if (respuesta.resultado == "existDenuncia") {
                        alertify.warning("Ya has denunciado este comentario");
                    } else if (respuesta.resultado == "OK") {
                        alertify.success("Denuncia enviada correctamente");
                    } else {
                        alertify.error(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
        }
    });
}

function denunciarApunte(id_usu_apunte, id_apunte) {
    Swal.fire({
        title: "Denunciar contenido",
        text: "Escribe motivo de denuncia",
        input: 'text',
        confirmButtonText: "Denunciar contenido",
        cancelButtonText: "Cancelar",
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            let token = document.getElementById('token').getAttribute("content");
            let formData = new FormData();
            formData.append('_token', token);
            formData.append('_method', 'POST');
            formData.append('id_acusado', id_usu_apunte);
            formData.append('id_contenido', id_apunte);
            formData.append('desc_denuncia', result.value);
            let ajax = llamadaAjax();
            ajax.open("POST", "denunciarApunte", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "nullDenuncia") {
                        alertify.error("Escribe el motivo de denuncia");
                    } else if (respuesta.resultado == "existDenuncia") {
                        alertify.warning("Ya has denunciado este apunte");
                    } else if (respuesta.resultado == "OK") {
                        alertify.success("Denuncia enviada correctamente");
                    } else {
                        alertify.error(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
        }
    });
}