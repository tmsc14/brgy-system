<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/sass/welcome.scss'])
    @stack('styles')
</head>

<body class="vh-100 d-flex flex-column">
    @yield('content')
    {{ $slot ?? null }}

    @stack('scripts')
</body>
</html>
