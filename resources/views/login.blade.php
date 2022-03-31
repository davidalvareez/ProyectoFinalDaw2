<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form action="{{url('login')}}" method="post">
        @csrf
        <label for="">Correo/Nick</label>
        <input type="text" name="correo_nick" id="">
        <label for="">Contraseña</label>
        <input type="password" name="contra_usu" id="">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>