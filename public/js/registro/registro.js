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
        document.getElementById("clickselec").value = "AVATAR SELECCIONADO ✔";
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
    let image = document.getElementById("img_avatar_usu").files;
    if (avatar == "" && image.length == 0) {
        alert("Selecciona avatar o imagen");
        return false;
    } else {
        return true;
    }
}