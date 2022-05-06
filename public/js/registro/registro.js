window.onload = function() {
    document.getElementById("img_avatar_usu2").style.display = "none";

    var modal = document.getElementById("myModal2");
    //modal.style.display = "block";
}

$(document).ready(function() {
    var zindex = 10;

    $("div.card").click(function(e) {
        e.preventDefault();

        var isShowing = false;

        if ($(this).hasClass("show")) {
            isShowing = true
        }

        if ($("div.cards").hasClass("showing")) {
            // a card is already in view
            $("div.card.show")
                .removeClass("show");

            if (isShowing) {
                // this card was showing - reset the grid
                $("div.cards")
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
            $("div.cards")
                .addClass("showing");
            $(this)
                .css({ zIndex: zindex })
                .addClass("show");

            zindex++;
        }

    });
});



function modalbox() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

function closeModal2() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
    let avatar = document.getElementById("img_avatar_sistema").value;
    let image = document.getElementById("img_avatar_usu").files;
    if (avatar == "" && image.length == 0) {
        return false;
    } else {
        console.log(image);
        document.getElementById("clickselec").value = "AVATAR SELECCIONADO ✔";
        alertify.success("AVATAR SELECCIONADO ✔");
        let image2 = document.getElementById("img_avatar_usu2").files = image;
        console.log(image2);
        return true;
    }
}

function avatarSelected(img_avatar) {
    console.log(img_avatar);
    document.getElementById("img_avatar_sistema").value = img_avatar;
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
    console.log(nombre);
    let image = document.getElementById("img_avatar_usu").files;
    if (avatar == "" && image.length == 0) {
        alertify.error("Selecciona avatar o imagen");
        return false;
    } else {
        return true;
    }
}