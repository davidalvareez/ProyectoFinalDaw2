<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <script src="{!! asset('js/admin/adminAjax.js') !!}"></script>
    <title>Admin CPanel</title>
</head>
<body>
    <div>
        <button onclick="showUsers();return false">Users</button>
        <button onclick="showCentros();return false">Centros</button>
        <button onclick="showApuntes();return false">Apuntes</button>
        <button onclick="showDenuncias();return false">Denuncias</button>
        <button onclick="showHistorial();return false">Historial</button>
    </div>
    <div id="content"></div>
</body>
</html>
