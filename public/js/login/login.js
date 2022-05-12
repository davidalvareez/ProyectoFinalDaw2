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

function forgetPassword() {
    Swal.fire({
        title: "Contraseña olvidada",
        text: "Introduce tu correo o nick",
        input: 'text',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            let token = document.getElementById('token').getAttribute("content");
            let formData = new FormData();
            formData.append('_token', token);
            formData.append('_method', 'POST');
            formData.append('nick_correo', result.value);
            let ajax = llamadaAjax();
            ajax.open("POST", "mailcambiarPass", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "NotExist") {
                        alertify.error("El correo o el nick no existe");
                    } else {
                        alertify.error(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
        }
    });
}