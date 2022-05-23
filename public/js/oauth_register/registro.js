window.onload = function() {

    var modal = document.getElementById("myModal2");
    modal.style.display = "block";

    var resgitroProf = document.getElementById("idRegister2");
    resgitroProf.style.display = "none";
}

$(document).ready(function() {
    var zindex = 10;

    $("div.cardregistro").click(function(e) {
        e.preventDefault();

        var isShowing = false;

        if ($(this).hasClass("show")) {
            isShowing = true
        }

        if ($("div.cardsregistro").hasClass("showing")) {
            // a card is already in view
            $("div.cardregistro.show")
                .removeClass("show");

            if (isShowing) {
                // this card was showing - reset the grid
                $("div.cardsregistro")
                    .removeClass("showing");
            } else {
                // this card isn't showing - get in with it
                $(this)
                    .css({ zIndex: zindex })
                    .addClass("show");

            }

            zindex++;

        } else {
            // no cards in view
            $("div.cardsregistro")
                .addClass("showing");
            $(this)
                .css({ zIndex: zindex })
                .addClass("show");

            zindex++;
        }

    });
});


function modalProfe() {
    var modal = document.getElementById("idRegister");
    modal.style.display = "none";

    var resgitroProf = document.getElementById("idRegister2");
    resgitroProf.style.display = "block";
}

function modalbox() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

function closeModalSeleccion() {
    var modal = document.getElementById("myModal2");
    modal.style.display = "none";
}

function closeModal2() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
    let avatar = document.getElementById("img_avatar_sistema").value;
    let avatarprofe = document.getElementById("img_avatar_sistema_profe").value;
    let image = document.getElementById("img_avatar_usu").files;
    if (avatar == "" && image.length == 0 || avatarprofe == "" && image.length == 0) {
        return false;
    } else {
        document.getElementById("clickselec").value = "AVATAR SELECCIONADO ✔";
        alertify.success("AVATAR SELECCIONADO ✔");
        let image2 = document.getElementById("img_avatar_usu2").files = image;
        let image3 = document.getElementById("img_avatar_usu_profe").files = image;
        console.log(image3);
        return true;
    }
}

function avatarSelected(img_avatar) {
    /* console.log(img_avatar); */
    document.getElementById("img_avatar_sistema").value = img_avatar;
    document.getElementById("img_avatar_sistema_profe").value = img_avatar
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
    let nombre = document.getElementById("nick_usu").value;
    let image = document.getElementById("img_avatar_usu").files;
    if (avatar == "" && image.length == 0) {
        alertify.error("Selecciona avatar o imagen");
        return false;
    } else {
        return true;
    }
}