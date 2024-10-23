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
    <div class="d-flex w-100">
        <div
            class="col-2 bg-brown-primary text-brown-secondary d-flex flex-column align-items-center p-2 full-view-height justify-content-between">
            <div class="text-center mb-2">
                <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="w-50 h-auto">
            </div>
            <x-sidebar-logo />
            @if ($_user_role == 'Captain')
                @include('layouts.partials.sidebar_barangay_captain')
            @elseif ($_user_role == 'Official')
                @include('layouts.partials.sidebar_barangay_official')
            @elseif($_user_role == 'Staff')
                @include('layouts.partials.sidebar_staff')
            @elseif($_user_role == 'Resident')
                @include('layouts.partials.sidebar_resident')
            @endif
            <form class="w-100" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="d-flex justify-content-center btn btn-secondary-brown w-100">
                    <img src="{{ asset('resources/img/sidebar-icons/logout-sblogo.png') }}" class="icon"
                        alt="Logout Icon">
                    <span>Logout</span>
                </button>
            </form>
        </div>
        <div class="bg-brown-secondary col-10">
            <div class="d-flex align-items-center text-center gap-2 p-3 border-bottom border-secondary">
                <span class="fs-1">Hello, {{ $_user_role == 'Resident' ? Auth::user()->resident->first_name : Auth::user()->staff->first_name }}!</span>
                <div class="date">
                    <img src="{{ asset('resources/img/header-date.png') }}" class="icon" alt="Date Icon">
                    {{ now()->timezone('Asia/Manila')->format('F d, Y') }}
                </div>
            </div>
            <div class="p-3">
                @yield('content')
                {{ $slot ?? null }}
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
