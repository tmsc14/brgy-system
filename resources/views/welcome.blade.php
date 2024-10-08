<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Information and Records Management System</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/sass/welcome.scss'])
</head>

<body>
    <div class="row g-0 align-items-center justify-content-center h-100 bg-brown-secondary px-4">
        <div class="col-12 col-md-8 col-lg-6 col-xl-4 ">
            <div class="card bg-brown-primary h-sm-100" style="border-radius: 1rem;">
                <div class="card-body d-flex flex-column align-items-center mb-4">
                    <img class="img-fluid" src="{{ url('resources/img/logo.png') }}" alt="">
                    <div class="button-group d-flex flex-column w-100 px-3 align-items-center gap-3">
                        <x-welcome-button onClick="location.href='{{ route('barangay_captain.login') }}" text='Barangay Captain Login' />
                        <x-welcome-button onClick="location.href='{{ route('barangay_roles.showSelectRole') }}" text='Sign Up' />
                        <x-welcome-button onClick="location.href='{{ route('barangay_roles.showUnifiedLogin') }}" text='Login' />
                        <x-welcome-button onClick="location.href='#'" text='Other' />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
