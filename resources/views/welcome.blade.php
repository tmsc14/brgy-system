<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Information and Records Management System</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/sass/welcome.scss'])
</head>

<body>
    <x-login.card-with-logo>
        <div class="button-group d-flex flex-column px-3 align-items-center gap-3 col-7">
            <x-welcome-button onClick="location.href='{{ route('barangay_captain.login') }}" text='Barangay Captain Login' />
            <x-welcome-button onClick="location.href='{{ route('barangay_roles.showSelectRole') }}" text='Sign Up' />
            <x-welcome-button onClick="location.href='{{ route('barangay_roles.showUnifiedLogin') }}" text='Login' />
            <x-welcome-button onClick="location.href='#'" text='Other' />
        </div>
    </x-login.card-with-logo>
</body>

</html>
