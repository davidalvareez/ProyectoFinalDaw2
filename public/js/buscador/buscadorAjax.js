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
                var recarga = '';
                if (respuesta.length == 0) {
                    recarga += `
                    <h2>No se han encontrado apuntes... :(</h2>`
                } else {
                    recarga += `<div class="title">
                        <h2>Apuntes Filtrados</h2>
                    </div>
                    <div class="region-news">
                        <div class="content-news">
                            <div class="resultados">
                                <div class="owl-carousel owl-carousel-3">`;
                    for (let i = 0; i < respuesta.length; i++) {
                        split_img = respuesta[i].img_avatar.split(':');
                        recarga += `<div class="card resultado card-resultado">
                                        <div class="container">
                                            <div class="front-card">
                                                <div class="container-front">
                                                    <div class="foto img img-apuntes">
                                                        <div class="container-foto container-img">`
                        if (respuesta[i].extension_contenido == ".pdf") {
                            if (respuesta[i].id_tema != null) {
                                recarga += `<img class="img foto prev-apunt" src="storage/uploads/apuntes/${respuesta[i].nombre_centro}/${respuesta[i].nombre_curso}/${respuesta[i].nombre_asignatura}/${respuesta[i].nombre_tema}/${respuesta[i].nombre_contenido}.png" alt="Apuntes">`
                            } else {
                                recarga += `<img class="img foto prev-apunt" src="storage/uploads/apuntes_reciclados/${respuesta[i].nombre_contenido}.png" alt="Apuntes">`
                            }
                        } else {
                            if (respuesta[i].id_tema != null) {
                                recarga += `<img class="img foto prev-apunt" src="storage/uploads/apuntes/${respuesta[i].nombre_centro}/${respuesta[i].nombre_curso}/${respuesta[i].nombre_asignatura}/${respuesta[i].nombre_tema}/${respuesta[i].nombre_contenido}${respuesta[i].extension_contenido}" alt="Apuntes">`
                            } else {
                                recarga += `<img class="img foto prev-apunt" src="storage/uploads/apuntes_reciclados/${respuesta[i].nombre_contenido}.png" alt="Apuntes">`
                            }
                        }
                        recarga += `</div>
                                                    </div>
                                                    <div class="header-apuntes">
                                                        <div class="name-content">
                                                            <h3 class="name-content_text"><span class="">${respuesta[i].nombre_contenido}</span></h3>
                                                        </div>`
                        if (respuesta[i].nombre_centro != null) {
                            recarga += `<div class="centro info-centro">
                                                                <p><span class="icon-centro"><i class="fa-duotone fa-school"></i></span> <span class="centro">${respuesta[i].nombre_centro}</span></p>
                                                            </div>`
                        }
                        recarga += ` <div class="id-content">
                                                            <small class="name-content_text"><span class="">#${respuesta[i].id_content}</span></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="reverse-card">
                                                <div class="container-reverse">
                                                    <div class="top">
                                                        <div class="user-info left-top">
                                                            <div class="container-info">
                                                                <div class="avatar-user user-img">
                                                                    <div class="filter">
                                                                    ${split_img[0] == 'https' || split_img[0] == 'http'
                                                                        ? `<img src="${respuesta[i].img_avatar}" onclick="window.location.href='perfil/${respuesta[i].nick_usu}'" alt="" class="avatarimg">`
                                                                        : `<img src="storage/${respuesta[i].img_avatar}" onclick="window.location.href='perfil/${respuesta[i].nick_usu}'" alt="" class="avatarimg">`
                                                                        }
                                                                    </div>
                                                                </div>
                                                                <div class="container-text">
                                                                    <div class="username">
                                                                        <p><span onclick="window.location.href='perfil/${respuesta[i].nick_usu}'">${respuesta[i].nick_usu}</span></p>
                                                                    </div>
                                                                    <div class="column-2">
                                                                    ${respuesta[i].valoracion != null
                                                                        ? `<div class="stars">
                                                                                <p><span class="icon-stars"><i class="fa-duotone fa-meteor"></i></span> <span class="stars_text">${respuesta[i].valoracion}</span></p>
                                                                            </div>`
                                                                        : ``
                                                                        }
                                                                        <div class="down info-stats">
                                                                            <p><span class="icon-stats"><i class="fa-duotone fa-download"></i></span> <span class="stats_text">${respuesta[i].descargas}</span></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="date-info left-right">
                                                                <div class="date">
                                                                    <p><span class="icon-date"><i class="fa-duotone fa-calendar-days"></i></span> <span class="date-text">${respuesta[i].fecha_publicacion_contenido}</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bottom">
                                                        <div class="content-info">
                                                            <div class="name-content">
                                                                <h4 class="name-content_text"><span class="">${respuesta[i].nombre_contenido}</span></h4>
                                                            </div>`
                        if (respuesta[i].id_tema != null) {
                            recarga += `<div class="school-content">
                                                <p class="school-content_text"><span class="">${respuesta[i].nombre_centro}</span></p>
                                            </div>
                                            <div class="class-content">
                                                <p class="class-content_text"><span class="">${respuesta[i].nombre_asignatura}</span></p>
                                            </div>
                                            <div class="unit-content">
                                                <p class="unit-content_text"><span class="">${respuesta[i].nombre_tema}</span></p>
                                            </div>`;
                        }
                        recarga += `
                                                        </div>
                                                        <div class="buttons-actions">
                                                            <div class="go-button">
                                                                <button><a href="apuntes/${respuesta[i].id_content}"><i class="fa-duotone fa-chevrons-right"></i>Ir a la pagina</a></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                    }
                    recarga += `</div>
                            </div>
                        </div>
                    </div>`;
                }
                /* Crear la estructura html que se devolverá dentro de una variable recarga*/


                content.innerHTML = recarga;
                $('.owl-carousel-3').owlCarousel({
                        loop: false,
                        margin: 10,
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
                if (respuesta.length == 0) {
                    recarga += `<h2>No se han encontrado apuntes... :(</h2>`
                } else {
                    recarga += `<div class="title">
                    <h2>Apuntes filtrados</h2>
                </div>
                <div class="region-news">
                    <div class="content-news">
                        <div class="resultados">
                            <div class="owl-carousel owl-carousel-3">`;
                    for (let i = 0; i < respuesta.length; i++) {
                        split_img = respuesta[i].img_avatar.split(':');
                        recarga += `<div class="card resultado card-resultado">
                                            <div class="container">
                                                <div class="front-card">
                                                    <div class="container-front">
                                                        <div class="foto img img-apuntes">
                                                            <div class="container-foto container-img">`
                        if (respuesta[i].extension_contenido == ".pdf") {
                            if (respuesta[i].id_tema != null) {
                                recarga += `<img class="img foto prev-apunt" src="storage/uploads/apuntes/${respuesta[i].nombre_centro}/${respuesta[i].nombre_curso}/${respuesta[i].nombre_asignatura}/${respuesta[i].nombre_tema}/${respuesta[i].nombre_contenido}.png" alt="Apuntes">`
                            } else {
                                recarga += `<img class="img foto prev-apunt" src="storage/uploads/apuntes_reciclados/${respuesta[i].nombre_contenido}.png" alt="Apuntes">`
                            }
                        } else {
                            if (respuesta[i].id_tema != null) {
                                recarga += `<img class="img foto prev-apunt" src="storage/uploads/apuntes/${respuesta[i].nombre_centro}/${respuesta[i].nombre_curso}/${respuesta[i].nombre_asignatura}/${respuesta[i].nombre_tema}/${respuesta[i].nombre_contenido}${respuesta[i].extension_contenido}" alt="Apuntes">`
                            } else {
                                recarga += `<img class="img foto prev-apunt" src="storage/uploads/apuntes_reciclados/${respuesta[i].nombre_contenido}.png" alt="Apuntes">`
                            }
                        }
                        recarga += `</div>
                                                        </div>
                                                        <div class="header-apuntes">
                                                            <div class="name-content">
                                                                <h3 class="name-content_text"><span class="">${respuesta[i].nombre_contenido}</span></h3>
                                                            </div>`
                        if (respuesta[i].nombre_centro != null) {
                            recarga += `<div class="centro info-centro">
                                                                    <p><span class="icon-centro"><i class="fa-duotone fa-school"></i></span> <span class="centro">${respuesta[i].nombre_centro}</span></p>
                                                                </div>`
                        }
                        recarga += ` <div class="id-content">
                                                                <small class="name-content_text"><span class="">#${respuesta[i].id_content}</span></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                 
                                                <div class="reverse-card">
                                                    <div class="container-reverse">
                                                        <div class="top">
                                                            <div class="user-info left-top">
                                                                <div class="container-info">
                                                                    <div class="avatar-user user-img">
                                                                        <div class="filter">
                                                                        ${split_img[0] == 'https' || split_img[0] == 'http'
                                                                        ? `<img src="${respuesta[i].img_avatar}" onclick="window.location.href='perfil/${respuesta[i].nick_usu}'" alt="" class="avatarimg">`
                                                                        : `<img src="storage/${respuesta[i].img_avatar}" onclick="window.location.href='perfil/${respuesta[i].nick_usu}'" alt="" class="avatarimg">`
                                                                        }
                                                                        </div>
                                                                    </div>
                                                                    <div class="container-text">
                                                                        <div class="username">
                                                                            <p><span onclick="window.location.href='perfil/${respuesta[i].nick_usu}'">${respuesta[i].nick_usu}</span></p>
                                                                        </div>
                                                                        <div class="column-2">
                                                                        ${respuesta[i].valoracion != null
                                                                            ? `<div class="stars">
                                                                                    <p><span class="icon-stars"><i class="fa-duotone fa-meteor"></i></span> <span class="stars_text">${respuesta[i].valoracion}</span></p>
                                                                                </div>`
                                                                            : ``
                                                                            }
                                                                            <div class="down info-stats">
                                                                                <p><span class="icon-stats"><i class="fa-duotone fa-download"></i></span> <span class="stats_text">${respuesta[i].descargas}</span></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="date-info left-right">
                                                                    <div class="date">
                                                                        <p><span class="icon-date"><i class="fa-duotone fa-calendar-days"></i></span> <span class="date-text">${respuesta[i].fecha_publicacion_contenido}</span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bottom">
                                                            <div class="content-info">
                                                                <div class="name-content">
                                                                    <h4 class="name-content_text"><span class="">${respuesta[i].nombre_contenido}</span></h4>
                                                                </div>`
                        if (respuesta[i].id_tema != null) {
                            recarga += `<div class="school-content">
                                                    <p class="school-content_text"><span class="">${respuesta[i].nombre_centro}</span></p>
                                                </div>
                                                <div class="class-content">
                                                    <p class="class-content_text"><span class="">${respuesta[i].nombre_asignatura}</span></p>
                                                </div>
                                                <div class="unit-content">
                                                    <p class="unit-content_text"><span class="">${respuesta[i].nombre_tema}</span></p>
                                                </div>`;
                        }
                        recarga += `
                                                            </div>
                                                            <div class="buttons-actions">
                                                                <div class="go-button">
                                                                    <button><a href="apuntes/${respuesta[i].id_content}"><i class="fa-duotone fa-chevrons-right"></i>Ir a la pagina</a></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                    }
                    recarga += `</div>
                                </div>
                            </div>
                        </div>`;
                }

                content.innerHTML = recarga;
                $('.owl-carousel-3').owlCarousel({
                        loop: false,
                        margin: 10,
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