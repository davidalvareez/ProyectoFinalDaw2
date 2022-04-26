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

function addcomment() {
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
                    recarga += `<img src="../storage/${respuesta.comentarios[i].img_avatar}" alt="">
                    <h1>${respuesta.comentarios[i].nick_usu}</h1>
                    <div class="nota-resta">
                        <label class="rating-label">
                            <input
                              class="rating"
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
                    <p>${respuesta.comentarios[i].desc_comentario}</p>`;
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