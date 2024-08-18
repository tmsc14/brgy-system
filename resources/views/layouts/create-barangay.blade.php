<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Barangay - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('resources/css/create_barangay/create-barangay.css') }}">
    @yield('css')
</head>
<body>
    <div class="create-barangay-container">
        <div class="header">
            <h1 class="title">Create your own <img src="{{ asset('resources/img/logo2.png') }}" alt="Brgy+ Logo" class="brgy-logo"></h1>
        </div>
        <div class="tabs">
            <a href="{{ route('barangay_captain.create_barangay_info_form') }}" class="{{ request()->is('barangay_info') ? 'active' : '' }}">Barangay Info</a>
            <a href="{{ route('barangay_captain.appearance_settings') }}" class="{{ request()->is('barangay_appearance') ? 'active' : '' }}">Appearances</a>
            <a href="{{ route('barangay_captain.features_settings')}}" class="{{ request()->is('barangay_features') ? 'active' : '' }}">Features</a>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
    @yield('scripts')
</body>
</html>
