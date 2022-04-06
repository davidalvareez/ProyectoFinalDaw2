function modalbox() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

function avatarSelected(img_avatar) {
    console.log(img_avatar);
    document.getElementById("img_avatar_sistema").value = img_avatar;
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