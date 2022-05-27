<!--TEMPLATE DE HEADER-->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">

    <title>NoteHub Chat</title>
    <link rel="shortcut icon" href="{{asset('storage/uploads/logo/favicon.png')}}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/chat/style.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/chat/app.js') }}" defer></script>
    <!-- SweetAlert hay que implementar template de header -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/chat/chatAjax.js') }}" defer></script>
    {{-- @livewireStyles --}}
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!--METER NUESTRO MENU AQUÍ-->
        {{-- @include('layouts.navigation') --}}

        <!-- Page Content -->
        <main>
            {{ $slot ?? '' }}
        </main>
    </div>
    @livewireScripts
</body>

</html>
