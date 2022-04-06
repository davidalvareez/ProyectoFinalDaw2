<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../public/js/registro/registro.js"></script>
    <link rel="stylesheet" href="../public/css/registro/registro.css">
    <title>Register</title>
</head>
<body>
        @if($errors->any())
            @error('nombre_usu')
            <p>{{$message}}</p>
            @enderror
            @error('apellido_usu')
            <p>{{$message}}</p>
            @enderror
            @error('nick_usu')
            <p>{{$message}}</p>
            @enderror
            @error('fecha_nac_usu')
            <p>{{$message}}</p>
            @enderror
            @error('centro')
            <p>{{$message}}</p>
            @enderror
            @error('correo_usu')
            <p>{{$message}}</p>
            @enderror
            @error('contra_usu')
            <p>{{$message}}</p>
            @enderror
            @error('contra_usu_verify')
            <p>{{$message}}</p>
            @enderror
        @endif  

    <form action="{{url('register')}}" onsubmit="return hasAvatarOrImage();" method="post" enctype="multipart/form-data">
        @csrf
        <label for="">Nombre</label>
        <input type="text" name="nombre_usu" id="">
        <label for="">Apellido</label>
        <input type="text" name="apellido_usu" id="">
        <label for="">Nickname</label>
        <input type="text" name="nick_usu" id="">
        <label for="">Fecha de nacimiento</label>
        <input type="date" name="fecha_nac_usu" id="">
        <label for="">Centro</label>
            <select name="centro" id="">
                <option value="">--</option>
                @foreach($centros as $centro)
                    <option value="{{$centro->id}}">{{$centro->nombre_centro}}</option>
                @endforeach
            </select>
        <label for="">Correo</label>
        <input type="text" name="correo_usu" id="">
        <label for="">Contraseña</label>
        <input type="password" name="contra_usu" id="">
        <label for="">Verificar contraseña</label>
        <input type="password" name="contra_usu_verify" id="">
        <div id="myModal" class="modal">
            <div class="modal-content">
                <h1>Escoge tu avatar</h1>
                <span class="close" onclick="closeModal();">&times;</span>
                @foreach($avatares as $avatar)
                    <button onclick="closeModal();avatarSelected('{{$avatar->img_avatar}}');return false;"><img src={{asset('storage').'/'.$avatar->img_avatar}} width="100px" height="100px"></button>
                    <p>{{$avatar->img_avatar}}</p>
                @endforeach
                <input type="file" name="img_avatar_usu" id="img_avatar_usu">
            </div>
        </div>
        <label for="">Selecciona tu avatar</label>
        <button type="submit" value="avatar" onclick="modalbox();return false;">Avatar</button>
        <input type="hidden" name="img_avatar_sistema" id="img_avatar_sistema" value="">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>