<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
        @if($errors->any())
            @error('nombre_usu')
            <p>{{$message}}</p>
            @enderror
        @endif    
<form action="{{url('register')}}" method="post">
        @csrf
        <label for="">Nombre</label>
        <input type="text" name="nombre_usu" id="">
        <label for="">Apellido</label>
        <input type="text" name="apellido_usu" id="">
        <label for="">Nickname</label>
        <input type="text" name="nick_usu" id="">
        <label for="">Fecha de nacimiento</label>
        <input type="date" name="fecha_nac_usu" id="">
        <label for="">Correo</label>
        <input type="text" name="correo_usu" id="">
        <label for="">Contraseña</label>
        <input type="password" name="contra_usu" id="">
        <label for="">Verificar contraseña</label>
        <input type="password" name="contra_usu_verify" id="">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>