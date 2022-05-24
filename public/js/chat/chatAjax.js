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

function closeChat(id) {
    Swal.fire({
        title: "¿Deseas eliminar el chat?",
        showCancelButton: true,
        confirmButtonText: "Eliminar chat",
        cancelButtonText: "Cancelar",
        icon: "warning"
    }).then((result) => {
        if (result.isConfirmed) {
            let token = document.getElementById('token').getAttribute("content");
            let formData = new FormData();
            formData.append('_token', token);
            formData.append('_method', 'POST');
            formData.append("id_friend", id);
            let ajax = llamadaAjax();
            ajax.open("POST", "deleteChat", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    var respuesta = JSON.parse(this.responseText);
                    if (respuesta.resultado == "OK") {
                        window.location.href = '../notehub-chat';
                    } else {
                        console.log(respuesta.resultado);
                    }
                }
            }
            ajax.send(formData);
        }
    })
}