window.onload = function() {
    contenedor = window.document.getElementById("content");
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

function showAll() {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "moderador/denuncias", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            recarga = "";
            recarga += `<div class="table-responsive">
            <table class="table table-striped">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tipo</th>
                <th scope="col">Descripción</th>
                <th scope="col">Acusado</th>
                <th scope="col">Demandante</th>
                <th scope="col" colspan="3">Acciones</th>
            </tr>`;
            if (respuesta.length == 0) {
                recarga += `<h1>No se han encontrado registros...</h1>`
            } else {
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += ` <tr>
                    <td scope="row"><b>${respuesta[i].id}</b></td>
                    <td>${respuesta[i].tipus_denuncia}</td>
                    <td>${respuesta[i].desc_denuncia}</td>
                    <td>${respuesta[i].acusado}</td>
                    <td>${respuesta[i].demandante}</td>
                    <td><button class="btn btn-secondary" type="submit" value="Edit" onclick="opciones(${respuesta[i].id},'${respuesta[i].nick_acusado}');return false;">Opciones</button></td>
                    <td><button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminar(${respuesta[i].id},'${respuesta[i].nick_demandante}');return false;">Eliminar</button></td>`
                    if (respuesta[i].tipus_denuncia == "Comentario") {
                        recarga += `<td><button class= "btn btn-warning" type="submit" value="Ver comentario" onclick="window.location.href='apuntes/${respuesta[i].id_contenido}#${respuesta[i].id}';return false;">Ver comentario</button></td>`;
                    } else {
                        recarga += `<td><button class= "btn btn-warning" type="submit" value="Ver apunte" onclick="window.location.href='apuntes/${respuesta[i].id_contenido}';return false;">Ver apunte</button></td>`;
                    }
                    recarga += `</tr>`;
                }
            }
            recarga += `</table>
                        </div>`;
            contenedor.innerHTML = recarga;
        }
    }
    ajax.send(formData);
}

function showComments() {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "moderador/comments", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            recarga = "";
            recarga += `<div class="table-responsive">
            <table class="table table-striped">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tipo</th>
                <th scope="col">Descripción</th>
                <th scope="col">Acusado</th>
                <th scope="col">Demandante</th>
                <th scope="col" colspan="3">Acciones</th>
            </tr>`;
            if (respuesta.length == 0) {
                recarga += `<h1>No se han encontrado registros...</h1>`
            } else {
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += ` <tr>
                    <td scope="row"><b>${respuesta[i].id}</b></td>
                    <td>${respuesta[i].tipus_denuncia}</td>
                    <td>${respuesta[i].desc_denuncia}</td>
                    <td>${respuesta[i].acusado}</td>
                    <td>${respuesta[i].demandante}</td>
                    <td><button class="btn btn-secondary" type="submit" value="Edit" onclick="opcionesComentario(${respuesta[i].id},'${respuesta[i].nick_acusado}');return false;">Opciones</button></td>
                    <td><button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminarComentario(${respuesta[i].id},'${respuesta[i].nick_demandante}');return false;">Eliminar</button></td>
                    <td><button class= "btn btn-warning" type="submit" value="Ver comentario" onclick="window.location.href='apuntes/${respuesta[i].id_contenido}#${respuesta[i].id}';return false;">Ver comentario</button></td>
                    </tr>`;
                }
            }
            recarga += `</table>
                    </div>`;
            contenedor.innerHTML = recarga;
        }
    }
    ajax.send(formData);
}

function showNotes() {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = llamadaAjax();
    ajax.open("POST", "moderador/notes", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            recarga = "";
            recarga += `<div class="table-responsive">
            <table class="table table-striped">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tipo</th>
                <th scope="col">Descripción</th>
                <th scope="col">Acusado</th>
                <th scope="col">Demandante</th>
                <th scope="col" colspan="2">Acciones</th>
            </tr>`;
            if (respuesta.length == 0) {
                recarga += `<h1>No se han encontrado registros...</h1>`
            } else {
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += ` <tr>
                    <td scope="row"><b>${respuesta[i].id}</b></td>
                    <td>${respuesta[i].tipus_denuncia}</td>
                    <td>${respuesta[i].desc_denuncia}</td>
                    <td>${respuesta[i].acusado}</td>
                    <td>${respuesta[i].demandante}</td>
                    <td><button class="btn btn-secondary" type="submit" value="Edit" onclick="opcionesApunte(${respuesta[i].id},'${respuesta[i].nick_acusado}');return false;">Opciones</button></td>
                    <td><button class= "btn btn-danger" type="submit" value="Delete" onclick="eliminarApunte(${respuesta[i].id},'${respuesta[i].nick_demandante}');return false;">Eliminar</button></td>
                    <td><button class= "btn btn-warning" type="submit" value="Ver apunte" onclick="window.location.href='apuntes/${respuesta[i].id_contenido}';return false;">Ver apunte</button></td>
                    </tr>`;
                }
                recarga += `</table>
                </div>`;
            }
            contenedor.innerHTML = recarga;
        }
    }
    ajax.send(formData);
}

function opciones(id_denuncia, acusado) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    formData.append('id_denuncia', id_denuncia);
    formData.append('nick_usu', acusado);
    let ajax = llamadaAjax();
    Swal.fire({
        title: "Opciones denuncia",
        text: "¿Que deseas hacer?",
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: "Eliminar contenido",
        denyButtonText: "Banear usuario",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        //Elimina el contenido despues del ajax ejecutamos el swal
        if (result.isConfirmed) {
            ajax.open("POST", "moderador/eliminarcontent", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "OK") {
                        alertify.success("Contenido eliminado correctamente");
                        //Preguntamos si tambien quiere banear al usuario
                        Swal.fire({
                            title: "Opciones denuncia",
                            text: "¿Deseas tambien denunciar al usuario?",
                            showCancelButton: true,
                            confirmButtonText: "Banear usuario",
                            cancelButtonText: "Cancelar"
                        }).then((result) => {
                            //Si quiere denunciar al usuario le mostramos un input en formato fecha ya que cogemos la hora actual del sistema
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "Opciones denuncia",
                                    text: "¿Hasta que día desea banearlo?",
                                    html: `<input type="date" id="fecha_denuncia"/>`,
                                    showCancelButton: true,
                                    confirmButtonText: "Enviar",
                                    cancelButtonText: "Cancelar",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        fechaDenuncia = document.getElementById("fecha_denuncia").value;
                                        formData.append("fecha_denuncia", fechaDenuncia);
                                        ajax.open("POST", "moderador/banearUser", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                let respuesta = JSON.parse(this.responseText);
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("Baneo realizado correctamente");
                                                    showAll();
                                                } else {
                                                    console.log(respuesta.resultado);
                                                }
                                            }
                                        }
                                        ajax.send(formData);
                                    }
                                });
                            } else if (result.isDismissed) {
                                showAll();
                            }
                        });
                    } else {
                        console.log(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
            //Decide banear
        } else if (result.isDenied) {
            Swal.fire({
                title: "Opciones denuncia",
                text: "¿Hasta que día desea banearlo?",
                html: `<input type="date" id="fecha_denuncia"/>`,
                showCancelButton: true,
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    //Ejecutamos ajax para banear
                    fechaDenuncia = document.getElementById("fecha_denuncia").value;
                    formData.append("fecha_denuncia", fechaDenuncia);
                    ajax.open("POST", "moderador/banearUser", true);
                    ajax.onreadystatechange = function() {
                        if (ajax.readyState == 4 && ajax.status == 200) {
                            let respuesta = JSON.parse(this.responseText);
                            if (respuesta.resultado == "OK") {
                                alertify.success("Baneo realizado correctamente");
                                //Preguntamos si tambien quiere eliminar el contenido
                                Swal.fire({
                                    title: "Opciones denuncia",
                                    text: "¿Deseas tambien eliminar el contenido?",
                                    showCancelButton: true,
                                    confirmButtonText: "Eliminar contenido",
                                    cancelButtonText: "Cancelar"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        ajax.open("POST", "moderador/eliminarcontent", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("Contenido eliminado correctamente");
                                                    showAll();
                                                }
                                            } else {
                                                console.log(respuesta.resultado);
                                            }
                                        }
                                        ajax.send(formData);
                                    } else if (result.isDismissed) {
                                        ajax.open("POST", "moderador/quitardenuncia", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("La denuncia se ha quitado");
                                                    showAll();
                                                } else {
                                                    console.log(respuesta.resultado);
                                                }
                                            }
                                        }
                                        ajax.send(formData);
                                    }
                                });
                            } else {
                                console.log(respuesta.resultado);
                            }
                        }
                    }
                    ajax.send(formData);
                    //En caso que cancele ya una vez baneado eliminamos tambien la denuncia
                }
            });
        }
    });
}

function eliminar(id_denuncia, demandante) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    formData.append('id_denuncia', id_denuncia);
    formData.append('nick_usu', demandante);
    let ajax = llamadaAjax();
    ajax.open("POST", "moderador/eliminar", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                alertify.success("Denuncia eliminada correctamente");
                showAll();
            } else {
                console.log(respuesta.resultado);
            }
        }
    }
    ajax.send(formData);
}

function opcionesComentario(id_denuncia, acusado) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    formData.append('id_denuncia', id_denuncia);
    formData.append('nick_usu', acusado);
    let ajax = llamadaAjax();
    Swal.fire({
        title: "Opciones denuncia",
        text: "¿Que deseas hacer?",
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: "Eliminar contenido",
        denyButtonText: "Banear usuario",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        //Elimina el contenido despues del ajax ejecutamos el swal
        if (result.isConfirmed) {
            ajax.open("POST", "moderador/eliminarcontent", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "OK") {
                        alertify.success("Contenido eliminado correctamente");
                        //Preguntamos si tambien quiere banear al usuario
                        Swal.fire({
                            title: "Opciones denuncia",
                            text: "¿Deseas tambien denunciar al usuario?",
                            showCancelButton: true,
                            confirmButtonText: "Banear usuario",
                            cancelButtonText: "Cancelar"
                        }).then((result) => {
                            //Si quiere denunciar al usuario le mostramos un input en formato fecha ya que cogemos la hora actual del sistema
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "Opciones denuncia",
                                    text: "¿Hasta que día desea banearlo?",
                                    html: `<input type="date" id="fecha_denuncia"/>`,
                                    showCancelButton: true,
                                    confirmButtonText: "Enviar",
                                    cancelButtonText: "Cancelar",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        fechaDenuncia = document.getElementById("fecha_denuncia").value;
                                        formData.append("fecha_denuncia", fechaDenuncia);
                                        ajax.open("POST", "moderador/banearUser", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                let respuesta = JSON.parse(this.responseText);
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("Baneo realizado correctamente");
                                                    showComments();
                                                } else {
                                                    console.log(respuesta.resultado);
                                                }
                                            }
                                        }
                                        ajax.send(formData);
                                    }
                                });
                            } else if (result.isDismissed) {
                                showComments();
                            }
                        });
                    } else {
                        console.log(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
            //Decide banear
        } else if (result.isDenied) {
            Swal.fire({
                title: "Opciones denuncia",
                text: "¿Hasta que día desea banearlo?",
                html: `<input type="date" id="fecha_denuncia"/>`,
                showCancelButton: true,
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    //Ejecutamos ajax para banear
                    fechaDenuncia = document.getElementById("fecha_denuncia").value;
                    formData.append("fecha_denuncia", fechaDenuncia);
                    ajax.open("POST", "moderador/banearUser", true);
                    ajax.onreadystatechange = function() {
                        if (ajax.readyState == 4 && ajax.status == 200) {
                            let respuesta = JSON.parse(this.responseText);
                            if (respuesta.resultado == "OK") {
                                alertify.success("Baneo realizado correctamente");
                                //Preguntamos si tambien quiere eliminar el contenido
                                Swal.fire({
                                    title: "Opciones denuncia",
                                    text: "¿Deseas tambien eliminar el contenido?",
                                    showCancelButton: true,
                                    confirmButtonText: "Eliminar contenido",
                                    cancelButtonText: "Cancelar"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        ajax.open("POST", "moderador/eliminarcontent", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("Contenido eliminado correctamente");
                                                    showComments();
                                                }
                                            } else {
                                                console.log(respuesta.resultado);
                                            }
                                        }
                                        ajax.send(formData);
                                    } else if (result.isDismissed) {
                                        ajax.open("POST", "moderador/quitardenuncia", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("La denuncia se ha quitado");
                                                    showComments();
                                                } else {
                                                    console.log(respuesta.resultado);
                                                }
                                            }
                                        }
                                        ajax.send(formData);
                                    }
                                });
                            } else {
                                console.log(respuesta.resultado);
                            }
                        }
                    }
                    ajax.send(formData);
                    //En caso que cancele ya una vez baneado eliminamos tambien la denuncia
                }
            });
        }
    });
}

function eliminarComentario(id_denuncia, demandante) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    formData.append('id_denuncia', id_denuncia);
    formData.append('nick_usu', demandante);
    let ajax = llamadaAjax();
    ajax.open("POST", "moderador/eliminar", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                alertify.success("Denuncia eliminada correctamente");
                showComments();
            } else {
                console.log(respuesta.resultado);
            }
        }
    }
    ajax.send(formData);
}

function opcionesApunte(id_denuncia, acusado) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    formData.append('id_denuncia', id_denuncia);
    formData.append('nick_usu', acusado);
    let ajax = llamadaAjax();
    Swal.fire({
        title: "Opciones denuncia",
        text: "¿Que deseas hacer?",
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: "Eliminar contenido",
        denyButtonText: "Banear usuario",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        //Elimina el contenido despues del ajax ejecutamos el swal
        if (result.isConfirmed) {
            ajax.open("POST", "moderador/eliminarcontent", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "OK") {
                        alertify.success("Contenido eliminado correctamente");
                        //Preguntamos si tambien quiere banear al usuario
                        Swal.fire({
                            title: "Opciones denuncia",
                            text: "¿Deseas tambien denunciar al usuario?",
                            showCancelButton: true,
                            confirmButtonText: "Banear usuario",
                            cancelButtonText: "Cancelar"
                        }).then((result) => {
                            //Si quiere denunciar al usuario le mostramos un input en formato fecha ya que cogemos la hora actual del sistema
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "Opciones denuncia",
                                    text: "¿Hasta que día desea banearlo?",
                                    html: `<input type="date" id="fecha_denuncia"/>`,
                                    showCancelButton: true,
                                    confirmButtonText: "Enviar",
                                    cancelButtonText: "Cancelar",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        fechaDenuncia = document.getElementById("fecha_denuncia").value;
                                        formData.append("fecha_denuncia", fechaDenuncia);
                                        ajax.open("POST", "moderador/banearUser", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                let respuesta = JSON.parse(this.responseText);
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("Baneo realizado correctamente");
                                                    showNotes();
                                                } else {
                                                    console.log(respuesta.resultado);
                                                }
                                            }
                                        }
                                        ajax.send(formData);
                                    }
                                });
                            } else if (result.isDismissed) {
                                showNotes();
                            }
                        });
                    } else {
                        console.log(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
            //Decide banear
        } else if (result.isDenied) {
            Swal.fire({
                title: "Opciones denuncia",
                text: "¿Hasta que día desea banearlo?",
                html: `<input type="date" id="fecha_denuncia"/>`,
                showCancelButton: true,
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    //Ejecutamos ajax para banear
                    fechaDenuncia = document.getElementById("fecha_denuncia").value;
                    formData.append("fecha_denuncia", fechaDenuncia);
                    ajax.open("POST", "moderador/banearUser", true);
                    ajax.onreadystatechange = function() {
                        if (ajax.readyState == 4 && ajax.status == 200) {
                            let respuesta = JSON.parse(this.responseText);
                            if (respuesta.resultado == "OK") {
                                alertify.success("Baneo realizado correctamente");
                                //Preguntamos si tambien quiere eliminar el contenido
                                Swal.fire({
                                    title: "Opciones denuncia",
                                    text: "¿Deseas tambien eliminar el contenido?",
                                    showCancelButton: true,
                                    confirmButtonText: "Eliminar contenido",
                                    cancelButtonText: "Cancelar"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        ajax.open("POST", "moderador/eliminarcontent", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("Contenido eliminado correctamente");
                                                    showNotes();
                                                }
                                            } else {
                                                console.log(respuesta.resultado);
                                            }
                                        }
                                        ajax.send(formData);
                                    } else if (result.isDismissed) {
                                        ajax.open("POST", "moderador/quitardenuncia", true);
                                        ajax.onreadystatechange = function() {
                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                if (respuesta.resultado == "OK") {
                                                    alertify.success("La denuncia se ha quitado");
                                                    showNotes();
                                                } else {
                                                    console.log(respuesta.resultado);
                                                }
                                            }
                                        }
                                        ajax.send(formData);
                                    }
                                });
                            } else {
                                console.log(respuesta.resultado);
                            }
                        }
                    }
                    ajax.send(formData);
                    //En caso que cancele ya una vez baneado eliminamos tambien la denuncia
                }
            });
        }
    });
}

function eliminarApunte(id_denuncia, demandante) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    formData.append('id_denuncia', id_denuncia);
    formData.append('nick_usu', demandante);
    let ajax = llamadaAjax();
    ajax.open("POST", "moderador/eliminar", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                alertify.success("Denuncia eliminada correctamente");
                showNotes();
            } else {
                console.log(respuesta.resultado);
            }
        }
    }
    ajax.send(formData);
}
setCookie("darkmode", 1, 365);