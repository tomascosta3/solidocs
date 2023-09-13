<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fullcalendar.io/releases/fullcalendar/5.9.0/main.min.css' rel='stylesheet' />
    <script src='https://fullcalendar.io/releases/fullcalendar/5.9.0/main.min.js'></script>
    <title>@yield('title')</title>

    @vite('resources/css/app.css')

    @yield('style')

</head>
<body>

    @yield('content')

    @yield('scripts')

</body>
</html>