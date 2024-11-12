<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        :root {
            --brgy-background-color: {{ session('background_color', config('theme.default_background_color')) }};
            --brgy-primary-color: {{ session('primary_color', config('theme.default_primary_color')) }};
            --brgy-secondary-color: {{ session('secondary_color', config('theme.default_secondary_color')) }};
            --brgy-text-color: {{ session('primary_text_color', config('theme.default_text_color')) }};
            --brgy-content-color: {{ session('content_color', config('theme.default_text_color')) }};
            --brgy-content-text-color: {{ session('content_text_color', config('theme.default_text_color')) }};
            --brgy-highlight-text-color: {{ session('highlighted_text_color', config('theme.default_text_color')) }};
            --brgy-background-text-color: {{ session('background_text_color', config('theme.default_background_color')) }};
            --brgy-primary-text-color: {{ session('primary_text_color', config('theme.default_text_color')) }};
            --brgy-primary-text-hover-color: {{ session('primary_text_hover_color', config('theme.default_text_color')) }};
            --brgy-primary-hover-color: {{ session('primary_hover_color', config('theme.default_text_color')) }};
            --brgy-secondary-text-color: {{ session('secondary_text_color', config('theme.default_secondary_color')) }};
            --brgy-secondary-hover-color: {{ session('secondary_hover_color', config('theme.default_text_color')) }};

            --bs-body-bg: {{ session('background_color', config('theme.default_background_color')) }} !important;
            /* --bs-body-color: {{ session('primary_text_color', config('theme.default_text_color')) }} !important; */
        }
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/sass/welcome.scss'])
    @stack('styles')
</head>

<body class="vh-100 d-flex flex-column">
    <div class="d-flex w-100">
        {{-- Mobile --}}
        <x-sidebar-container :id="'brgy-sidebar'" :containerClass="'d-flex d-sm-none col-1 offcanvas offcanvas-start brgy-bg-primary brgy-color-secondary flex-column align-items-center p-2 full-view-height justify-content-between border-end border-secondary'" />
        {{-- Desktop --}}
        <x-sidebar-container :id="'brgy-sidebar-desktop'" :containerClass="'d-none d-sm-flex col-2 brgy-bg-primary brgy-color-secondary flex-column align-items-center p-2 full-view-height justify-content-between border-end border-secondary'" />

        <div class="col-12 col-sm-10 overflow-auto vh-100 brgy-bg-theme">
            <div class="d-flex d-sm-none brgy-bg-primary align-items-center position-relative p-3">
                <a href="#brgy-sidebar" data-bs-toggle="offcanvas">
                    <x-gmdi-menu class="icon brgy-color-secondary clickable" />
                </a>
                <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo"
                    class="w-25 h-auto position-absolute top-50 start-50 translate-middle">
            </div>
            <div
                class="d-none d-sm-flex align-items-center text-center gap-2 p-3 border-bottom border-secondary brgy-header brgy-theme-text">
                <span class="fs-1">Hello,
                    {{ $_user_role == 'Resident' ? Auth::user()->resident->first_name : Auth::user()->staff->first_name }}!</span>
                <div class="date ">
                    <img src="{{ asset('resources/img/header-date.png') }}" class="icon" alt="Date Icon">
                    {{ now()->timezone('Asia/Manila')->format('F d, Y') }}
                </div>
            </div>
            <div class="p-3 brgy-theme-text">
                @yield('content')
                {{ $slot ?? null }}
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
