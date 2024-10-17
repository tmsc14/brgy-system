<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Information and Records Management System</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/sass/welcome.scss'])
</head>

<body class="vh-100 d-flex flex-column">
    <x-login.card-with-logo>
        <div class="button-group d-flex flex-column px-3 align-items-center gap-3 w-100">
            <x-welcome-button onClick="location.href='{{ route('register.barangay-captain') }}" text='Register New Barangay' />
            <x-welcome-button onClick="location.href='{{ route('login.staff') }}" text='Barangay Staff Login' />
            <x-welcome-button onClick="location.href='{{ route('login.resident') }}" text='Resident Login' />
        </div>
    </x-login.card-with-logo>
</body>

</html>
